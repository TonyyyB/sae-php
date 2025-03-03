<?php
declare(strict_types=1);
namespace Iuto\SaePhp\Controller;

use Iuto\SaePhp\DataSources\DataBaseProvider;
use Iuto\SaePhp\DataSources\JsonProvider;
use Iuto\SaePhp\Model\Restaurant;
class HomeController extends Controller
{
    public function get(): void
    {
        $jp = new JsonProvider();
        $this->render('home', ["restaurants" => $jp->loadRestaurants(5)]);
    }
}