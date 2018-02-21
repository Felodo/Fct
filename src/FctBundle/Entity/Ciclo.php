<?php

namespace FctBundle\Entity;

/**
 * Ciclo
 */
class Ciclo
{
    /**
     * @var string
     */
    private $codigo;

    /**
     * @var string
     */
    private $nombreCiclo;

    /**
     * @var string
     */
    private $grado;

    /**
     * @var string
     */
    private $horasfct;


    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nombreCiclo
     *
     * @param string $nombreCiclo
     *
     * @return Ciclo
     */
    public function setNombreCiclo($nombreCiclo)
    {
        $this->nombreCiclo = $nombreCiclo;

        return $this;
    }

    /**
     * Get nombreCiclo
     *
     * @return string
     */
    public function getNombreCiclo()
    {
        return $this->nombreCiclo;
    }

    /**
     * Set grado
     *
     * @param string $grado
     *
     * @return Ciclo
     */
    public function setGrado($grado)
    {
        $this->grado = $grado;

        return $this;
    }

    /**
     * Get grado
     *
     * @return string
     */
    public function getGrado()
    {
        return $this->grado;
    }

    /**
     * Set horasfct
     *
     * @param string $horasfct
     *
     * @return Ciclo
     */
    public function setHorasfct($horasfct)
    {
        $this->horasfct = $horasfct;

        return $this;
    }

    /**
     * Get horasfct
     *
     * @return string
     */
    public function getHorasfct()
    {
        return $this->horasfct;
    }
}

