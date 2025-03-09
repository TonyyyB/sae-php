<?php

use PHPUnit\Framework\TestCase;
use Iuto\SaePhp\Model\User;

class UserTest extends TestCase
{
    public function testUserCreation()
    {
        $user = new User("test@example.com", "Doe", "John", "password123");

        $this->assertEquals("test@example.com", $user->getEmail());
        $this->assertEquals("Doe", $user->getNom());
        $this->assertEquals("John", $user->getPrenom());
        $this->assertEquals("John Doe", $user->getPrenomNom());
        $this->assertEquals("password123", $user->getMdp());
    }

    public function testSetters()
    {
        $user = new User("test@example.com", "Doe", "John", "password123");

        $user->setEmail("new@example.com");
        $user->setNom("Smith");
        $user->setPrenom("Jane");
        $user->setMdp("newpassword");

        $this->assertEquals("new@example.com", $user->getEmail());
        $this->assertEquals("Smith", $user->getNom());
        $this->assertEquals("Jane", $user->getPrenom());
        $this->assertEquals("Jane Smith", $user->getPrenomNom());
        $this->assertEquals("newpassword", $user->getMdp());
    }

    public function testToArray()
    {
        $user = new User("test@example.com", "Doe", "John", "password123");

        $expected = [
            'email' => "test@example.com",
            'nom' => "Doe",
            'prenom' => "John",
            'mdp' => "password123",
        ];

        $this->assertEquals($expected, $user->toArray());
    }

    public function testFromArray()
    {
        $data = [
            'email' => "test@example.com",
            'nom' => "Doe",
            'prenom' => "John",
            'mdp' => "password123",
        ];

        $user = User::fromArray($data);

        $this->assertEquals("test@example.com", $user->getEmail());
        $this->assertEquals("Doe", $user->getNom());
        $this->assertEquals("John", $user->getPrenom());
        $this->assertEquals("password123", $user->getMdp());
    }
}
