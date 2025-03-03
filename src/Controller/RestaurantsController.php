<?php
declare(strict_types=1);
namespace Iuto\SaePhp\Controller;

use Iuto\SaePhp\DataSources\DataBaseProvider;
use Iuto\SaePhp\DataSources\JsonProvider;
use Iuto\SaePhp\Model\Restaurant;
use Iuto\SaePhp\Model\RestaurantSearch;
class RestaurantsController extends Controller
{
    public function get(): void
    {
        $jp = new JsonProvider(__DIR__ . "/../../data/restaurants_orleans.json");
        $search = new RestaurantSearch($jp->loadRestaurants());
        $restaurants = $search->search($_GET);
        $this->render('restaurants', ["restaurants" => $restaurants, "types" => $jp->getTypes(), "cuisines" => $jp->getCuisines(), "options" => $jp->getOptions(), "selected" => $_GET]);
    }

    public function post(): void
    {
        $this->get();
    }
}