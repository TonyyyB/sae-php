<?php
declare(strict_types=1);
namespace Iuto\SaePhp\Controller;

use Iuto\SaePhp\DataSources\JsonProvider;
use function PHPUnit\Framework\isNull;
class LoginController extends Controller
{
    public function get(string $param): void
    {
        $this->render('login');
    }

    public function post(string $param): void
    {
        $jp = new JsonProvider();
        $user = $jp->getUser($_POST["email"], $_POST["password"]);
        if($user === null) {
            $this->render("login", ["err" => "Email ou mot de passe incorrect"]);
        }else{
            $_SESSION["user"] = $user;
            $this->redirectTo("/");
        }
    }
}