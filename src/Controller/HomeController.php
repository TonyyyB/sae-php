<?php
declare(strict_types=1);
namespace Iuto\SaePhp\Controller;

use Iuto\SaePhp\DataSources\JsonProvider;
class HomeController extends Controller
{
    public function get(): void
    {
        $jp = new JsonProvider(__DIR__ . "/../../data/restaurants_orleans.json");
        $this->render('home', ["restaurants" => $jp->loadRestaurants()]);
    }
}