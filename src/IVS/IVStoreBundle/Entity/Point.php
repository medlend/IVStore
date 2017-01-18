<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16/01/17
 * Time: 12:10
 */

namespace IVS\IVStoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Zone
 *
 * @ORM\Table(name="Point")
 * @ORM\Entity
 */
class Point
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
     * @var float
     *
     * @ORM\Column(name="x", type="float", nullable=false)
     */
    private $x;

    /**
     * @var float
     *
     * @ORM\Column(name="y", type="float",  nullable=false)
     */
    private $y;
    /**
     * @var Zone
     *
     * @ORM\ManyToOne(targetEntity="IVS\IVStoreBundle\Entity\Zone", inversedBy="listePoints",cascade={"all"} )
     *
     *
     */
    private $zone;



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
     * Set x
     *
     * @param float $x
     *
     * @return Point
     */
    public function setX($x)
    {
        $this->x = $x;

        return $this;
    }

    /**
     * Get x
     *
     * @return float
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Set y
     *
     * @param float $y
     *
     * @return Point
     */
    public function setY($y)
    {
        $this->y = $y;

        return $this;
    }

    /**
     * Get y
     *
     * @return float
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Set zone
     *
     * @param \IVS\IVStoreBundle\Entity\Zone $zone
     *
     * @return Point
     */
    public function setZone(\IVS\IVStoreBundle\Entity\Zone $zone = null)
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * Get zone
     *
     * @return \IVS\IVStoreBundle\Entity\Zone
     */
    public function getZone()
    {
        return $this->zone;
    }
}
