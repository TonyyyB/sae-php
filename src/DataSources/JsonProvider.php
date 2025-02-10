<?php

namespace Iuto\SaePhp\DataSources;

use Iuto\SaePhp\Model\Restaurant;
use Iuto\SaePhp\Model\Cuisine;
use Iuto\SaePhp\Model\Avis;

class JsonProvider
{
    private string $jsonFilePath;

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

        $restaurants = [];

        if ($nb === -1) {
            foreach ($data as $restaurantData) {
                $restaurants[] = $this->mapToRestaurant($restaurantData);
            }
        } else {
            for ($i = 0; $i < min($nb, count($data)); $i++) {
                $restaurants[] = $this->mapToRestaurant($data[$i]);
            }
        }

        $restaurants[0]->addAvis(new Avis("Moi", "Pas ouf", 1));
        $restaurants[0]->addAvis(new Avis("Mon ami", "Super", 5));
        $restaurants[0]->addAvis(new Avis("Mon ami", "Mieux", 4));

        return $restaurants;
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
}
