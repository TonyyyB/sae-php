<?php
declare(strict_types=1);
namespace Iuto\SaePhp\Controller;

use Iuto\SaePhp\DataSources\JsonProvider;
use Iuto\SaePhp\Model\User;
class RegisterController extends Controller
{
    public function get(string $param): void
    {
        $this->render('register');
    }

    public function post(string $param): void
    {
        $user = new User($_POST["email"], $_POST["nom"], $_POST["prenom"], hash("sha256", $_POST["password"]));
        $jp = new JsonProvider();
        $aEteAjouter = $jp->addUser($user);
        if(!$aEteAjouter){
            $this->render("register", ["err" => "Un utilisateur avec le même email existe déjà."]);
        }else{
            $_SESSION["user"] = $user;
            $this->redirectTo("/");
        }
    }
}