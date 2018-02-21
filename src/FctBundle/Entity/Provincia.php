<?php

namespace FctBundle\Entity;

/**
 * Provincia
 */
class Provincia
{
    /**
     * @var string
     */
    private $idProvincia;

    /**
     * @var string
     */
    private $nombre;


    /**
     * Get idProvincia
     *
     * @return string
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

