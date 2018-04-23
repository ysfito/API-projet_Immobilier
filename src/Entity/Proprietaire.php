<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proprietaire
 *
 * @ORM\Table(name="proprietaire")
 * @ORM\Entity
 */
class Proprietaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="num_piece", type="integer", nullable=false)
     */
    private $numPiece;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_complet", type="string", length=25, nullable=false)
     */
    private $nomComplet;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=130, nullable=false)
     */
    private $adresse;

    /**
     * @var int
     *
     * @ORM\Column(name="tel", type="integer", nullable=false)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="codebanque", type="integer", nullable=false)
     */
    private $codebanque;


}
