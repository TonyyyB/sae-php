<?php
declare(strict_types=1);
namespace Iuto\SaePhp\Controller;
use Iuto\SaePhp\DataSources\JsonProvider;
use Iuto\SaePhp\Model\Avis;

class DetailUserController extends Controller
{
    public function get(string $param): void
    {
        if(!isset($_SESSION["user"]) || empty($_SESSION["user"])){
            $this->redirectTo("/");
        }
        $jp = new JsonProvider();
        $avis = $jp->getAvisByUser($_SESSION["user"]);
        $_SESSION["user"]->setAvis($avis);
        $this->render('detailUser', ['user' => $_SESSION["user"]]);
    }

    public function post(string $param): void
    {
        if(!isset($_SESSION["user"]) || empty($_SESSION["user"])){
            $this->redirectTo("/");
        }
        $jp = new JsonProvider();
        $restau = $jp->getById($param);
        if(!$restau){
            $this->redirectTo('/');
        }
        $avis = new Avis($_SESSION["user"], $_POST['commentaire'], (int)$_POST['note'], $restau);
        $jp->addAvis($avis);
        $tousAvis = $jp->getAvisByUser($_SESSION["user"]);
        $_SESSION["user"]->setAvis($tousAvis);
        $this->render('detailUser', ['avis' => $avis]);
    }
}