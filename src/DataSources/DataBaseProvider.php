<?php
namespace Iuto\SaePhp\DataSources;
use PDO;
class DataBaseProvider
{
    private PDO $pdo;
    public function __construct()
    {
        //$this->pdo = new PDO("postgresql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_DBNAME'] . ";", $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        //$this->pdo = new PDO("postgresql://postgres:saephp2025@db.ioebwciaykdpiupyefrc.supabase.co:5432/postgres");
        //print_r($this->getRestaurants());
        //phpinfo();
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