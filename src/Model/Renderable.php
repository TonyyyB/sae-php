<?php
declare(strict_types=1);
namespace Iuto\SaePhp\Model;
interface Renderable
{
    public function render(): string;
}