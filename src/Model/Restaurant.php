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
    private array $internetAccess;
    private ?string $stars;
    private ?string $capacity;
    private ?bool $driveThrough;
    private ?string $wikidata;
    private ?string $brandWikidata;
    private ?string $siret;
    private ?string $phone;
    private ?string $website;
    private ?string $facebook;
    private ?bool $smoking;
    private string $comInsee;
    private string $comNom;
    private string $region;
    private string $codeRegion;
    private string $departement;
    private string $codeDepartement;
    private string $commune;
    private string $codeCommune;
    private string $osmEdit;

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
        array $internetAccess,
        ?string $stars,
        ?string $capacity,
        ?bool $driveThrough,
        ?string $wikidata,
        ?string $brandWikidata,
        ?string $siret,
        ?string $phone,
        ?string $website,
        ?string $facebook,
        ?bool $smoking,
        string $comInsee,
        string $comNom,
        string $region,
        string $codeRegion,
        string $departement,
        string $codeDepartement,
        string $commune,
        string $codeCommune,
        string $osmEdit
    ) {
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->osmId = $osmId;
        $this->type = $type;
        $this->name = $name;
        $this->operator = $operator;
        $this->brand = $brand;
        $this->wheelchair = $wheelchair;
        $this->cuisine = $cuisine;
        $this->vegetarian = $vegetarian;
        $this->vegan = $vegan;
        $this->delivery = $delivery;
        $this->takeaway = $takeaway;
        $this->internetAccess = $internetAccess;
        $this->stars = $stars;
        $this->capacity = $capacity;
        $this->driveThrough = $driveThrough;
        $this->wikidata = $wikidata;
        $this->brandWikidata = $brandWikidata;
        $this->siret = $siret;
        $this->phone = $this->normalizePhoneNumber($phone);
        $this->website = $website;
        $this->facebook = $facebook;
        $this->smoking = $smoking;
        $this->comInsee = $comInsee;
        $this->comNom = $comNom;
        $this->region = $region;
        $this->codeRegion = $codeRegion;
        $this->departement = $departement;
        $this->codeDepartement = $codeDepartement;
        $this->commune = $commune;
        $this->codeCommune = $codeCommune;
        $this->osmEdit = $osmEdit;
    }

    private function normalizePhoneNumber(?string $phone): ?string
    {
        if ($phone === null) {
            return null;
        }
        return preg_replace('/\s+/', '', $phone);
    }

    public function parseOpeningHours(string|null $hours): array
    {
        if ($hours === null) {
            return [];
        }
        $daysOfWeek = [
            'Mo' => 'Lundi',
            'Tu' => 'Mardi',
            'We' => 'Mercredi',
            'Th' => 'Jeudi',
            'Fr' => 'Vendredi',
            'Sa' => 'Samedi',
            'Su' => 'Dimanche',
        ];

        $openingHours = [];
        $periods = explode(';', $hours);

        foreach ($periods as $period) {
            $parts = explode(' ', trim($period));
            $days = $parts[0];
            $times = $parts[1];

            if (strpos($days, '-') !== false) {
                list($startDay, $endDay) = explode('-', $days);
                $startIndex = array_search($startDay, array_keys($daysOfWeek));
                $endIndex = array_search($endDay, array_keys($daysOfWeek));

                for ($i = $startIndex; $i <= $endIndex; $i++) {
                    $openingHours[array_keys($daysOfWeek)[$i]] = $times;
                }
            } else {
                $openingHours[$days] = $times;
            }
        }

        $fullOpeningHours = [];
        foreach ($openingHours as $day => $time) {
            $fullOpeningHours[$daysOfWeek[$day]] = $time;
        }

        return $fullOpeningHours;
    }

    public function renderCard(): string
    {
        return "<div class='restaurant-card'>
                    <h3>" . ucfirst(str_replace("_", " ", $this->getName())) . "</h3>
                    <p>Type : " . ucfirst($this->getType()) . "</p>
                    <p>Note moyenne : ⭐⭐⭐⭐☆</p>
                </div>";
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

    public function getInternetAccess(): array
    {
        return $this->internetAccess;
    }

    public function getStars(): ?string
    {
        return $this->stars;
    }

    public function getCapacity(): ?string
    {
        return $this->capacity;
    }

    public function getDriveThrough(): ?bool
    {
        return $this->driveThrough;
    }

    public function getWikidata(): ?string
    {
        return $this->wikidata;
    }

    public function getBrandWikidata(): ?string
    {
        return $this->brandWikidata;
    }

    public function getSiret(): string
    {
        return $this->siret;
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

    public function getSmoking(): ?bool
    {
        return $this->smoking;
    }

    public function getComInsee(): string
    {
        return $this->comInsee;
    }

    public function getComNom(): string
    {
        return $this->comNom;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function getCodeRegion(): string
    {
        return $this->codeRegion;
    }

    public function getDepartement(): string
    {
        return $this->departement;
    }

    public function getCodeDepartement(): string
    {
        return $this->codeDepartement;
    }

    public function getCommune(): string
    {
        return $this->commune;
    }

    public function getCodeCommune(): string
    {
        return $this->codeCommune;
    }

    public function getOsmEdit(): string
    {
        return $this->osmEdit;
    }
}
