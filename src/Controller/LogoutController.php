<?php
declare(strict_types=1);
namespace Iuto\SaePhp\Controller;

class LogoutController extends Controller
{
    public function get(string $param): void
    {
        unset($_SESSION["user"]);
        $this->redirectTo("/");
    }

    public function post(string $param): void
    {
        unset($_SESSION["user"]);
        $this->redirectTo("/");
    }
}