<?php

namespace FctBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use FctBundle\Form\CicloType;
use FctBundle\Entity\Ciclo;
use FctBundle\Form\AlumnoType;

class CicloController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $ciclo_repo = $em->getRepository("FctBundle:Ciclo");
        $ciclos = $ciclo_repo->findAll();
        $ciclo1 = [];


        foreach ($ciclos as $ciclo) {
            $ciclo1['id_ciclo'] = $ciclo->getIdCiclo();
            $ciclo1['codigo'] = $ciclo->getCodigo();
            $ciclo1['nombreCiclo'] = $ciclo->getNombreCiclo();
            $ciclo1['grado'] = $ciclo->getGrado();
            $ciclo1['horas'] = $ciclo->getHorasfct();
            $ciclos1[] = $ciclo1;
        }



        return $this->render('FctBundle:Ciclo:index.html.twig', array(
                    "ciclos" => $ciclos1,
        ));
        //return $this->render('FctBundle:Default:index.html.twig');
    }

    public function create_cicloAction(Request $request) 
    {
        $ciclo = new Ciclo();
        $form = $this->createForm(CicloType::class, $ciclo);

        $form->handleRequest($request);
        $status = "";
        /* $em = $this->getDoctrine()->getManager();

          $ciclo_repo = $em ->getRepository("FctBundle:Ciclo");
          $ciclos = $ciclo_repo->findAll();
          $ciclo1 = [];


          foreach($ciclos as $ciclo){
          $ciclo1['id_ciclo'] = $ciclo->getIdCiclo();
          $ciclo1['codigo'] = $ciclo-> getCodigo();
          $ciclo1['nombreCiclo'] = $ciclo->getNombreCiclo();
          $ciclo1['grado'] = $ciclo->getGrado();
          $ciclo1['horas'] = $ciclo->getHorasfct();
          $ciclos1[] = $ciclo1;
          }
         */
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();

                $ciclo = $em->getRepository('FctBundle:Ciclo')->findOneBy(array("codigo" => $form->get('codigo')->getData()));

                if (count($ciclo) == 0) {
                    $ciclo = new Alumno();
                    $ciclo->setCodigo($form->get('codigo')->getData());
                    $ciclo->setNombreCiclo($form->get('nombreCiclo')->getData());
                    $ciclo->setGrado($form->get('grado')->getData());
                    $ciclo->setHorasfct($form->get('horas')->getData());

                    //Obtenemos el entity manager
                    $em = $this->getDoctrine()->getManager();
                    //y persistimos los datos almacenándolos dentro de doctrine
                    $em->persist($ciclo);
                    //Volcamos los datos del ORM en la base de datos
                    $flush = $em->flush();

                    if ($flush != NULL) 
                    {
                        $status = "Error: El alumno no se registró correctamente!! :(";
                    } else {
                        $status = "El alumno se ha registrado correctamente!! :)";
                    }
                } else {
                    $status = "Error: El alumno ya existe!! :(";
                }
            } else {
                $status = "Error: El alumno no se ha registrado, porque el formulario no es valido :(";
            }
            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("fct_index_ciclo");
        }


        return $this->render('FctBundle:Ciclo:createCiclo.html.twig', array(
                    "status" => $status,
                    "form" => $form->createView()
        ));
    }

    public function delete_cicloAction($id_ciclo) {
        $em = $this->getDoctrine()->getManager();
        $ciclo_repo = $em->getRepository("FctBundle:Ciclo");
        $ciclo = $ciclo_repo->find($id_ciclo);

        if (count($ciclo->getAlumno()) == 0) {
            $em->remove($ciclo);
            $flush = $em->flush();
            
             if ($flush != NULL) {
                $status = "Error: El ciclo no se pudo eliminar correctamente!! :(";
            } else {
                $status = "El ciclo se ha eliminado correctamente!! :)";
            }
            //return $this->render('FctBundle:Ciclo:index.html.twig');
        }else{
            $status = "Error: El ciclo no se pudo eliminar, porque hay alumnos registrados :(";
        }
        $this->session->getFlashBag()->add("status", $status);
        return $this->redirectToRoute('fct_index_ciclos');
    }
    
    public function edit_cicloAction(Request $request, $id_ciclo){
        $em = $this->getDoctrine()->getManager();
        $ciclo_repo = $em->getRepository("FctBundle:Ciclo");
        $ciclo = $ciclo_repo->find($id_ciclo);

        $form = $this->createForm(CicloType::class, $ciclo);
        
		$form->handleRequest($request);
		
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $ciclo->setCodigo($form->get('codigo')->getData());
                $ciclo->setNombreCiclo($form->get('nombreCiclo')->getData());
                $ciclo->setGrado($form->get('grado')->getData());
                $ciclo->setHorasfct($form->get('horas')->getData());
                
                $em->persist($ciclo);
                //Volcamos los datos del ORM en la base de datos
                $flush = $em->flush();

                if ($flush != NULL) {
                    $status = "Error: El ciclo no se registró correctamente!! :(";
                } else {
                    $status = "El ciclo se ha registrado correctamente!! :)";
                }
            }else{
                $status = "Error: El ciclo no se ha registrado, porque el formulario no es valido :(";
            }
            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("fct_index_ciclo");
        }
        
        return $this->render('FctBundle:Ciclo:editCiclo.html.twig', array(
                    "form" => $form->createView()
        ));
    }

}
