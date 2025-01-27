<?php
declare(strict_types=1);
namespace Iuto\SaePhp\Controller;

use Iuto\SaePhp\DataSources\DataBaseProvider;
use Iuto\SaePhp\DataSources\JsonProvider;
use Iuto\SaePhp\Model\Restaurant;
class RestaurantsController extends Controller
{
    public function get(string $param): void
    {
        $jp = new JsonProvider(__DIR__ . "/../../data/restaurants_orleans.json");
        $this->render('restaurants', ["restaurants" => $jp->loadRestaurants()]);
    }
}