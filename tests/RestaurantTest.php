<?php

namespace Iuto\SaePhp\Test\Model;

use Iuto\SaePhp\Model\Restaurant;
use PHPUnit\Framework\TestCase;

class RestaurantTest extends TestCase
{
    private Restaurant $restaurant;

    protected function setUp(): void
    {
        // Initialisation d'un restaurant pour les tests
        $this->restaurant = new Restaurant(
            9052942, // longitude
            90114979996115, // latitude
            "node/3422189698", // osmId
            "fast_food", // type
            "Cha+", // name
            null, // operator
            null, // brand
            "Tu-Sa 11:00-20:00; Su 13:00-20:00", // openingHours
            false, // wheelchair
            [], // cuisine
            false, // vegetarian
            false, // vegan
            false, // delivery
            false, // takeaway
            null, // capacity
            false, // driveThrough
            "+33 2 38 53 78 02", // phone
            "http://www.le-dream-s-coffee.com", // website
            null, // facebook
            "Centre-Val de Loire", // region
            "Loiret", // departement
            "Orléans" // commune
        );
    }

    public function testGetCoordinates(): void
    {
        $coordinates = $this->restaurant->getCoordinates();
        $this->assertSame(9052942.0, $coordinates['lon']);
        $this->assertSame(90114979996115.0, $coordinates['lat']);
    }

    public function testGetName(): void
    {
        $this->assertSame("Cha+", $this->restaurant->getName());
    }

    public function testGetType(): void
    {
        $this->assertSame("fast_food", $this->restaurant->getType());
    }

    public function testGetPhone(): void
    {
        $this->assertSame("+33238537802", $this->restaurant->getPhone());
    }

    public function testGetWebsite(): void
    {
        $this->assertSame("http://www.le-dream-s-coffee.com", $this->restaurant->getWebsite());
    }

    public function testGetRegion(): void
    {
        $this->assertSame("Centre-Val de Loire", $this->restaurant->getRegion());
    }

    public function testGetDepartement(): void
    {
        $this->assertSame("Loiret", $this->restaurant->getDepartement());
    }

    public function testGetCommune(): void
    {
        $this->assertSame("Orléans", $this->restaurant->getCommune());
    }

    public function testParseOpeningHours(): void
    {
        $openingHours = $this->restaurant->getOpeningHours();
        $this->assertIsArray($openingHours);
        $this->assertSame("11:00-20:00", $openingHours[1]); // Mardi
        $this->assertSame("13:00-20:00", $openingHours[6]); // Dimanche
    }

    public function testRenderOpeningHours(): void
    {
        $html = $this->restaurant->renderOpeningHours(true);
        $this->assertStringContainsString("<table class='opening-hours-table opening-hours-table-pretty'>", $html);
        $this->assertStringContainsString("Lundi", $html);
        $this->assertStringContainsString("Dimanche", $html);
    }

    public function testRenderCard(): void
    {
        $html = $this->restaurant->renderCard();
        $this->assertStringContainsString("<div class='restaurant-card'>", $html);
        $this->assertStringContainsString("Cha+", $html);
        $this->assertStringContainsString("fast_food", $html);
    }

    public function testRenderDetail(): void
    {
        $html = $this->restaurant->renderDetail(true);
        $this->assertStringContainsString("<h1>Cha+</h1>", $html);
        $this->assertStringContainsString("fast_food", $html);
        $this->assertStringContainsString("Horaires d'ouverture", $html);
    }

    public function testAddAvis(): void
    {
        $avis = new \Iuto\SaePhp\Model\Avis(
            new \Iuto\SaePhp\Model\User('john.doe@example.com', 'John', 'Doe', 'password'),
            'Great food!',
            5,
            $this->restaurant
        );

        $this->restaurant->addAvis($avis);
        $avisList = $this->restaurant->getAvis();

        $this->assertCount(1, $avisList);
        $this->assertSame($avis, $avisList[0]);
    }
}