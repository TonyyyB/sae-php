<?php

namespace Iuto\SaePhp\Model;

class Restaurant
{
    private string $osmId;
    private float $longitude;
    private float $latitude;
    private string $type;
    private string $name;
    private ?string $operator;
    private ?string $brand;
    private ?array $openingHours;
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
    private ?array $avis;

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

    public function setAvis(array $avis): void
    {
        $this->avis = $avis;
    }

    public function getAvis(): ?array
    {
        return $this->avis;
    }

    public function addAvis(Avis $avis): void
    {
        $this->avis[] = $avis;
    }


    private function normalizePhoneNumber(?string $phone): ?string
    {
        if ($phone === null) {
            return null;
        }
        return preg_replace('/\s+/', '', $phone);
    }

    function parseOpeningHours(?string $openingHours): ?array
    {
        if ($openingHours === null) {
            return null;
        }
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

    public function renderOpeningHours(bool $pretty = false): string
    {
        $html = "<table class='opening-hours-table ".($pretty ? "opening-hours-table-pretty" : "")."'>";
        if(empty($this->openingHours)) {
            $html .= "<tr><td colspan='2'>Non renseigné</td></tr></table>";
            return $html;
        }
        $dayMap = [
            0 => "Lundi",
            1 => "Mardi",
            2 => "Mercredi",
            3 => "Jeudi",
            4 => "Vendredi",
            5 => "Samedi",
            6 => "Dimanche",
        ];
        foreach ($this->openingHours as $day => $hours) {
            $class = ($pretty ? ("opening-hours-row-" . ($day % 2 == 0 ? "even" : "odd")) : "");
            $parts = explode(",", $hours);
            $html .= "<tr class='". $class."'>";
            $html .= "<td rowspan=".count($parts).">" . $dayMap[$day] . "</td>";
            if($hours === ""){
                $html .= "<td>Fermé</td>";
                $html .= "</tr>";
                continue;
            }
            $html .= "<td>" . $parts[0] . "</td></tr>";
            if(count($parts) > 1){
                array_shift($parts);
                foreach ($parts as $part) {
                    $html .= "<tr class='".$class."'><td>" . $part . "</td></tr>";
                }
            }
            $html .= "</tr>";
        }
        $html .= "</table>";
        return $html;
    }

    public function renderCard(): string
    {
        $html = "<div class='restaurant-card'>";
        $html .= "<a class='restaurant-card-detail' href='/detail?id=" . $this->osmId . "'><h3>";
        $html .= ucfirst($this->getName());
        $html .= "</h3><a><p>Type : ";
        $html .= ucfirst(str_replace("_", " ", $this->getType()));
        $html .= "</p>";
        $html .= "<p>Horaires d'ouverture : ";
        $html .= $this->renderOpeningHours();
        $html .= "</p>";
        if (isset($this->cuisine) && sizeof($this->cuisine) > 0) {
            $html .= "<p>Cuisine : ";
            $html .= "<ul>";
            foreach ($this->cuisine as $cuisine) {
                $html .= "<li>" . ucfirst($cuisine) . "</li>";
            }
            $html .= "</ul>";
            $html .= "</p>";
        }
        if (isset($this->avis) && sizeof($this->avis) > 0) {
            $moyenne = array_sum(array_map(function ($a) {
                return $a->getNote();
            }, $this->avis)) / count($this->avis);
            $pourcentage = ($moyenne / 5) * 100;
            $html .= "<p>Note : " . round($moyenne, 2) . "/5</p>";
            $html .= "<div class='stars-container' style='width: 4.5em;'>";
            $html .= "<div class='stars-background'>";
            $html .= "★★★★★";
            $html .= "</div>";
            $html .= "<div class='stars-filled' style='width: " . $pourcentage . "%;'>";
            $html .= "★★★★★";
            $html .= "</div>";
            $html .= "</div>";
        }
        $html .= "</div>";
        return $html;
    }

    public function renderDetail(): string
    {
        $html = "<div class='restaurant-general'><div class='restaurant-info'><h1>" . htmlspecialchars($this->getName()) . "</h1>";
        $html .= "<p>Type : " . ucfirst(str_replace("_", " ", $this->getType())) . "</p>";

        if (isset($this->cuisine) && !empty($this->cuisine)) {
            $html .= "<h2>Cuisine :</h2>";
            $html .= "<ul>";
            foreach ($this->cuisine as $cuisine) {
                $html .= "<li>" . ucfirst($cuisine) . "</li>";
            }
            $html .= "</ul>";
        }

        if (isset($this->avis) && !empty($this->avis)) {
            $moyenne = array_sum(array_map(function ($a) {
                return $a->getNote();
            }, $this->avis)) / count($this->avis);
            $pourcentage = ($moyenne / 5) * 100;
            $html .= "<h2>Note moyenne :</h2>";
            $html .= "<p>" . round($moyenne, 2) . "/5</p>";
            $html .= "<div class='stars-container' style='width: 4.5em;'>";
            $html .= "<div class='stars-background'>";
            $html .= "★★★★★";
            $html .= "</div>";
            $html .= "<div class='stars-filled' style='width: " . $pourcentage . "%;'>";
            $html .= "★★★★★";
            $html .= "</div>";
            $html .= "</div>";
        }

        // Contact (téléphone et site web)
        if ($this->phone) {
            $html .= "<p><strong>Téléphone :</strong> <a href='tel:" . htmlspecialchars($this->phone) . "'>" . htmlspecialchars($this->phone) . "</a></p>";
        }
        if ($this->website) {
            $html .= "<p><strong>Site web :</strong> <a href='" . htmlspecialchars($this->website) . "' target='_blank'>" . htmlspecialchars($this->website) . "</a></p>";
        }

        $options = [];
        if ($this->vegetarian)
            $options[] = "Végétarien";
        if ($this->vegan)
            $options[] = "Végan";
        if ($this->delivery)
            $options[] = "Livraison disponible";
        if ($this->takeaway)
            $options[] = "À emporter disponible";
        if ($this->wheelchair)
            $options[] = "Accessible en fauteuil roulant";
        if (!empty($options)) {
            $html .= "<div class='restaurant-options'><p><strong>Options :</strong></p><ul>";
            foreach ($options as $option) {
                $html .= "<li>$option</li>";
            }
            $html .= "</ul></div>";
        }
        
        $html .= "</div><div class='restaurant-hours'>";
        $html .= "<h2>Horaires d'ouverture</h2>";
        $html .= $this->renderOpeningHours(true);
        $html .= "</div></div>";


        // Avis
        if (isset($this->avis) && sizeof($this->avis) > 0) {
            $html .= "<section class='avis-section'>";
            $html .= "<h3>Avis des utilisateurs</h3>";
            foreach ($this->avis as $avis) {
                $html .= $avis->render();
            }
            $html .= Avis::renderForm();
            $html .= "</section>";
        } else {
            $html .= "<p>Aucun avis pour le moment.</p>";
        }

        // Carte Google Maps
        $html .= "<div class='map-container'>";
        $html .= "<iframe
            src='https://www.google.com/maps?q=" . htmlspecialchars($this->name) . ",{$this->commune},{$this->departement},{$this->region}&output=embed'
            width='100%'
            height='300'
            frameborder='0'
            style='border:0'
            allowfullscreen
            aria-hidden='false'
            tabindex='0'></iframe>";
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

    public function getLatitude(): float
    {
        return $this->latitude;
    }
    public function getLongitude(): float
    {
        return $this->longitude;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getWebsite(): ?string
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
