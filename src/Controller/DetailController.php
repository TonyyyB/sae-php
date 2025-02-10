<?php
declare(strict_types=1);
namespace Iuto\SaePhp\Controller;
use Iuto\SaePhp\DataSources\JsonProvider;

class DetailController extends Controller
{
    public function get(string $param): void
    {
        parse_str($param,$params);
        if(!isset($params["id"])){
            $this->redirectTo('/');
        }
        $jp = new JsonProvider(__DIR__ . "/../../data/restaurants_orleans.json");
        $restau = $jp->getById($params['id']);
        if(!$restau){
            $this->redirectTo('/');
        }
        $this->render('detail', ['restau' => $restau]);
    }
}