<?php

namespace Iuto\SaePhp\Model;
class Avis
{
    private int $id;
    private string $commentaire;
    private int $note;
    private Restaurant $restaurant;
    private User $user;
    public function __construct(int $id, User $user, string $commentaire, int $note, Restaurant $restaurant)
    {
        if ($note <= 0) {
            throw new \Exception("La note doit être un entier positif.");
        } else if ($note > 5) {
            throw new \Exception("La note doit être inférieure ou égale à 5.");
        }
        $this->id = $id;
        $this->user = $user;
        $this->commentaire = $commentaire;
        $this->note = $note;
        $this->restaurant = $restaurant;
    }
    public function renderStars(): string
    {
        $html = "<div class='stars-container' style='width: 4.5em;'>";
        $html .= "<div class='stars-background'>";
        $html .= "★★★★★";
        $html .= "</div>";
        $html .= "<div class='stars-filled' style='width: " . (($this->note / 5) * 100) . "%;'>";
        $html .= "★★★★★";
        $html .= "</div>";
        $html .= "</div>";
        return $html;
    }
    public function render(): string
    {
        $html = "<div class='avis'>";
        $html .= "<p><strong>Utilisateur : </strong>" . $this->user->getPrenomNom() . "</p>";
        $html .= "<p><strong>Commentaire : </strong>" . ucfirst($this->commentaire) . "</p>";
        $html .= "<p><strong>Note : </strong>" . $this->note . "/5" . $this->renderStars() . "</p>";
        $html .= "</div>";
        return $html;
    }

    public function renderGestion(): string
    {
        $html = "<div class='avis avis-".$this->id."'>";
        $html .= "<div class='avis-content'>";
        $html .= "<p><strong>Restaurant : </strong><a href='/detail/".$this->restaurant->getOsmId()."'>" . $this->restaurant->getName() . "</a></p>";
        $html .= "<p><strong>Utilisateur : </strong>" . $this->user->getPrenomNom() . "</p>";
        $html .= "<p><strong>Commentaire : </strong>" . ucfirst($this->commentaire) . "</p>";
        $html .= "<p><strong>Note : </strong>" . $this->note . "/5" . $this->renderStars() . "</p>";
        $html .= "<button class='button delete-avis-btn' onclick='editAvis(".$this->id.")'>Modifier l'avis</button>";
        $html .= "<form action='/detailUser/' method='POST'>";
        $html .= "<input type='hidden' name='id' value='".$this->id."'>";
        $html .= "<input type='hidden' name='action' value='delete'>";
        $html .= "<button type='submit' class='button delete-avis-btn'>Supprimer l'avis</button>";
        $html .= "</form>";
        $html .= "</div>";
        $html .= "<div class='edit' style='display: none'>";
        $html .= "<form action='/detailUser/' method='POST'>";
        $html .= "<input type='hidden' name='id' value='".$this->id."'>";
        $html .= "<input type='hidden' name='action' value='edit'>";
        $html .= "<div>";
        $html .= "<label for='commentaire'>Votre commentaire :</label>";
        $html .= "<textarea class='avis-textarea' id='commentaire' name='commentaire' required>".$this->commentaire."</textarea>";
        $html .= "</div>";
        $html .= "<div>";
        $html .= "<label for='note'>Note :</label>";
        $html .= "<select id='note' name='note' required>";
        $html .= "<option value='5' class='stars-filled' ".($this->note == 5 ? "selected='selected'" : "").">★★★★★</option>";
        $html .= "<option value='4' class='stars-filled' ".($this->note == 4 ? "selected='selected'" : "").">★★★★</option>";
        $html .= "<option value='3' class='stars-filled' ".($this->note == 3 ? "selected='selected'" : "").">★★★</option>";
        $html .= "<option value='2' class='stars-filled' ".($this->note == 2 ? "selected='selected'" : "").">★★</option>";
        $html .= "<option value='1' class='stars-filled' ".($this->note == 1 ? "selected='selected'" : "").">★</option>";
        $html .= "</select>";
        $html .= "</div>";
        $html .= "<div>";
        $html .= "<button type='submit' class='button'>Confirmer</button>";
        $html .= "<button type='button' class='button' onclick='editAvis(".$this->id.")'>Annuler</button>";
        $html .= "</div>";
        $html .= "</form>";
        $html .= "</div>";
        $html .= "</div>";
        return $html;
    }

    public static function renderForm(int $id): string
    {
        $html = "<div class='avis'>";
        $html .= "<p>Ajouter un avis</p>";
        $html .= "<form action='/detail/".$id."' method='POST'>";
        $html .= "<div>";
        $html .= "<label for='commentaire'>Votre commentaire :</label>";
        $html .= "<textarea class='avis-textarea' id='commentaire' name='commentaire' required></textarea>";
        $html .= "</div>";
        $html .= "<div>";
        $html .= "<label for='note'>Note :</label>";
        $html .= "<select id='note' name='note' required>";
        $html .= "<option value='5' class='stars-filled'>★★★★★</option>";
        $html .= "<option value='4' class='stars-filled'>★★★★</option>";
        $html .= "<option value='3' class='stars-filled'>★★★</option>";
        $html .= "<option value='2' class='stars-filled'>★★</option>";
        $html .= "<option value='1' class='stars-filled'>★</option>";
        $html .= "</select>";
        $html .= "</div>";
        $html .= "<div>";
        $html .= "<button type='submit' class='add-avis-btn'>Ajouter un avis</button>";
        $html .= "</div>";
        $html .= "</form>";
        $html .= "</div>";

        return $html;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNote(): int
    {
        return $this->note;
    }
    public function setNote(int $note): void
    {
        $this->note = $note;
    }
    public function getCommentaire(): string
    {
        return $this->commentaire;
    }
    public function setCommentaire(string $commentaire): void
    {
        $this->commentaire = $commentaire;
    }

    public function getRestaurant(): Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant( Restaurant $restaurant): void
    {
        $this->restaurant = $restaurant;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

}