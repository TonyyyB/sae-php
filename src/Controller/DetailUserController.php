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
        $avis = $jp->getAvisById((int)$_POST['id']);
        if(!$avis){
            $this->redirectTo("/detailUser");
        }
        if($_POST['action'] === 'delete'){
            $jp->deleteAvis($avis);
        } else {
            $avis->setCommentaire($_POST['commentaire']);
            $avis->setNote((int)$_POST['note']);
            $jp->editAvis($avis);
        }
        $this->redirectTo("/detailUser");
    }
}