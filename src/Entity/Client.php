<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", unique=true)
     */
    private $NumPiece;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nomComplet;

    /**
     * @ORM\Column(type="integer", unique=true)
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $password;


    /**
  * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="client")
  */
  private $reservations;

    public function getId()
    {
        return $this->id;
    }

    public function getNumPiece(): ?int
    {
        return $this->NumPiece;
    }

    public function setNumPiece(int $NumPiece): self
    {
        $this->NumPiece = $NumPiece;

        return $this;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(string $nomComplet): self
    {
        $this->nomComplet = $nomComplet;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(int $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

  /**
   * Get the value of reservations
   */
  public function getReservations()
  {
    return $this->reservations;
  }

  /**
   * Set the value of reservations
   *
   * @return  self
   */
  public function setReservations($reservations)
  {
    $this->reservations = $reservations;

    return $this;
  }
}
