<?php

namespace FctBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use FctBundle\Form\FctType;
use FctBundle\Entity\Fct;

class FctController extends Controller
{
    private $session;

    public function __construct() {
        $this->session = new Session();
    }
    
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fct_repo = $em->getRepository("FctBundle:Fct");
        $fcts = $fct_repo->findAll();
        $fcts1 = [];
        
        foreach ($fcts as $fct) {
            $fct1['id_fct'] = $fct->getIdFct();
            $fct1['anio'] = $fct->getAnio();
            $fct1['nombreProf'] = $fct->getIdProf()->getNifProf()." / ";
            $fct1['nombreProf'] .= $fct->getIdProf()->getNombreProf()." ";
            $fct1['nombreProf'] .= $fct->getIdProf()->getApellido1Prof(). " ";
            $fct1['nombreProf'] .= $fct->getIdProf()->getApellido2Prof();
            $fct1['nombreEmp'] = $fct->getIdEmp()->getCifEmp()." / ";
            $fct1['nombreEmp'] .= $fct->getIdEmp()->getNombreEmp();
            $fct1['nombreAlu'] = $fct->getIdAlu()->getNifAlu()." / ";
            $fct1['nombreAlu'] .= $fct->getIdAlu()->getNombreAlu()." ";
            $fct1['nombreAlu'] .= $fct->getIdAlu()->getApellido1Alu(). " ";
            $fct1['nombreAlu'] .= $fct->getIdAlu()->getApellido2Alu();
            $fcts1[]= $fct1;
        }
        return $this->render('FctBundle:Fct:index.html.twig', array(
                    "fcts" => $fcts1,
        ));
        //return $this->render('FctBundle:Ciclo:index.html.twig');
    }
    
    public function create_fctAction(Request $request){
        $fct = new Fct();
        $form = $this->createForm(FctType::class, $fct);

        $form->handleRequest($request);
        $status = "";
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $fct = $em->getRepository('FctBundle:Fct')->findOneBy(array("idFct" => $form->get('idFct')->getData()));
                
                if (count($fct) == 0) {
                    $fct = new Fct();
                    $fct->setAnio($form->get('anio')->getData());
                    $fct->setIdProf($form->get('idProf')->getData());
                    $fct->setIdAlu($form->get('idAlu')->getData());
                    $fct->setIdEmp($form->get('idEmp')->getData());
                    
                    //Obtenemos el entity manager
                    $em = $this->getDoctrine()->getManager();
                    //y persistimos los datos almacenándolos dentro de doctrine
                    $em->persist($fct);
                    //Volcamos los datos del ORM en la base de datos
                    $flush = $em->flush();

                    if ($flush != NULL) {
                        $status = "Error: La empresa no se registró correctamente!! :(";
                    } else {
                        $status = "La empresa se ha registrado correctamente!! :)";
                    }
                }else{
                    $status = "Error: La empresa ya existe!! :(";
                }

            }else{
                $status = "Error: La empresa no se ha registrado, porque el formulario no es valido :(";
            }
            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("fct_index_fct");
        }
        return $this->render('FctBundle:Fct:createFct.html.twig', array(
                    "status" => $status,
                    "form" => $form->createView()
        ));
        
        
        
    }
}
