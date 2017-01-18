<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16/01/17
 * Time: 11:55
 */

namespace IVS\IVStoreBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Zone
 *
 * @ORM\Table(name="Zone")
 * @ORM\Entity
 */
class Zone
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=20, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="couleur", type="string", length=20, nullable=false)
     */
    private $couleur;

    /**
     * @var Point
     * @ORM\OneToMany(targetEntity="IVS\IVStoreBundle\Entity\Point", mappedBy="zone",cascade={"all"})
     */
    private $listePoints;

    /**
     * Constructor
     */
    public function __construct()
    {
        //$this->listePoints = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Zone
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set couleur
     *
     * @param string $couleur
     *
     * @return Zone
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * Get couleur
     *
     * @return string
     */
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * Add listePoint
     *
     * @param \IVS\IVStoreBundle\Entity\Point $listePoint
     *
     * @return Zone
     */
    public function addListePoint(\IVS\IVStoreBundle\Entity\Point $listePoint)
    {
        $listePoint->setZone($this);
        $this->listePoints[] = $listePoint;

        return $this;
    }

    /**
     * Remove listePoint
     *
     * @param \IVS\IVStoreBundle\Entity\Point $listePoint
     */
    public function removeListePoint(\IVS\IVStoreBundle\Entity\Point $listePoint)
    {
        $this->listePoints->removeElement($listePoint);
    }

    /**
     * Get listePoints
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getListePoints()
    {
        return $this->listePoints;
    }


}
