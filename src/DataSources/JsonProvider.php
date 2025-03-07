<?php

namespace Iuto\SaePhp\DataSources;

use Iuto\SaePhp\Model\Restaurant;
use Iuto\SaePhp\Model\Avis;
use Iuto\SaePhp\Model\User;

class JsonProvider
{
    private string $restaurantsFilePath = "../data/restaurants_orleans.json";
    private string $usersFilePath = "../data/users.json";
    private string $avisFilePath = "../data/avis.json";
    private array $restaurants = [];
    private array $types = [];
    private array $cuisines = [];
    private array $options = [
        "wheelchair" => "Accessibilité fauteuil roulant",
        "vegetarian" => "Végétarien",
        "vegan" => "Végan",
        "delivery" => "Livraison"
    ];

    public function __construct(string $jsonFilePath = "", string $usersFilePath = "", string $avisFilePath = "")
    {
        if(!empty($jsonFilePath)) $this->restaurantsFilePath = $jsonFilePath;
        if(!empty($usersFilePath)) $this->usersFilePath = $usersFilePath;
        if(!empty($avisFilePath)) $this->avisFilePath = $avisFilePath;
    }

    public function loadRestaurants(int $nb = -1, bool $loadAvis = true): array
    {
        if (!file_exists($this->restaurantsFilePath)) {
            throw new \Exception("Le fichier JSON n'existe pas.");
        }

        $jsonData = file_get_contents($this->restaurantsFilePath);

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

        if ($loadAvis) {
            foreach ($this->restaurants as $restaurant) {
                $avis = $this->getAvis($restaurant);
                $restaurant->setAvis($avis);
            }
        }

        return $this->restaurants;
    }

    public function getById(string $id, bool $loadAvis = false): ?Restaurant
    {
        if (!file_exists($this->restaurantsFilePath)) {
            throw new \Exception("Le fichier JSON n'existe pas.");
        }

        $jsonData = file_get_contents($this->restaurantsFilePath);
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
                if ($loadAvis) {
                    $avis = $this->getAvis($restau);
                    $restau->setAvis($avis);
                }
                return $restau;
            }
        }
        return null;
    }

    public function getAvis(Restaurant $restaurant): array
    {
        $result = [];
        $avis = json_decode(file_get_contents($this->avisFilePath), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Erreur de décodage JSON: " . json_last_error_msg());
        }

        foreach($avis as $currAvis){
            if($currAvis["idrestaurant"] == $restaurant->getOsmId()){
                $user = new User($currAvis["user"]["email"], $currAvis["user"]["nom"], $currAvis["user"]["prenom"], "");
                $toAdd = new Avis($user, $currAvis["commentaire"], $currAvis["note"], $restaurant);
                $result[] = $toAdd;
            }
        }
        return $result;
    }

    public function getAvisByUser(User $userRecherche): array
    {
        $result = [];
        $avis = json_decode(file_get_contents($this->avisFilePath), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Erreur de décodage JSON: " . json_last_error_msg());
        }

        foreach($avis as $currAvis){
            if($currAvis["user"]["email"] == $userRecherche->getEmail()){
                $user = $userRecherche;
                $toAddAvis = new Avis($user, $currAvis["commentaire"], $currAvis["note"], $this->getById($currAvis["idrestaurant"]));
                $result[] = $toAddAvis;
            }
        }
        return $result;
    }

    public function addAvis(Avis $avis): bool
    {
        $avisData = json_decode(file_get_contents($this->avisFilePath), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Erreur de décodage JSON: " . json_last_error_msg());
        }

        $avisData[] = [
            "idrestaurant" => $avis->getRestaurant()->getOsmId(),
            "user" => [
                "email" => $avis->getUser()->getEmail(),
                "nom" => $avis->getUser()->getNom(),
                "prenom" => $avis->getUser()->getPrenom()
            ],
            "commentaire" => $avis->getCommentaire(),
            "note" => $avis->getNote()
        ];

        file_put_contents($this->avisFilePath, json_encode($avisData, JSON_PRETTY_PRINT));
        return true;
    }

    public function addUser(User $user): bool
    {
        $users = json_decode(file_get_contents($this->usersFilePath), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Erreur de décodage JSON: " . json_last_error_msg());
        }

        foreach ($users as $currUser) {
            if ($currUser["email"] === $user->getEmail()) {
                return false;
            }
        }

        $users[] = $user->toArray();
        file_put_contents($this->usersFilePath, json_encode($users, JSON_PRETTY_PRINT));
        return true;
    }

    public function getUser(string $email, string $password): ?User
    {
        $users = json_decode(file_get_contents($this->usersFilePath), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Erreur de décodage JSON: " . json_last_error_msg());
        }

        $hashed = hash("sha256", $password);

        foreach ($users as $currUser) {
            if ($currUser["email"] === $email && $currUser["mdp"] === $hashed) {
                return User::fromArray($currUser);
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
