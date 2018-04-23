<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bien
 *
 * @ORM\Table(name="bien", indexes={@ORM\Index(name="IDX_45EDC386924DD2B5", columns={"localite_id"}), @ORM\Index(name="IDX_45EDC386677134B4", columns={"typebien_id"})})
 * @ORM\Entity
 */
class Bien
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
     * @var string
     *
     * @ORM\Column(name="nom_bien", type="string", length=25, nullable=false)
     */
    private $nomBien;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer", nullable=false)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=150, nullable=false)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="prix_location", type="integer", nullable=false)
     */
    private $prixLocation;

    /**
     * @var int|null
     *
     * @ORM\Column(name="parentbien_id", type="integer", nullable=true)
     */
    private $parentbienId;

    /**
     * @var \TypeBien
     *
     * @ORM\ManyToOne(targetEntity="TypeBien")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="typebien_id", referencedColumnName="id")
     * })
     */
    private $typebien;

    /**
     * @var \Localite
     *
     * @ORM\ManyToOne(targetEntity="Localite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="localite_id", referencedColumnName="id")
     * })
     */
    private $localite;


        /**
         * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="bien")
         */
        private $images;


        /**
      * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="bien")
      */
      private $reservations;


        /**
         * Get the value of images
         */
        public function getImages()
        {
                return $this->images;
        }

        /**
         * Set the value of images
         *
         * @return  self
         */
        public function setImages($images)
        {
                $this->images = $images;

                return $this;
        }
}
