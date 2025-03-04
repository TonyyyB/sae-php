<?php

namespace Iuto\SaePhp\Model;
class User
{
    private string $email;
    private string $nom;
    private string $prenom;
    private string $mdp;

    public function __construct(string $email, string $nom, string $prenom, string $mdp)
    {
        $this->email = $email;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mdp = $mdp;
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

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'mdp' => $this->mdp,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['email'],
            $data['nom'],
            $data['prenom'],
            $data['mdp']
        );
    }
}