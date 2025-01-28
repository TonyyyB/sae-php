<?php

namespace Iuto\SaePhp\Model;
class Avis
{
    private string $utilisateur;
    private string $commentaire;
    private int $note;
    public function __construct(string $utilisateur, string $commentaire, int $note)
    {
        if ($note <= 0) {
            throw new \Exception("La note doit être un entier positif.");
        } else if ($note > 5) {
            throw new \Exception("La note doit être inférieure ou égale à 5.");
        }
        $this->utilisateur = $utilisateur;
        $this->commentaire = $commentaire;
        $this->note = $note;
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
        $html .= "<p><strong>Utilisateur : </strong>" . ucfirst($this->utilisateur) . "</p>";
        $html .= "<p><strong>Commentaire : </strong>" . ucfirst($this->commentaire) . "</p>";
        $html .= "<p><strong>Note : </strong>" . $this->note . "/5" . $this->renderStars() . "</p>";
        $html .= "</div>";
        return $html;
    }

    public static function renderForm(): string
    {
        $html = "<div class='avis'>";
        $html .= "<p>Ajouter un avis</p>";
        $html .= "<form action='/detail' method='POST'>";
        $html .= "<div>";
        $html .= "<label for='commentaire'>Votre commentaire :</label>";
        $html .= "<textarea class='avis-textarea' id='commentaire' name='commentaire' required></textarea>";
        $html .= "</div>";
        $html .= "<div>";
        $html .= "<label for='note'>Note :</label>";
        $html .= "<select id='note' name='note' required>";
        $html .= "<option value='1' class='stars-filled'>★</option>";
        $html .= "<option value='2' class='stars-filled'>★★</option>";
        $html .= "<option value='3' class='stars-filled'>★★★</option>";
        $html .= "<option value='4' class='stars-filled'>★★★★</option>";
        $html .= "<option value='5' class='stars-filled'>★★★★★</option>";
        $html .= "</select>";
        $html .= "</div>";
        $html .= "<div>";
        $html .= "<button type='submit' class='add-avis-btn'>Ajouter un avis</button>";
        $html .= "</div>";
        $html .= "</form>";
        $html .= "</div>";

        return $html;
    }

    public function getNote(): int
    {
        return $this->note;
    }
    public function setNote(int $note): void
    {
        $this->note = $note;
    }
    public function getUtilisateur(): string
    {
        return $this->utilisateur;
    }
    public function setUtilisateur(string $utilisateur): void
    {
        $this->utilisateur = $utilisateur;
    }
    public function getCommentaire(): string
    {
        return $this->commentaire;
    }
    public function setCommentaire(string $commentaire): void
    {
        $this->commentaire = $commentaire;
    }

}