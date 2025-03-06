<?php
declare(strict_types=1);
namespace Iuto\SaePhp\Controller;
use Iuto\SaePhp\DataSources\JsonProvider;
use Iuto\SaePhp\Model\Avis;

class DetailUserController extends Controller
{
    public function get(string $param): void
    {
        if(empty($param)){
            $this->redirectTo('/');
        }
        $jp = new JsonProvider();
        $avis = $jp->getAvisByUser($param);
        if(!$avis){
            $this->redirectTo('/');
        }
        $this->render('detailUser', ['avis' => $avis]);
    }

    public function post(string $param): void
    {
        if(!isset($_SESSION["user"]) || empty($_SESSION["user"])){
            $this->redirectTo("/detailUser/".$param);
        }
        if(empty($param)){
            $this->redirectTo('/');
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