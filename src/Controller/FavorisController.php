<?php
declare(strict_types=1);
namespace Iuto\SaePhp\Controller;
use Iuto\SaePhp\DataSources\JsonProvider;

class FavorisController extends Controller
{
    public function post(string $param): void
    {
        if(!isset($_SESSION["user"]) || empty($_SESSION["user"])){
            $this->redirectTo("/detail/".$param);
        }
        if(empty($param)){
            $this->redirectTo('/');
        }
        $_SESSION["user"]->toggleFavoris($param);
        $jp = new JsonProvider();
        $restau = $jp->getById($param);
        $jp->toggleFavoris();
        $this->redirectTo("/detail/".$param);
    }
}