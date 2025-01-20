<?php
namespace Iuto\SaePhp\DataSources;
use Supabase\Functions as Supabase;
class DataBaseProvider
{
    private Supabase $client;
    public function __construct()
    {
        $this->client = new Supabase($_ENV['SB_URL'], $_ENV['SB_APIKEY']);
        print_r($this->getRestaurants());
    }

    public function getRestaurants(int $limit = 10): array
    {
        return $this->client->getAllData("restaurants");
    }

    private function mapToRestaurant(array $restaurantData): Restaurant
    {
        return new Restaurant(
            $restaurantData['longitude'],
            $restaurantData['latitude'],
            $restaurantData['osm_id'],
            $restaurantData['typeres'],
            $restaurantData['nomres'],
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