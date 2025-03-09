<?php

namespace Iuto\SaePhp\Model;
use Iuto\SaePhp\DataSources\JsonProvider;
class User
{
    private string $email;
    private string $nom;
    private string $prenom;
    private string $mdp;

    private ?array $avis;

    public function __construct(string $email, string $nom, string $prenom, string $mdp)
    {
        $this->email = $email;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mdp = $mdp;
        $this->avis = [];
        $this->favoris = [];
    }

    public function setAvis(array $avis): void
    {
        $this->avis = $avis;
    }

    public function getAvis(): ?array
    {
        return $this->avis;
    }

    public function addAvis(Avis $avis): void
    {
        $this->avis[] = $avis;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function getPrenomNom(): string
    {
        return ucfirst($this->prenom) . ' ' . ucfirst($this->nom);
    }

    public function getMdp(): string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): void
    {
        $this->mdp = $mdp;
    }

    public function getFavoris(): array
    {
        return $this->favoris;
    }

    public function setFavoris(array $favoris): void
    {
        $this->favoris = $favoris;
    }

    public function isFavoris($id): bool
    {
        return in_array($id, $this->favoris);
    }

    public function toggleFavoris($id): void
    {
        if ($this->isFavoris($id)){
            array_splice($this->favoris, array_search($id, $this->favoris));
        }
        else{
            array_push($this->favoris, $id);
        }
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'mdp' => $this->mdp,
            'favoris' => $this->favoris
        ];
    }

    public static function fromArray(array $data): self
    {
        $user = new self(
            $data['email'],
            $data['nom'],
            $data['prenom'],
            $data['mdp']
        );
        $user->setFavoris($data['favoris']);
        return $user;
    }

    public function renderDetail(): string
    {
        $html = "<div class='user-general'><div class='user-info'><h1>" . htmlspecialchars($this->getNom()) . "</h1>";

        // Avis
        $html .= "<section class='avis-section'>";
        if (isset($this->avis) && sizeof($this->avis) > 0) {
            $html .= "<h3>Avis de l'utilisateur</h3>";
            foreach ($this->avis as $avis) {
                $html .= $avis->renderGestion();
            }
        } else {
            $html .= "<p>Aucun avis pour le moment.</p>";
        }
        // Favoris
        if (count($this->getFavoris()) > 0){
            $html .= "<h3>Favoris de l'utilisateur</h3>";
            $jp = new JsonProvider();
            $restaurants = $jp->loadRestaurants();
            $html .= "<div class='restaurant-list'>";
            foreach ($restaurants as $restau) {
                if ($this->isFavoris($restau->getOsmId())){
                    $html .= $restau->renderCard();
                }
            }
            $html .= "</div>";
        }
        return $html;
    }
}