<?php

namespace Iuto\SaePhp\Model;

class Restaurant
{
    private float $longitude;
    private float $latitude;
    private string $osmId;
    private string $type;
    private string $name;
    private ?string $operator;
    private ?string $brand;
    private array $openingHours;
    private ?bool $wheelchair;
    private array $cuisine;
    private ?bool $vegetarian;
    private ?bool $vegan;
    private ?bool $delivery;
    private ?bool $takeaway;
    private ?string $capacity;
    private ?bool $driveThrough;
    private ?string $phone;
    private ?string $website;
    private ?string $facebook;
    private string $region;
    private string $departement;
    private string $commune;

    public function __construct(
        float $longitude,
        float $latitude,
        string $osmId,
        string $type,
        string $name,
        ?string $operator,
        ?string $brand,
        ?string $openingHours,
        ?bool $wheelchair,
        array $cuisine,
        ?bool $vegetarian,
        ?bool $vegan,
        ?bool $delivery,
        ?bool $takeaway,
        ?string $capacity,
        ?bool $driveThrough,
        ?string $phone,
        ?string $website,
        ?string $facebook,
        string $region,
        string $departement,
        string $commune
    ) {
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->osmId = $osmId;
        $this->type = $type;
        $this->name = $name;
        $this->operator = $operator;
        $this->brand = $brand;
        $this->openingHours = $this->parseOpeningHours($openingHours);
        $this->wheelchair = $wheelchair;
        $this->cuisine = $cuisine;
        $this->vegetarian = $vegetarian;
        $this->vegan = $vegan;
        $this->delivery = $delivery;
        $this->takeaway = $takeaway;
        $this->capacity = $capacity;
        $this->driveThrough = $driveThrough;
        $this->phone = $this->normalizePhoneNumber($phone);
        $this->website = $website;
        $this->facebook = $facebook;
        $this->region = $region;
        $this->departement = $departement;
        $this->commune = $commune;
    }

    private function normalizePhoneNumber(?string $phone): ?string
    {
        if ($phone === null) {
            return null;
        }
        return preg_replace('/\s+/', '', $phone);
    }

    function parseOpeningHours($openingHours)
    {
        // Initialiser un tableau de 7 jours de la semaine avec des valeurs vides
        $hours = array_fill(0, 7, "");

        // Associer les abréviations des jours de la semaine à leurs indices
        $dayMap = [
            "Mo" => 0,
            "Tu" => 1,
            "We" => 2,
            "Th" => 3,
            "Fr" => 4,
            "Sa" => 5,
            "Su" => 6,
        ];

        // Diviser l'entrée par les points-virgules pour séparer chaque plage de jours et horaires
        $segments = explode(';', $openingHours);

        foreach ($segments as $segment) {
            // Supprimer les espaces inutiles et diviser les jours et horaires
            $segment = trim($segment);
            if (!$segment)
                continue;

            list($daysPart, $hoursPart) = explode(' ', $segment, 2);

            // Vérifier si c'est une plage de jours ou un seul jour
            if (strpos($daysPart, '-') !== false) {
                // Plage de jours (ex: "Mo-Th")
                list($startDay, $endDay) = explode('-', $daysPart);
                $startIndex = $dayMap[$startDay];
                $endIndex = $dayMap[$endDay];

                // Remplir tous les jours de la plage avec les horaires
                for ($i = $startIndex; $i <= $endIndex; $i++) {
                    $hours[$i] = $hoursPart;
                }
            } elseif (strpos($daysPart, ',') !== false) {
                // Liste de jours séparés par des virgules (ex: "Mo,We,Fr")
                $individualDays = explode(',', $daysPart);
                foreach ($individualDays as $day) {
                    $dayIndex = $dayMap[$day];
                    $hours[$dayIndex] = $hoursPart;
                }
            } else {
                // Un seul jour (ex: "Fr")
                $dayIndex = $dayMap[$daysPart];
                $hours[$dayIndex] = $hoursPart;
            }
        }

        return $hours;
    }

    public function renderCard(): string
    {
        $html = "<div class='restaurant-card'>";
        $html .= "<h3>";
        $html .= ucfirst($this->getName());
        $html .= "</h3><p>Type : ";
        $html .= ucfirst(str_replace("_", " ", $this->getType()));
        $html .= "</p>";
        if (isset($this->openingHours)) {
            $dayMap = [
                0 => "Lundi",
                1 => "Mardi",
                2 => "Mercredi",
                3 => "Jeudi",
                4 => "Vendredi",
                5 => "Samedi",
                6 => "Dimanche",
            ];
            $html .= "<p>Horaires d'ouverture : ";
            $html .= "<ul>";
            foreach ($this->openingHours as $day => $hours) {
                $html .= "<li>" . $dayMap[$day] . " : " . ($hours ? $hours : "Fermé") . "</li>";
            }
            $html .= "</ul>";
            $html .= "</p>";
        }
        if (isset($this->cuisine)) {
            $html .= "<p>Cuisine : ";
            $html .= "<ul>";
            foreach ($this->cuisine as $cuisine) {
                $html .= "<li>" . ucfirst($cuisine) . "</li>";
            }
            $html .= "</ul>";
            $html .= "</p>";
        }
        $html .= "</div>";
        return $html;
    }

    public function getCoordinates(): array
    {
        return [
            'lat' => $this->latitude,
            'lon' => $this->longitude,
        ];
    }

    public function getOpeningHours(): array
    {
        return $this->openingHours;
    }

    public function getOsmId(): string
    {
        return $this->osmId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getOperator(): ?string
    {
        return $this->operator;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function getWheelchair(): ?bool
    {
        return $this->wheelchair;
    }

    public function getCuisine(): array
    {
        return $this->cuisine;
    }

    public function getVegetarian(): ?bool
    {
        return $this->vegetarian;
    }

    public function getVegan(): ?bool
    {
        return $this->vegan;
    }

    public function getDelivery(): ?bool
    {
        return $this->delivery;
    }

    public function getTakeaway(): ?bool
    {
        return $this->takeaway;
    }

    public function getCapacity(): ?string
    {
        return $this->capacity;
    }

    public function getDriveThrough(): ?bool
    {
        return $this->driveThrough;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function getDepartement(): string
    {
        return $this->departement;
    }

    public function getCommune(): string
    {
        return $this->commune;
    }

}
