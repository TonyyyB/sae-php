<?php

namespace Iuto\SaePhp\DataSources;

use Iuto\SaePhp\Model\Restaurant;
use Iuto\SaePhp\Model\Cuisine;
use Iuto\SaePhp\Model\Avis;

class JsonProvider
{
    private string $jsonFilePath;
    private array $restaurants = [];
    private array $types = [];
    private array $cuisines = [];
    private array $options = [
        "wheelchair" => "Accessibilité fauteuil roulant",
        "vegetarian" => "Végétarien",
        "vegan" => "Végan",
        "delivery" => "Livraison"
    ];

    public function __construct(string $jsonFilePath)
    {
        $this->jsonFilePath = $jsonFilePath;
    }

    public function loadRestaurants(int $nb = -1): array
    {
        if (!file_exists($this->jsonFilePath)) {
            throw new \Exception("Le fichier JSON n'existe pas.");
        }

        $jsonData = file_get_contents($this->jsonFilePath);

        $data = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Erreur de décodage JSON: " . json_last_error_msg());
        }

        $this->restaurants = [];

        if ($nb === -1) {
            foreach ($data as $restaurantData) {
                $this->restaurants[] = $this->mapToRestaurant($restaurantData);
            }
        } else {
            for ($i = 0; $i < min($nb, count($data)); $i++) {
                $this->restaurants[] = $this->mapToRestaurant($data[$i]);
            }
        }

        $this->restaurants[0]->addAvis(new Avis("Moi", "Pas ouf", 1));
        $this->restaurants[0]->addAvis(new Avis("Mon ami", "Super", 5));
        $this->restaurants[0]->addAvis(new Avis("Mon ami", "Mieux", 4));

        return $this->restaurants;
    }

    public function getById(string $id): ?Restaurant
    {
        if (!file_exists($this->jsonFilePath)) {
            throw new \Exception("Le fichier JSON n'existe pas.");
        }

        $jsonData = file_get_contents($this->jsonFilePath);
        $data = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Erreur de décodage JSON: " . json_last_error_msg());
        }

        if(str_starts_with($id, "node/")) {
            $id = substr($id, 5);
        }

        foreach ($data as $restaurantData) {
            if (substr($restaurantData['osm_id'], 5) === $id) {
                $restau = $this->mapToRestaurant($restaurantData);
                $restau->addAvis(new Avis("Moi", "Pas ouf", 1));
                $restau->addAvis(new Avis("Mon ami", "Super", 5));
                $restau->addAvis(new Avis("Mon ami", "Mieux", 4));
                return $restau;
            }
        }
        return null;
    }

    private function mapToRestaurant(array $restaurantData): Restaurant
    {
        return new Restaurant(
            $restaurantData['geo_point_2d']['lon'],
            $restaurantData['geo_point_2d']['lat'],
            str_starts_with($restaurantData['osm_id'], 'node/') ? substr($restaurantData['osm_id'], 5) : $restaurantData['osm_id'],
            $restaurantData['type'],
            $restaurantData['name'],
            $restaurantData['operator'] ?? null,
            $restaurantData['brand'] ?? null,
            $restaurantData['opening_hours'],
            $this->mapToBoolean($restaurantData['wheelchair']),
            $restaurantData['cuisine'] ?? [],
            $this->mapToBoolean($restaurantData['vegetarian']),
            $this->mapToBoolean($restaurantData['vegan']),
            $this->mapToBoolean($restaurantData['delivery']),
            $this->mapToBoolean($restaurantData['takeaway']),
            $restaurantData['capacity'] ?? null,
            $this->mapToBoolean($restaurantData['drive_through']),
            $this->normalizePhoneNumber($restaurantData['phone']),
            $restaurantData['website'],
            $restaurantData['facebook'] ?? null,
            $restaurantData['region'],
            $restaurantData['departement'],
            $restaurantData['commune']
        );
    }

    private function mapToBoolean(?string $value): ?bool
    {
        if ($value === null) {
            return null;
        }
        return $value === 'yes';
    }

    private function normalizePhoneNumber(string|null $phone): ?string
    {
        if ($phone === null) {
            return null;
        }
        return preg_replace('/\s+/', '', $phone);
    }

    public function getCuisines(bool $forceLoad = false): array
    {
        if (!isset($this->cuisines) || $forceLoad) {
            $this->loadRestaurants();
        }
        $this->cuisines = [];
        foreach ($this->restaurants as $restaurant) {
            $this->cuisines = array_unique(array_merge($this->cuisines, $restaurant->getCuisine()), SORT_REGULAR);
        }
        return $this->cuisines;
    }

    public function getTypes(bool $forceLoad = false): array
    {
        if (!isset($this->types) || $forceLoad) {
            $this->loadRestaurants();
        }
        $this->types = [];
        foreach ($this->restaurants as $restaurant) {
            $this->types[] = $restaurant->getType();
            $this->types = array_unique($this->types, SORT_REGULAR);
        }
        return $this->types;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
