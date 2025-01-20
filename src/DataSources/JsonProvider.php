<?php

namespace Iuto\SaePhp\DataSources;

use Iuto\SaePhp\Model\Restaurant;
use Iuto\SaePhp\Model\Cuisine;

class JsonProvider
{
    private string $jsonFilePath;

    public function __construct(string $jsonFilePath)
    {
        $this->jsonFilePath = $jsonFilePath;
    }

    public function loadRestaurants(): array
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

        foreach ($data as $restaurantData) {
            $restaurants[] = $this->mapToRestaurant($restaurantData);
        }

        return $restaurants;
    }

    private function mapToRestaurant(array $restaurantData): Restaurant
    {
        Cuisine::create("", "");
        return new Restaurant(
            $restaurantData['geo_point_2d']['lon'],
            $restaurantData['geo_point_2d']['lat'],
            $restaurantData['osm_id'],
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
            $restaurantData['internet_access'] ?? [],
            $restaurantData['stars'] ?? null,
            $restaurantData['capacity'] ?? null,
            $this->mapToBoolean($restaurantData['drive_through']),
            $restaurantData['wikidata'] ?? null,
            $restaurantData['brand_wikidata'] ?? null,
            $restaurantData['siret'],
            $this->normalizePhoneNumber($restaurantData['phone']),
            $restaurantData['website'],
            $restaurantData['facebook'] ?? null,
            $this->mapToBoolean($restaurantData['smoking']),
            $restaurantData['com_insee'],
            $restaurantData['com_nom'],
            $restaurantData['region'],
            $restaurantData['code_region'],
            $restaurantData['departement'],
            $restaurantData['code_departement'],
            $restaurantData['commune'],
            $restaurantData['code_commune'],
            $restaurantData['osm_edit']
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
