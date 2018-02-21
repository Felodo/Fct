<?php

namespace FctBundle\Entity;

/**
 * Fct
 */
class Fct
{
    /**
     * @var integer
     */
    private $idFct;

    /**
     * @var string
     */
    private $anio;

    /**
     * @var \FctBundle\Entity\Profesores
     */
    private $nifProf;

    /**
     * @var \FctBundle\Entity\Empresas
     */
    private $cifEmp;

    /**
     * @var \FctBundle\Entity\Alumnos
     */
    private $nifAlu;


    /**
     * Get idFct
     *
     * @return integer
     */
    public function getIdFct()
    {
        return $this->idFct;
    }

    /**
     * Set anio
     *
     * @param string $anio
     *
     * @return Fct
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return string
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set nifProf
     *
     * @param \FctBundle\Entity\Profesores $nifProf
     *
     * @return Fct
     */
    public function setNifProf(\FctBundle\Entity\Profesores $nifProf = null)
    {
        $this->nifProf = $nifProf;

        return $this;
    }

    /**
     * Get nifProf
     *
     * @return \FctBundle\Entity\Profesores
     */
    public function getNifProf()
    {
        return $this->nifProf;
    }

    /**
     * Set cifEmp
     *
     * @param \FctBundle\Entity\Empresas $cifEmp
     *
     * @return Fct
     */
    public function setCifEmp(\FctBundle\Entity\Empresas $cifEmp = null)
    {
        $this->cifEmp = $cifEmp;

        return $this;
    }

    /**
     * Get cifEmp
     *
     * @return \FctBundle\Entity\Empresas
     */
    public function getCifEmp()
    {
        return $this->cifEmp;
    }

    /**
     * Set nifAlu
     *
     * @param \FctBundle\Entity\Alumnos $nifAlu
     *
     * @return Fct
     */
    public function setNifAlu(\FctBundle\Entity\Alumnos $nifAlu = null)
    {
        $this->nifAlu = $nifAlu;

        return $this;
    }

    /**
     * Get nifAlu
     *
     * @return \FctBundle\Entity\Alumnos
     */
    public function getNifAlu()
    {
        return $this->nifAlu;
    }
}

