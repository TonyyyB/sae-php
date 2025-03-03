<?php
declare(strict_types=1);
namespace Iuto\SaePhp\Controller;
use Iuto\SaePhp\DataSources\JsonProvider;

class DetailController extends Controller
{
    public function get(): void
    {
        if(!isset($_GET["id"])){
            $this->redirectTo('/');
        }
        $jp = new JsonProvider(__DIR__ . "/../../data/restaurants_orleans.json");
        $restau = $jp->getById($_GET['id']);
        if(!$restau){
            $this->redirectTo('/');
        }
        $this->render('detail', ['restau' => $restau]);
    }
}