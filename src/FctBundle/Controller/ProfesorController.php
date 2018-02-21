<?php

namespace FctBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FctBundle\Entity\Profesor;
use FctBundle\Form\ProfesorType;

class ProfesorController extends Controller
{
    public function loginAction(Request $resquest)
    {
        $authenticationUtils = $this->get("security.authentication_utils");
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render("FctBundle:Profesor:login.html.twig", [
            "error" => $error,
            "last_username" => $lastUsername
        ]);
    }
    
    public function create_profesorAction(Request $request)
    {
        $profesor = new Profesor();
        $form = $this->createForm(ProfesorType::class,$profesor);
        
        $form ->handleRequest($request);
        
        if($form->isValid()){
            $profesor = new Profesor();
            $profesor->setNombreProf($form->get('nombreProf')->getData());
            $profesor->setApellido1Prof($form->get('apellido1Prof')->getData());
            $profesor->setApellido2Prof($form->get('apellido2Prof')->getData());
            $profesor->setFotografiaProf($form->get('fotografiaProf')->getData());
            $profesor->setNicknameProf($form->get('nicknameProf')->getData());
            $profesor->setTelfFijoProf($form->get('telfFijoProf')->getData());
            $profesor->setTelfMovilProf($form->get('telfMovilProf')->getData());
            $profesor->setEmailProf($form->get('emailProf')->getData());
            $profesor->setPasswordProf($form->get('passwordProf')->getData());
            $status = "El profesor se ha creado correctamente";
        }else{
            $status = "No te has resgistrado correctamente";
        }
        
        return $this->render("FctBundle:Profesor:createProfesor.html.twig", [
            //"error" => $error,
            //"last_username" => $lastUsername,
            "status" => $status,
            "form" => $form->createView()
        ]);
        
        //$em = $this->getDoctrine()->getManager();
    }
}
