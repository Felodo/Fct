<?php

namespace FctBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use FctBundle\Entity\Alumno;
use FctBundle\Entity\Ciclo;
use FctBundle\Form\AlumnoType;

class AlumnoController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function create_alumnoAction(Request $request) {
        $alumno = new Alumno();
        $form = $this->createForm(AlumnoType::class, $alumno);

        $form->handleRequest($request);
        $status = "";

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();

                $alumno = $em->getRepository('FctBundle:Alumno')->findOneBy(array("nicknameAlu" => $form->get('nicknameAlu')->getData()));

                if (count($alumno) == 0) {
                    $alumno = new Alumno();
                    $alumno->setNifAlu($form->get('nifAlu')->getData());
                    $alumno->setNombreAlu($form->get('nombreAlu')->getData());
                    $alumno->setApellido1Alu($form->get('apellido1Alu')->getData());
                    $alumno->setApellido2Alu($form->get('apellido2Alu')->getData());
                    $alumno->setNicknameAlu($form->get('nicknameAlu')->getData());
                    $alumno->setDireccionAlu($form->get('direccionAlu')->getData());
                    $alumno->setPoblacionAlu($form->get('poblacionAlu')->getData());
                    $alumno->setProvinciaAlu($form->get('provinciaAlu')->getData());
                    $alumno->setCpostalAlu($form->get('cpostalAlu')->getData());
                    $alumno->setTelfFijoAlu($form->get('telfFijoAlu')->getData());
                    $alumno->setTelfMovilAlu($form->get('telfMovilAlu')->getData());
                    $alumno->setCodCiclo($form->get('codCiclo')->getData());
                    $alumno->setEmailAlu($form->get('emailAlu')->getData());
                    
                    //Obtenemos el entity manager
                    $em = $this->getDoctrine()->getManager();
                    //y persistimos los datos almacenándolos dentro de doctrine
                    $em->persist($alumno);
                    //Volcamos los datos del ORM en la base de datos
                    $flush = $em->flush();

                    if ($flush != NULL) {
                        $status = "Error: El alumno no se registró correctamente!! :(";
                    } else {
                        $status = "El alumno se ha registrado correctamente!! :)";
                    }
                }else{
                    $status = "Error: El alumno ya existe!! :(";
                }
            } else {
                $status = "Error: El alumno no se ha registrado, porque el formulario no es valido :(";
            }
            $this->session->getFlashBag()->add("status", $status);
        }



        return $this->render('FctBundle:Alumno:createAlumno.html.twig', array(
                    "status" => $status,
                    "form" => $form->createView()
        ));
    }

}
