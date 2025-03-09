<?php

namespace Iuto\SaePhp\Test\Model;

use Iuto\SaePhp\Model\Avis;
use Iuto\SaePhp\Model\Restaurant;
use Iuto\SaePhp\Model\User;
use PHPUnit\Framework\TestCase;

class AvisTest extends TestCase
{
    private User $user;
    private Restaurant $restaurant;

    protected function setUp(): void
    {
        $this->user = new User('john.doe@example.com', 'Doe', 'John', 'password');
        $this->restaurant = new Restaurant(
            9052942,
            90114979996115,
            "node/3422189698",
            "fast_food",
            "Cha+",
            null,
            null,
            "Tu-Sa 11:00-20:00; Su 13:00-20:00",
            false,
            [],
            false,
            false,
            false,
            false,
            null,
            false,
            "+33 2 38 53 78 02",
            "http://www.le-dream-s-coffee.com",
            null,
            "Centre-Val de Loire",
            "Loiret",
            "Orléans"
        );
    }

    public function testAvisCreation(): void
    {
        $avis = new Avis($this->user, "Great food!", 5, $this->restaurant);
        $this->assertSame("Great food!", $avis->getCommentaire());
        $this->assertSame(5, $avis->getNote());
        $this->assertSame($this->user, $avis->getUser());
        $this->assertSame($this->restaurant, $avis->getRestaurant());
    }

    public function testInvalidNoteThrowsException(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("La note doit être un entier positif.");
        new Avis($this->user, "Bad food!", 0, $this->restaurant);
    
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("La note doit être inférieure ou égale à 5.");
        new Avis($this->user, "Bad food!", 6, $this->restaurant);
    }

    public function testRenderStars(): void
    {
        $avis = new Avis($this->user, "Good food!", 4, $this->restaurant);
        $starsHtml = $avis->renderStars();
        $this->assertStringContainsString("width: 80%;", $starsHtml);
        $this->assertStringContainsString("★★★★★", $starsHtml);
    }

    public function testRender(): void
    {
        $avis = new Avis($this->user, "Excellent service!", 5, $this->restaurant);
        $avisHtml = $avis->render();
        $this->assertStringContainsString("Utilisateur : </strong>John Doe", $avisHtml);
        $this->assertStringContainsString("Commentaire : </strong>Excellent service!", $avisHtml);
        $this->assertStringContainsString("Note : </strong>5/5", $avisHtml);
        $this->assertStringContainsString("★★★★★", $avisHtml);
    }

    public function testRenderForm(): void
    {
        $formHtml = Avis::renderForm(123);
        $this->assertStringContainsString("<form action='/detail/123' method='POST'>", $formHtml);
        $this->assertStringContainsString("<textarea class='avis-textarea' id='commentaire'", $formHtml);
        $this->assertStringContainsString("<select id='note' name='note' required>", $formHtml);
        $this->assertStringContainsString("<option value='5' class='stars-filled'>★★★★★</option>", $formHtml);
        $this->assertStringContainsString("<button type='submit' class='add-avis-btn'>Ajouter un avis</button>", $formHtml);
    }

    public function testSetAndGetMethods(): void
    {
        $avis = new Avis($this->user, "Good experience", 3, $this->restaurant);
        $avis->setCommentaire("Amazing experience!");
        $avis->setNote(4);
        $this->assertSame("Amazing experience!", $avis->getCommentaire());
        $this->assertSame(4, $avis->getNote());
    }

    public function testSetRestaurantAndUser(): void
    {
        $newRestaurant = clone $this->restaurant;
        $newUser = new User('jane.doe@example.com', 'Doe', 'Jane', 'password');
        $avis = new Avis($this->user, "Good experience", 4, $this->restaurant);
        
        $avis->setRestaurant($newRestaurant);
        $avis->setUser($newUser);
        
        $this->assertSame($newRestaurant, $avis->getRestaurant());
        $this->assertSame($newUser, $avis->getUser());
    }

    public function testSetNote(): void
    {
        $avis = new Avis($this->user, "Good experience", 3, $this->restaurant);
        $avis->setNote(4);
        $this->assertSame(4, $avis->getNote());
    }

    public function testInvalidNoteTooLow(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("La note doit être un entier positif.");
        new Avis($this->user, "Commentaire test", 0, $this->restaurant);
    }

    public function testInvalidNoteTooHigh(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("La note doit être inférieure ou égale à 5.");
        new Avis($this->user, "Commentaire test", 6, $this->restaurant);
    }
}
