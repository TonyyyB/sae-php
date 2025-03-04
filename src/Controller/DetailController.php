<?php
declare(strict_types=1);
namespace Iuto\SaePhp\Controller;
use Iuto\SaePhp\DataSources\JsonProvider;
use Iuto\SaePhp\Model\Avis;

class DetailController extends Controller
{
    public function get(string $param): void
    {
        if(empty($param)){
            $this->redirectTo('/');
        }
        $jp = new JsonProvider();
        $restau = $jp->getById($param, true);
        if(!$restau){
            $this->redirectTo('/');
        }
        $this->render('detail', ['restau' => $restau]);
    }

    public function post(string $param): void
    {
        if(!isset($_SESSION["user"]) || empty($_SESSION["user"])){
            $this->redirectTo("/detail/".$param);
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
        $tousAvis = $jp->getAvis($restau);
        $restau->setAvis($tousAvis);
        $this->render('detail', ['restau' => $restau]);
    }
}