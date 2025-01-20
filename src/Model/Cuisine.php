<?php
declare(strict_types=1);
namespace Iuto\SaePhp\Model;
class Cuisine
{
    private static array $instances = array();
    private string $id;
    private string $name;
    private function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function create(string $id, string $name): self
    {
        if (!isset(self::$instances[$id])) {
            self::$instances[$id] = new self($id, $name);
        }
        return self::$instances[$id];
    }

    public static function get(string $id): self
    {
        return self::$instances[$id];
    }
}