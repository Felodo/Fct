<?php

namespace FctBundle\Entity;

/**
 * Ciclo
 */
class Ciclo
{
    /**
     * @var integer
     */
    private $idCiclo;

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
     * @var integer
     */
    private $horasfct;


    /**
     * Get idCiclo
     *
     * @return integer
     */
    public function getIdCiclo()
    {
        return $this->idCiclo;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     *
     * @return Ciclo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

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
     * @param integer $horasfct
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
     * @return integer
     */
    public function getHorasfct()
    {
        return $this->horasfct;
    }
}
