<?php

namespace FctBundle\Entity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Profesor
 */

class Profesor implements UserInterface
{
    /**
     * @var string
     */
    private $nifProf;

    /**
     * @var string
     */
    private $nombreProf;

    /**
     * @var string
     */
    private $apellido1Prof;

    /**
     * @var string
     */
    private $apellido2Prof;

    /**
     * @var string
     */
    private $fotografiaProf;

    /**
     * @var string
     */
    private $nicknameProf;

    /**
     * @var string
     */
    private $telfFijoProf;

    /**
     * @var string
     */
    private $telfMovilProf;

    /**
     * @var string
     */
    private $emailProf;

    /**
     * @var string
     */
    private $passwordProf;

    /**
     * @var string
     */
    private $rolProf;

    
    // AUTH
    
    public function getUsername() {
        return $this->nicknameProf;
    }
    
    public function getSalt() {
        return null;
    }
    
    public function getRoles() {
        return array($this->getRolProf());
    }
    
    public function eraseCredentials() {
        
    }


    // END AUTH

    /**
     * Get nifProf
     *
     * @return string
     */
    public function getNifProf()
    {
        return $this->nifProf;
    }

    /**
     * Set nombreProf
     *
     * @param string $nombreProf
     *
     * @return Profesor
     */
    public function setNombreProf($nombreProf)
    {
        $this->nombreProf = $nombreProf;

        return $this;
    }

    /**
     * Get nombreProf
     *
     * @return string
     */
    public function getNombreProf()
    {
        return $this->nombreProf;
    }

    /**
     * Set apellido1Prof
     *
     * @param string $apellido1Prof
     *
     * @return Profesor
     */
    public function setApellido1Prof($apellido1Prof)
    {
        $this->apellido1Prof = $apellido1Prof;

        return $this;
    }

    /**
     * Get apellido1Prof
     *
     * @return string
     */
    public function getApellido1Prof()
    {
        return $this->apellido1Prof;
    }

    /**
     * Set apellido2Prof
     *
     * @param string $apellido2Prof
     *
     * @return Profesor
     */
    public function setApellido2Prof($apellido2Prof)
    {
        $this->apellido2Prof = $apellido2Prof;

        return $this;
    }

    /**
     * Get apellido2Prof
     *
     * @return string
     */
    public function getApellido2Prof()
    {
        return $this->apellido2Prof;
    }

    /**
     * Set fotografiaProf
     *
     * @param string $fotografiaProf
     *
     * @return Profesor
     */
    public function setFotografiaProf($fotografiaProf)
    {
        $this->fotografiaProf = $fotografiaProf;

        return $this;
    }

    /**
     * Get fotografiaProf
     *
     * @return string
     */
    public function getFotografiaProf()
    {
        return $this->fotografiaProf;
    }

    /**
     * Set nicknameProf
     *
     * @param string $nicknameProf
     *
     * @return Profesor
     */
    public function setNicknameProf($nicknameProf)
    {
        $this->nicknameProf = $nicknameProf;

        return $this;
    }

    /**
     * Get nicknameProf
     *
     * @return string
     */
    public function getNicknameProf()
    {
        return $this->nicknameProf;
    }

    /**
     * Set telfFijoProf
     *
     * @param string $telfFijoProf
     *
     * @return Profesor
     */
    public function setTelfFijoProf($telfFijoProf)
    {
        $this->telfFijoProf = $telfFijoProf;

        return $this;
    }

    /**
     * Get telfFijoProf
     *
     * @return string
     */
    public function getTelfFijoProf()
    {
        return $this->telfFijoProf;
    }

    /**
     * Set telfMovilProf
     *
     * @param string $telfMovilProf
     *
     * @return Profesor
     */
    public function setTelfMovilProf($telfMovilProf)
    {
        $this->telfMovilProf = $telfMovilProf;

        return $this;
    }

    /**
     * Get telfMovilProf
     *
     * @return string
     */
    public function getTelfMovilProf()
    {
        return $this->telfMovilProf;
    }

    /**
     * Set emailProf
     *
     * @param string $emailProf
     *
     * @return Profesor
     */
    public function setEmailProf($emailProf)
    {
        $this->emailProf = $emailProf;

        return $this;
    }

    /**
     * Get emailProf
     *
     * @return string
     */
    public function getEmailProf()
    {
        return $this->emailProf;
    }

    /**
     * Set passwordProf
     *
     * @param string $passwordProf
     *
     * @return Profesor
     */
    public function setPasswordProf($passwordProf)
    {
        $this->passwordProf = $passwordProf;

        return $this;
    }
    public function setPassword($passwordProf)
    {
        $this->passwordProf = $passwordProf;

        return $this;
    }

    /**
     * Get passwordProf
     *
     * @return string
     */
    public function getPasswordProf()
    {
        return $this->passwordProf;
    }
    public function getPassword()
    {
        return $this->passwordProf;
    }

    /**
     * Set rolProf
     *
     * @param string $rolProf
     *
     * @return Profesor
     */
    public function setRolProf($rolProf)
    {
        $this->rolProf = $rolProf;

        return $this;
    }

    /**
     * Get rolProf
     *
     * @return string
     */
    public function getRolProf()
    {
        return $this->rolProf;
    }
}

