<?php

namespace FctBundle\Entity;

/**
 * Alumno
 */
class Alumno
{
    /**
     * @var integer
     */
    private $idAlu;

    /**
     * @var string
     */
    private $nifAlu;

    /**
     * @var string
     */
    private $nombreAlu;

    /**
     * @var string
     */
    private $apellido1Alu;

    /**
     * @var string
     */
    private $apellido2Alu;

    /**
     * @var string
     */
    private $fotografiaAlu;

    /**
     * @var string
     */
    private $nicknameAlu;

    /**
     * @var string
     */
    private $direccionAlu;

    /**
     * @var string
     */
    private $poblacionAlu;

    /**
     * @var integer
     */
    private $cpostalAlu;

    /**
     * @var integer
     */
    private $provinciaAlu;

    /**
     * @var integer
     */
    private $telfFijoAlu;

    /**
     * @var integer
     */
    private $telfMovilAlu;

    /**
     * @var string
     */
    private $emailAlu;

    /**
     * @var \FctBundle\Entity\Ciclo
     */
    private $codCiclo;


    /**
     * Get idAlu
     *
     * @return integer
     */
    public function getIdAlu()
    {
        return $this->idAlu;
    }

    /**
     * Set nifAlu
     *
     * @param string $nifAlu
     *
     * @return Alumno
     */
    public function setNifAlu($nifAlu)
    {
        $this->nifAlu = $nifAlu;

        return $this;
    }

    /**
     * Get nifAlu
     *
     * @return string
     */
    public function getNifAlu()
    {
        return $this->nifAlu;
    }

    /**
     * Set nombreAlu
     *
     * @param string $nombreAlu
     *
     * @return Alumno
     */
    public function setNombreAlu($nombreAlu)
    {
        $this->nombreAlu = $nombreAlu;

        return $this;
    }

    /**
     * Get nombreAlu
     *
     * @return string
     */
    public function getNombreAlu()
    {
        return $this->nombreAlu;
    }

    /**
     * Set apellido1Alu
     *
     * @param string $apellido1Alu
     *
     * @return Alumno
     */
    public function setApellido1Alu($apellido1Alu)
    {
        $this->apellido1Alu = $apellido1Alu;

        return $this;
    }

    /**
     * Get apellido1Alu
     *
     * @return string
     */
    public function getApellido1Alu()
    {
        return $this->apellido1Alu;
    }

    /**
     * Set apellido2Alu
     *
     * @param string $apellido2Alu
     *
     * @return Alumno
     */
    public function setApellido2Alu($apellido2Alu)
    {
        $this->apellido2Alu = $apellido2Alu;

        return $this;
    }

    /**
     * Get apellido2Alu
     *
     * @return string
     */
    public function getApellido2Alu()
    {
        return $this->apellido2Alu;
    }

    /**
     * Set fotografiaAlu
     *
     * @param string $fotografiaAlu
     *
     * @return Alumno
     */
    public function setFotografiaAlu($fotografiaAlu)
    {
        $this->fotografiaAlu = $fotografiaAlu;

        return $this;
    }

    /**
     * Get fotografiaAlu
     *
     * @return string
     */
    public function getFotografiaAlu()
    {
        return $this->fotografiaAlu;
    }

    /**
     * Set nicknameAlu
     *
     * @param string $nicknameAlu
     *
     * @return Alumno
     */
    public function setNicknameAlu($nicknameAlu)
    {
        $this->nicknameAlu = $nicknameAlu;

        return $this;
    }

    /**
     * Get nicknameAlu
     *
     * @return string
     */
    public function getNicknameAlu()
    {
        return $this->nicknameAlu;
    }

    /**
     * Set direccionAlu
     *
     * @param string $direccionAlu
     *
     * @return Alumno
     */
    public function setDireccionAlu($direccionAlu)
    {
        $this->direccionAlu = $direccionAlu;

        return $this;
    }

    /**
     * Get direccionAlu
     *
     * @return string
     */
    public function getDireccionAlu()
    {
        return $this->direccionAlu;
    }

    /**
     * Set poblacionAlu
     *
     * @param string $poblacionAlu
     *
     * @return Alumno
     */
    public function setPoblacionAlu($poblacionAlu)
    {
        $this->poblacionAlu = $poblacionAlu;

        return $this;
    }

    /**
     * Get poblacionAlu
     *
     * @return string
     */
    public function getPoblacionAlu()
    {
        return $this->poblacionAlu;
    }

    /**
     * Set cpostalAlu
     *
     * @param integer $cpostalAlu
     *
     * @return Alumno
     */
    public function setCpostalAlu($cpostalAlu)
    {
        $this->cpostalAlu = $cpostalAlu;

        return $this;
    }

    /**
     * Get cpostalAlu
     *
     * @return integer
     */
    public function getCpostalAlu()
    {
        return $this->cpostalAlu;
    }

    /**
     * Set provinciaAlu
     *
     * @param integer $provinciaAlu
     *
     * @return Alumno
     */
    public function setProvinciaAlu($provinciaAlu)
    {
        $this->provinciaAlu = $provinciaAlu;

        return $this;
    }

    /**
     * Get provinciaAlu
     *
     * @return integer
     */
    public function getProvinciaAlu()
    {
        return $this->provinciaAlu;
    }

    /**
     * Set telfFijoAlu
     *
     * @param integer $telfFijoAlu
     *
     * @return Alumno
     */
    public function setTelfFijoAlu($telfFijoAlu)
    {
        $this->telfFijoAlu = $telfFijoAlu;

        return $this;
    }

    /**
     * Get telfFijoAlu
     *
     * @return integer
     */
    public function getTelfFijoAlu()
    {
        return $this->telfFijoAlu;
    }

    /**
     * Set telfMovilAlu
     *
     * @param integer $telfMovilAlu
     *
     * @return Alumno
     */
    public function setTelfMovilAlu($telfMovilAlu)
    {
        $this->telfMovilAlu = $telfMovilAlu;

        return $this;
    }

    /**
     * Get telfMovilAlu
     *
     * @return integer
     */
    public function getTelfMovilAlu()
    {
        return $this->telfMovilAlu;
    }

    /**
     * Set emailAlu
     *
     * @param string $emailAlu
     *
     * @return Alumno
     */
    public function setEmailAlu($emailAlu)
    {
        $this->emailAlu = $emailAlu;

        return $this;
    }

    /**
     * Get emailAlu
     *
     * @return string
     */
    public function getEmailAlu()
    {
        return $this->emailAlu;
    }

    /**
     * Set codCiclo
     *
     * @param \FctBundle\Entity\Ciclo $codCiclo
     *
     * @return Alumno
     */
    public function setCodCiclo(\FctBundle\Entity\Ciclo $codCiclo = null)
    {
        $this->codCiclo = $codCiclo;

        return $this;
    }

    /**
     * Get codCiclo
     *
     * @return \FctBundle\Entity\Ciclo
     */
    public function getCodCiclo()
    {
        return $this->codCiclo;
    }
}
