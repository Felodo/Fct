<?php

namespace FctBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use FctBundle\Entity\Profesor;
use FctBundle\Form\ProfesorType;

class ProfesorController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function loginAction(Request $request) {
        $authenticationUtils = $this->get("security.authentication_utils");
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($error)
            $status = "Error: No te has logueado correctamente!! :(";
        else
            $status = "Te has logueado correctamente!! :)";

        return $this->render("FctBundle:Profesor:login.html.twig", [
                    "error" => $error,
                    "status" => $status,
                    "last_username" => $lastUsername
        ]);
    }

    public function create_profesorAction(Request $request) {
        $profesor = new Profesor();
        $form = $this->createForm(ProfesorType::class, $profesor);

        $form->handleRequest($request);
        $status = "";

        if ($form->isSubmitted()) {
            if ($form->isValid()) {


                $em = $this->getDoctrine()->getManager();
                // $profesor = $em->getRepository('FctBundle:Profesor')->findOneBy(array("nifProf"=>$form->get('nifProf')->getData()));
                $profesor = $em->getRepository('FctBundle:Profesor')->findOneBy(array("nicknameProf" => $form->get('nicknameProf')->getData()));
                //$profesor = $em->getRepository('AppBundle:Profesor')->find(array("passwordProf"=>$form->get('nicknameProf')->getData()));
                if (count($profesor) == 0) {
                    $profesor = new Profesor();
                    $profesor->setNifProf($form->get('nifProf')->getData());
                    $profesor->setNombreProf($form->get('nombreProf')->getData());
                    $profesor->setApellido1Prof($form->get('apellido1Prof')->getData());
                    $profesor->setApellido2Prof($form->get('apellido2Prof')->getData());
                    $profesor->setFotografiaProf(null);
                    $profesor->setNicknameProf($form->get('nicknameProf')->getData());
                    $profesor->setTelfFijoProf($form->get('telfFijoProf')->getData());
                    $profesor->setTelfMovilProf($form->get('telfMovilProf')->getData());
                    $profesor->setEmailProf($form->get('emailProf')->getData());

                    $factory = $this->get("security.encoder_factory");
                    $encoder = $factory->getEncoder($profesor);
                    $password = $encoder->encodePassword($form->get('passwordProf')->getData(), $profesor->getSalt());

                    $profesor->setPasswordProf($password);
                    $profesor->setRolProf("ROLE_PROFESOR");

                    //Obtenemos el entity manager
                    $em = $this->getDoctrine()->getManager();
                    //y persistimos los datos almacenándolos dentro de doctrine
                    $em->persist($profesor);
                    //Volcamos los datos del ORM en la base de datos
                    $flush = $em->flush();

                    if ($flush != NULL) {
                        $status = "Error: El profesor no se registró correctamente!! :(";
                    } else {
                        $status = "Te has tegistrado correctamente!! :)";
                    }
                } else {
                    $status = "Error: El profesor ya existe!! :(";
                }
            } else {
                $status = "Error: El profesor no se registró correctamente!! :(";
            }
            $this->session->getFlashBag()->add("status", $status);
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
