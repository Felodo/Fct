<?php

namespace FctBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use FctBundle\Form\EmpresaType;
use FctBundle\Entity\Empresa;

class EmpresaController extends Controller
{
    private $session;

    public function __construct() {
        $this->session = new Session();
    }
    
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $empresa_repo = $em->getRepository("FctBundle:Empresa");
        $empresas = $empresa_repo->findAll();
        $empresas1 = [];
        

        foreach ($empresas as $empresa) {
            $empresa1['id_emp'] = $empresa->getIdEmp();
            $empresa1['cif'] = $empresa->getCifEmp();
            $empresa1['nombre'] = $empresa->getNombreEmp();
            $empresa1['tutor'] = $empresa->getTutorEmp();
            $empresa1['direccion'] = $empresa->getDireccionEmp();
            $empresa1['poblacion'] = $empresa->getPoblacionEmp();
            $empresa1['cpostal'] = $empresa->getCpostalEmp();
            $empresa1['provincia'] = $empresa->getProvinciaEmp()->getNombre();
            $empresa1['telffijo']=$empresa->getTelfFijoEmp();
            $empresa1['telfmovil']=$empresa->getTelfMovilEmp();
            $empresa1['email']=$empresa->getEmailEmp();
            $empresas1[] = $empresa1;
        }



        return $this->render('FctBundle:Empresa:index.html.twig', array(
                    "empresas" => $empresas1,
        ));
        
        
        //return $this->render('FctBundle:Ciclo:index.html.twig');
    }
    
    public function create_empresaAction(Request $request){
        $empresa = new Empresa();
        $form = $this->createForm(EmpresaType::class, $empresa);

        $form->handleRequest($request);
        $status = "";
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();

                $empresa = $em->getRepository('FctBundle:Empresa')->findOneBy(array("cifEmp" => $form->get('cifEmp')->getData()));

                if (count($empresa) == 0) {
                    $empresa = new Empresa();
                    $empresa->setCifEmp($form->get('cifEmp')->getData());
                    $empresa->setNombreEmp($form->get('nombreEmp')->getData());
                    $empresa->setTutorEmp($form->get('tutorEmp')->getData());
                    $empresa->setDireccionEmp($form->get('direccionEmp')->getData());
                    $empresa->setPoblacionEmp($form->get('poblacionEmp')->getData());
                    $empresa->setCpostalEmp($form->get('cpostalEmp')->getData());
                    $empresa->setProvinciaEmp($form->get('provinciaEmp')->getData());
                    $empresa->setTelfFijoEmp($form->get('telfFijoEmp')->getData());
                    $empresa->setTelfMovilEmp($form->get('telfMovilEmp')->getData());
                    $empresa->setEmailEmp($form->get('emailEmp')->getData());
                    

                    //Obtenemos el entity manager
                    $em = $this->getDoctrine()->getManager();
                    //y persistimos los datos almacenándolos dentro de doctrine
                    $em->persist($empresa);
                    //Volcamos los datos del ORM en la base de datos
                    $flush = $em->flush();

                    if ($flush != NULL) {
                        $status = "Error: La empresa no se registró correctamente!! :(";
                    } else {
                        $status = "La empresa se ha registrado correctamente!! :)";
                    }
                } else {
                    $status = "Error: La empresa ya existe!! :(";
                }
            } else {
                $status = "Error: La empresa no se ha registrado, porque el formulario no es valido :(";
            }
            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("fct_index_empresa");
        }
        return $this->render('FctBundle:Empresa:createEmpresa.html.twig', array(
                    "status" => $status,
                    "form" => $form->createView()
        ));
    }
}