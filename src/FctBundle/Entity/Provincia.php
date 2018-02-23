<?php

namespace FctBundle\Entity;

/**
 * Provincia
 */
class Provincia
{
    /**
     * @var integer
     */
    private $idProvincia;

    /**
     * @var string
     */
    private $nombre;


    /**
     * Get idProvincia
     *
     * @return integer
     */
    public function getIdProvincia()
    {
        return $this->idProvincia;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Provincia
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }
}
