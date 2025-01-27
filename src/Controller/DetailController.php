<?php
declare(strict_types=1);
namespace Iuto\SaePhp\Controller;
use Iuto\SaePhp\DataSources\JsonProvider;

class DetailController extends Controller
{
    public function get(string $param): void
    {
        $jp = new JsonProvider(__DIR__ . "/../../data/restaurants_orleans.json");
        $restau = $jp->getById($param);
        $this->render('detail', ['restau' => $restau]);
    }
}