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
     * @var integer
     */
    private $anio;

    /**
     * @var \FctBundle\Entity\Profesores
     */
    private $idProf;

    /**
     * @var \FctBundle\Entity\Empresas
     */
    private $idEmp;

    /**
     * @var \FctBundle\Entity\Alumnos
     */
    private $idAlu;


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
     * @param integer $anio
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
     * @return integer
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set idProf
     *
     * @param \FctBundle\Entity\Profesor $idProf
     *
     * @return Fct
     */
    public function setIdProf(\FctBundle\Entity\Profesor $idProf = null)
    {
        $this->idProf = $idProf;

        return $this;
    }

    /**
     * Get idProf
     *
     * @return \FctBundle\Entity\Profesor
     */
    public function getIdProf()
    {
        return $this->idProf;
    }

    /**
     * Set idEmp
     *
     * @param \FctBundle\Entity\Empresa $idEmp
     *
     * @return Fct
     */
    public function setIdEmp(\FctBundle\Entity\Empresa $idEmp = null)
    {
        $this->idEmp = $idEmp;

        return $this;
    }

    /**
     * Get idEmp
     *
     * @return \FctBundle\Entity\Empresa
     */
    public function getIdEmp()
    {
        return $this->idEmp;
    }

    /**
     * Set idAlu
     *
     * @param \FctBundle\Entity\Alumno $idAlu
     *
     * @return Fct
     */
    public function setIdAlu(\FctBundle\Entity\Alumno $idAlu = null)
    {
        $this->idAlu = $idAlu;

        return $this;
    }

    /**
     * Get idAlu
     *
     * @return \FctBundle\Entity\Alumno
     */
    public function getIdAlu()
    {
        return $this->idAlu;
    }
}
