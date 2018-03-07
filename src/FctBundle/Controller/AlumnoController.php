<?php

namespace FctBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use FctBundle\Entity\Alumno;
use FctBundle\Entity\Ciclo;
use FctBundle\Form\AlumnoType;
use FctBundle\Repository\AlumnoRepository;

class AlumnoController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction($page) {

        $em = $this->getDoctrine()->getManager();

        $alumno_repo = $em->getRepository("FctBundle:Alumno");
        $alumnos = $alumno_repo->getPaginationAlumno(5, $page);//findAll();
        
        $totalitems = count($alumnos);
        $pagesCount=ceil($totalitems/5);
        
        
        
        $alumnos1 = [];
        $ciclo_repo = $em->getRepository("FctBundle:Ciclo");
        $ciclos = $ciclo_repo->findAll();

        foreach ($alumnos as $alumno) {
            $alumno1['id_alu'] = $alumno->getIdAlu();
            $alumno1['nif'] = $alumno->getNifAlu();
            $alumno1['nickname'] = $alumno->getNicknameAlu();
            $alumno1['nombre'] = $alumno->getNombreAlu();
            $alumno1['apellido1'] = $alumno->getApellido1Alu();
            $alumno1['apellido2'] = $alumno->getApellido2Alu();
            $alumno1['email'] = $alumno->getEmailAlu();
            $alumno1['codigoCiclo'] = $alumno->getCodCiclo()->getCodigo();
            $alumnos1[] = $alumno1;
        }



        return $this->render('FctBundle:Alumno:index.html.twig', array(
                    "alumnos" => $alumnos1,
                    "totalitems" => $totalitems,
                    "pagesCount" => $pagesCount,
                    "page" => $page
        ));
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


                    $file = $form['fotografiaAlu']->getData();

                    if (!empty($file) && $file = null) {
                        $ext = $file->guessExtension();
                        $file_name = $alumno->getNicknameAlu() . "." . $ext;
                        $file->move('../assets/imagen', $file_name);
                        $alumno->setFotografiaAlu($file_name);
                    } else {
                        $alumno->setFotografiaAlu(null);
                    }

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
                } else {
                    $status = "Error: El alumno ya existe!! :(";
                }
            } else {
                $status = "Error: El alumno no se ha registrado, porque el formulario no es valido :(";
            }
            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("fct_index_alumno");
        }



        return $this->render('FctBundle:Alumno:createAlumno.html.twig', array(
                    "status" => $status,
                    "form" => $form->createView()
        ));
    }

    public function delete_alumnoAction($id_alu) {
        $em = $this->getDoctrine()->getManager();
        $alumno_repo = $em->getRepository("FctBundle:Alumno");
        $alumno = $alumno_repo->find($id_alu);

        if (count($alumno->getFct()) == 0) {
            $em->remove($alumno);
            $flush = $em->flush();

            if ($flush != NULL) {
                $status = "Error: El alumno no se pudo eliminar correctamente!! :(";
            } else {
                $status = "El alumno se ha eliminado correctamente!! :)";
            }


            //return $this->render('FctBundle:Ciclo:index.html.twig');
        } else {
            $status = "Error: El alumno no se pudo eliminar correctamente!! Está asociado a una fct :(";
        }
        $this->session->getFlashBag()->add("status", $status);
        return $this->redirectToRoute('fct_index_alumno');
    }

    public function edit_alumnoAction(Request $request, $id_alu) {
        $em = $this->getDoctrine()->getManager();
        $alumno = $em->getRepository("FctBundle:Alumno")->find($id_alu);


        $form = $this->createForm(AlumnoType::class, $alumno);



        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {
                //$alumno = new Alumno();
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


                $file = $form['fotografiaAlu']->getData();

                if (!empty($file) && $file == null) {
                    $ext = $file->guessExtension();
                    $file_name = $alumno->getNicknameAlu() . "." . $ext;
                    $file->move('../assets/imagen', $file_name);
                    $alumno->setFotografiaAlu($file_name);
                } else {
                    $alumno->setFotografiaAlu(null);
                }

                //Obtenemos el entity manager
                //$em = $this->getDoctrine()->getManager();
                //y persistimos los datos almacenándolos dentro de doctrine
                $em->persist($alumno);
                //Volcamos los datos del ORM en la base de datos
                $flush = $em->flush();

                if ($flush != NULL) {
                    $status = "Error: El alumno no se registró correctamente!! :(";
                } else {
                    $status = "El alumno se ha registrado correctamente!! :)";
                }
            } else {
                $status = "Error: El alumno no se ha registrado, porque el formulario no es valido :(";
            }
            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("fct_index_alumno");
        }
        //return $this->redirectToRoute("fct_index_alumno");

        return $this->render('FctBundle:Alumno:editAlumno.html.twig', array(
                    "form" => $form->createView()
        ));
    }

}
