<?php

namespace Iuto\SaePhp\Test\Model;

use Iuto\SaePhp\Model\Restaurant;
use Iuto\SaePhp\Model\RestaurantSearch;
use PHPUnit\Framework\TestCase;

class RestaurantSearchTest extends TestCase
{
    private array $restaurants;

    protected function setUp(): void
    {
        $this->restaurants = [
            new Restaurant(9052942, 90114979996115, "node/3422189698", "fast_food", "Cha+", null, null, 
                "Tu-Sa 11:00-20:00; Su 13:00-20:00", true, ["burger", "fries"], true, false, true, false, 
                null, false, "+33 2 38 53 78 02", "http://www.le-dream-s-coffee.com", null, 
                "Centre-Val de Loire", "Loiret", "Orléans"),
            new Restaurant(9052943, 90114979996116, "node/3422189699", "restaurant", "Le Gourmet", null, null, 
                "Mo-Fr 12:00-22:00; Sa-Su 11:00-23:00", false, ["french", "seafood"], false, false, false, true, 
                null, false, "+33 2 38 53 78 03", "http://www.le-gourmet.com", null, 
                "Centre-Val de Loire", "Loiret", "Orléans"),
            new Restaurant(9052944, 90114979996117, "node/3422189700", "cafe", "Coffee Time", null, null, 
                "Mo-Su 08:00-18:00", true, ["coffee", "pastries"], true, true, false, true, 
                null, false, "+33 2 38 53 78 04", "http://www.coffee-time.com", null, 
                "Centre-Val de Loire", "Loiret", "Orléans")
        ];
    }

    public function testSearchByType(): void
    {
        $search = new RestaurantSearch($this->restaurants);
        $results = $search->search(['type' => ['fast_food']]);

        $this->assertCount(1, $results);
        $this->assertSame("Cha+", $results[0]->getName());
    }

    public function testSearchByCuisine(): void
    {
        $search = new RestaurantSearch($this->restaurants);
        $results = $search->search(['cuisine' => ['french']]);

        $this->assertCount(1, $results);
        $this->assertSame("Le Gourmet", $results[0]->getName());
    }

    public function testSearchByWheelchairOption(): void
    {
        $search = new RestaurantSearch($this->restaurants);
        $results = $search->search(['option' => ['wheelchair']]);

        $this->assertCount(2, $results);
        $this->assertContains("Cha+", array_map(fn($r) => $r->getName(), $results));
        $this->assertContains("Coffee Time", array_map(fn($r) => $r->getName(), $results));
    }

    public function testSearchByVegetarianOption(): void
    {
        $search = new RestaurantSearch($this->restaurants);
        $results = $search->search(['option' => ['vegetarian']]);

        $this->assertCount(2, $results);
        $this->assertContains("Cha+", array_map(fn($r) => $r->getName(), $results));
        $this->assertContains("Coffee Time", array_map(fn($r) => $r->getName(), $results));
    }

    public function testSearchByVeganOption(): void
    {
        $search = new RestaurantSearch($this->restaurants);
        $results = $search->search(['option' => ['vegan']]);

        $this->assertCount(1, $results);
        $this->assertSame("Coffee Time", $results[0]->getName());
    }

    public function testSearchByDeliveryOption(): void
    {
        $search = new RestaurantSearch($this->restaurants);
        $results = $search->search(['option' => ['delivery']]);

        $this->assertCount(1, $results);
        $this->assertSame("Cha+", $results[0]->getName());
    }

    public function testSearchByMultipleFilters(): void
    {
        $search = new RestaurantSearch($this->restaurants);
        $results = $search->search(['type' => ['cafe'], 'option' => ['wheelchair']]);

        $this->assertCount(1, $results);
        $this->assertSame("Coffee Time", $results[0]->getName());
    }

    public function testSearchWithNoFilters(): void
    {
        $search = new RestaurantSearch($this->restaurants);
        $results = $search->search([]);

        $this->assertCount(3, $results);
    }
}
