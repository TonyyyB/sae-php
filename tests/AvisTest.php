<?php

namespace Iuto\SaePhp\Test\Model;

use Iuto\SaePhp\Model\Avis;
use Iuto\SaePhp\Model\User;
use Iuto\SaePhp\Model\Restaurant;
use PHPUnit\Framework\TestCase;

class AvisTest extends TestCase
{
    private User $user;
    private Restaurant $restaurant;

    protected function setUp(): void
    {
        // Initialisation des objets nécessaires pour les tests
        $this->user = new User('john.doe@example.com', 'John', 'Doe', 'password');
        $this->restaurant = new Restaurant(9052942, 90114979996115, "node/3422189698", "fast_food", "Cha+", null, null, "Tu-Sa 11:00-20:00; Su 13:00-20:00","no", "null", null, null, null, null, null, null, "+33 2 38 53 78 02", "http://www.le-dream-s-coffee.com", null, "Centre-Val de Loire", "Loiret", "Orl\u00e9ans");
    }

    public function testAvisCreationWithValidNote(): void
    {
        $avis = new Avis($this->user, 'Great food!', 5, $this->restaurant);

        $this->assertSame('Great food!', $avis->getCommentaire());
        $this->assertSame(5, $avis->getNote());
        $this->assertSame($this->user, $avis->getUser());
        $this->assertSame($this->restaurant, $avis->getRestaurant());
    }

    // public function testAvisCreationWithInvalidNoteThrowsException(): void
    // {
    //     $this->expectException(\Exception::class);
    //     $this->expectExceptionMessage("La note doit être un entier positif.");

    //     new Avis($this->user, 'Bad food!', 0, $this->restaurant);
    // }

    // public function testAvisCreationWithNoteGreaterThanFiveThrowsException(): void
    // {
    //     $this->expectException(\Exception::class);
    //     $this->expectExceptionMessage("La note doit être inférieure ou égale à 5.");

    //     new Avis($this->user, 'Bad food!', 6, $this->restaurant);
    // }

    // public function testRenderStars(): void
    // {
    //     $avis = new Avis($this->user, 'Great food!', 3, $this->restaurant);

    //     $expectedHtml = "<div class='stars-container' style='width: 4.5em;'>";
    //     $expectedHtml .= "<div class='stars-background'>";
    //     $expectedHtml .= "★★★★★";
    //     $expectedHtml .= "</div>";
    //     $expectedHtml .= "<div class='stars-filled' style='width: 60%;'>";
    //     $expectedHtml .= "★★★★★";
    //     $expectedHtml .= "</div>";
    //     $expectedHtml .= "</div>";

    //     $this->assertSame($expectedHtml, $avis->renderStars());
    // }

    // public function testRender(): void
    // {
    //     $avis = new Avis($this->user, 'Great food!', 4, $this->restaurant);

    //     $expectedHtml = "<div class='avis'>";
    //     $expectedHtml .= "<p><strong>Utilisateur : </strong>" . $this->user->getPrenomNom() . "</p>";
    //     $expectedHtml .= "<p><strong>Commentaire : </strong>Great food!</p>";
    //     $expectedHtml .= "<p><strong>Note : </strong>4/5" . $avis->renderStars() . "</p>";
    //     $expectedHtml .= "</div>";

    //     $this->assertSame($expectedHtml, $avis->render());
    // }

    // public function testRenderForm(): void
    // {
    //     $id = 1;
    //     $expectedHtml = "<div class='avis'>";
    //     $expectedHtml .= "<p>Ajouter un avis</p>";
    //     $expectedHtml .= "<form action='/detail/1' method='POST'>";
    //     $expectedHtml .= "<div>";
    //     $expectedHtml .= "<label for='commentaire'>Votre commentaire :</label>";
    //     $expectedHtml .= "<textarea class='avis-textarea' id='commentaire' name='commentaire' required></textarea>";
    //     $expectedHtml .= "</div>";
    //     $expectedHtml .= "<div>";
    //     $expectedHtml .= "<label for='note'>Note :</label>";
    //     $expectedHtml .= "<select id='note' name='note' required>";
    //     $expectedHtml .= "<option value='5' class='stars-filled'>★★★★★</option>";
    //     $expectedHtml .= "<option value='4' class='stars-filled'>★★★★</option>";
    //     $expectedHtml .= "<option value='3' class='stars-filled'>★★★</option>";
    //     $expectedHtml .= "<option value='2' class='stars-filled'>★★</option>";
    //     $expectedHtml .= "<option value='1' class='stars-filled'>★</option>";
    //     $expectedHtml .= "</select>";
    //     $expectedHtml .= "</div>";
    //     $expectedHtml .= "<div>";
    //     $expectedHtml .= "<button type='submit' class='add-avis-btn'>Ajouter un avis</button>";
    //     $expectedHtml .= "</div>";
    //     $expectedHtml .= "</form>";
    //     $expectedHtml .= "</div>";

    //     $this->assertSame($expectedHtml, Avis::renderForm($id));
    // }

    // public function testGetSetNote(): void
    // {
    //     $avis = new Avis($this->user, 'Great food!', 3, $this->restaurant);

    //     $avis->setNote(4);
    //     $this->assertSame(4, $avis->getNote());
    // }

    // public function testGetSetCommentaire(): void
    // {
    //     $avis = new Avis($this->user, 'Great food!', 3, $this->restaurant);

    //     $avis->setCommentaire('Amazing food!');
    //     $this->assertSame('Amazing food!', $avis->getCommentaire());
    // }

    // public function testGetSetRestaurant(): void
    // {
    //     $avis = new Avis($this->user, 'Great food!', 3, $this->restaurant);

    //     $newRestaurant = new Restaurant(2, 'New Restaurant', 'New Address', 'New Description');
    //     $avis->setRestaurant($newRestaurant);
    //     $this->assertSame($newRestaurant, $avis->getRestaurant());
    // }

    // public function testGetSetUser(): void
    // {
    //     $avis = new Avis($this->user, 'Great food!', 3, $this->restaurant);

    //     $newUser = new User(2, 'Jane', 'Doe', 'jane.doe@example.com', 'password');
    //     $avis->setUser($newUser);
    //     $this->assertSame($newUser, $avis->getUser());
    // }
}