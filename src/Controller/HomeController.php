<?php
declare(strict_types=1);
namespace Iuto\SaePhp\Controller;
class HomeController extends Controller
{
    public function get(): void
    {
        $this->render('home', []);
    }
}