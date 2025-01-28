<?php
declare(strict_types=1);
namespace Iuto\SaePhp\Controller;

use Iuto\SaePhp\DataSources\JsonProvider;
class RegisterController extends Controller
{
    public function get(string $param): void
    {
        $this->render('register');
    }
}