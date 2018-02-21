<?php

namespace FctBundle\Entity;

/**
 * Empresa
 */
class Empresa
{
    /**
     * @var string
     */
    private $cifEmp;

    /**
     * @var string
     */
    private $nombreEmp;

    /**
     * @var string
     */
    private $tutorEmp;

    /**
     * @var string
     */
    private $direccionEmp;

    /**
     * @var string
     */
    private $poblacionEmp;

    /**
     * @var string
     */
    private $cpostalEmp;

    /**
     * @var string
     */
    private $provinciaEmp;

    /**
     * @var string
     */
    private $telfFijoEmp;

    /**
     * @var string
     */
    private $telfMovilEmp;

    /**
     * @var string
     */
    private $emailEmp;


    /**
     * Get cifEmp
     *
     * @return string
     */
    public function getCifEmp()
    {
        return $this->cifEmp;
    }

    /**
     * Set nombreEmp
     *
     * @param string $nombreEmp
     *
     * @return Empresa
     */
    public function setNombreEmp($nombreEmp)
    {
        $this->nombreEmp = $nombreEmp;

        return $this;
    }

    /**
     * Get nombreEmp
     *
     * @return string
     */
    public function getNombreEmp()
    {
        return $this->nombreEmp;
    }

    /**
     * Set tutorEmp
     *
     * @param string $tutorEmp
     *
     * @return Empresa
     */
    public function setTutorEmp($tutorEmp)
    {
        $this->tutorEmp = $tutorEmp;

        return $this;
    }

    /**
     * Get tutorEmp
     *
     * @return string
     */
    public function getTutorEmp()
    {
        return $this->tutorEmp;
    }

    /**
     * Set direccionEmp
     *
     * @param string $direccionEmp
     *
     * @return Empresa
     */
    public function setDireccionEmp($direccionEmp)
    {
        $this->direccionEmp = $direccionEmp;

        return $this;
    }

    /**
     * Get direccionEmp
     *
     * @return string
     */
    public function getDireccionEmp()
    {
        return $this->direccionEmp;
    }

    /**
     * Set poblacionEmp
     *
     * @param string $poblacionEmp
     *
     * @return Empresa
     */
    public function setPoblacionEmp($poblacionEmp)
    {
        $this->poblacionEmp = $poblacionEmp;

        return $this;
    }

    /**
     * Get poblacionEmp
     *
     * @return string
     */
    public function getPoblacionEmp()
    {
        return $this->poblacionEmp;
    }

    /**
     * Set cpostalEmp
     *
     * @param string $cpostalEmp
     *
     * @return Empresa
     */
    public function setCpostalEmp($cpostalEmp)
    {
        $this->cpostalEmp = $cpostalEmp;

        return $this;
    }

    /**
     * Get cpostalEmp
     *
     * @return string
     */
    public function getCpostalEmp()
    {
        return $this->cpostalEmp;
    }

    /**
     * Set provinciaEmp
     *
     * @param string $provinciaEmp
     *
     * @return Empresa
     */
    public function setProvinciaEmp($provinciaEmp)
    {
        $this->provinciaEmp = $provinciaEmp;

        return $this;
    }

    /**
     * Get provinciaEmp
     *
     * @return string
     */
    public function getProvinciaEmp()
    {
        return $this->provinciaEmp;
    }

    /**
     * Set telfFijoEmp
     *
     * @param string $telfFijoEmp
     *
     * @return Empresa
     */
    public function setTelfFijoEmp($telfFijoEmp)
    {
        $this->telfFijoEmp = $telfFijoEmp;

        return $this;
    }

    /**
     * Get telfFijoEmp
     *
     * @return string
     */
    public function getTelfFijoEmp()
    {
        return $this->telfFijoEmp;
    }

    /**
     * Set telfMovilEmp
     *
     * @param string $telfMovilEmp
     *
     * @return Empresa
     */
    public function setTelfMovilEmp($telfMovilEmp)
    {
        $this->telfMovilEmp = $telfMovilEmp;

        return $this;
    }

    /**
     * Get telfMovilEmp
     *
     * @return string
     */
    public function getTelfMovilEmp()
    {
        return $this->telfMovilEmp;
    }

    /**
     * Set emailEmp
     *
     * @param string $emailEmp
     *
     * @return Empresa
     */
    public function setEmailEmp($emailEmp)
    {
        $this->emailEmp = $emailEmp;

        return $this;
    }

    /**
     * Get emailEmp
     *
     * @return string
     */
    public function getEmailEmp()
    {
        return $this->emailEmp;
    }
}

