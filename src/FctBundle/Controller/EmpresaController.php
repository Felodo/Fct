<?php

namespace FctBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use FctBundle\Form\EmpresaType;
use FctBundle\Entity\Empresa;

class EmpresaController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction($page) {
        $em = $this->getDoctrine()->getManager();

        $empresa_repo = $em->getRepository("FctBundle:Empresa");
        $empresas = $empresa_repo->getPaginationEmpresa(5, $page);//findAll();
		
		$totalitems = count($empresas);
        $pagesCount = ceil($totalitems / 5);
		
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
            $empresa1['telffijo'] = $empresa->getTelfFijoEmp();
            $empresa1['telfmovil'] = $empresa->getTelfMovilEmp();
            $empresa1['email'] = $empresa->getEmailEmp();
            $empresas1[] = $empresa1;
        }



        return $this->render('FctBundle:Empresa:index.html.twig', array(
                    "empresas" => $empresas1,
					"totalitems" => $totalitems,
                    "pagesCount" => $pagesCount,
                    "page" => $page
        ));


        //return $this->render('FctBundle:Ciclo:index.html.twig');
    }
	
	public function find_empresaAction(Request $request, $page){
		$em = $this->getDoctrine()->getManager();
        //$alumno_a = new Alumno();
		$defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
			->add('operador_direccion', ChoiceType::class, 
                        array("choices"=>['Igual' => "igual", 
                            "Mayor" => "mayor", 
                            "Menor" => "menor",
							"Mayor Igual" => "mayorigual",
							"Menor Igual" => "menorigual",
							"Contiene" => "contiene"], 
					"required" => "required",
                    "attr" => ["class" => "form-grado form-control"], 
					"label" => ":"))
			->add('direccion', TextType::class, array("required"=>false,
                "attr"=>["class"=>"form-address form-control"], "label" => "Direccion:"))
			->add('operador_cpostal', ChoiceType::class, 
                        array("choices"=>['Igual' => "igual", 
                            "Mayor" => "mayor", 
                            "Menor" => "menor",
							"Mayor Igual" => "mayorigual",
							"Menor Igual" => "menorigual",
							"Contiene" => "contiene"], 
					"required" => "required",
                    "attr" => ["class" => "form-grado form-control"], 
					"label" => ":"))
			->add('cpostal', TextType::class, array("required"=>false,
                "attr"=>["class"=>"form-cp form-control"], "label" => "Codigo Postal:"))
			->add('idProvincia', EntityType::class, array("class"=>"FctBundle:Provincia",
                "placeholder"=>"Selecciona una provincia...", 
                "choice_label"=>"nombre",
                "choice_value"=>"idProvincia",
                "attr"=>["class"=>"form-cod_provincia form-control"], "required"=>false, "label"=>"Provincia:"))
			->add('Buscar', SubmitType::class, array("attr"=>["class"=>"form-submit btn btn-success"]))
			->getForm();
		$form->handleRequest($request);
		
        
        $provincia_repo = $em->getRepository("FctBundle:Provincia");
        $provincias = $provincia_repo->findAll();
		
		if ($form->isSubmitted()) {
			$em = $this->getDoctrine()->getManager();
			
			$direccion = $form->get('direccion')->getData();
            //$operador_direccion = "";
            if($direccion != null || $direccion != ""){
                $operador_direccion = $form->get('operador_direccion')->getData();
            }else{
                $operador_direccion = "";
            }
            $cpostal = $form->get('cpostal')->getData();
            if($cpostal != null || $cpostal != ""){
                $operador_cpostal = $form->get('operador_cpostal')->getData();
            }else{
                $operador_cpostal = "";
            }
			if($form->get('idProvincia')->getData() != null)
                $provincia = $form->get('idProvincia')->getData()->getIdProvincia();
            else
                $provincia = "";
			
			
			if($direccion != null && $direccion != ""){
				if($operador_direccion == "igual"){
					$filtros["direccion"] = "a.direccionEmp = '{$direccion}'";
				}elseif ($operador_direccion == "mayor"){
					$filtros["direccion"] = "a.direccionEmp >'{$direccion}'";
				}elseif ($operador_direccion == "menor"){
					$filtros["direccion"] = "a.direccionEmp <'{$direccion}'";
				}elseif ($operador_direccion == "mayorigual"){
					$filtros["direccion"] = "a.direccionEmp >='{$direccion}'";
				}elseif ($operador_direccion == "menorigual"){
					$filtros["direccion"] = "a.direccionEmp <='{$direccion}'";
				}elseif ($operador_direccion == "contiene"){
					$filtros["direccion"] = "a.direccionEmp LIKE '%{$direccion}%'";
                }
			}
			if($cpostal != null && $cpostal !=""){
				if($operador_cpostal == "igual"){
					$filtros["cpostal"] = "a.cpostalEmp = {$cpostal}";
				}elseif ($operador_cpostal == "mayor"){
					$filtros["cpostal"] = "a.cpostalEmp > {$cpostal}";
				}elseif ($operador_cpostal == "menor"){
					$filtros["cpostal"] = "a.cpostalEmp < {$cpostal}";
				}elseif ($operador_cpostal == "mayorigual"){
					$filtros["cpostal"] = "a.cpostalEmp >= {$cpostal}";
				}elseif ($operador_cpostal == "menorigual"){
					$filtros["cpostal"] = "a.cpostalEmp <={$cpostal}";
				}elseif ($operador_cpostal == "contiene"){
					$filtros["cpostal"] = "a.cpostalEmp LIKE '%{$cpostal}%'";
				}
			}
			if($provincia != null && $provincia !=""){
					$filtros["id_provincia"] = "a.provinciaEmp = {$provincia}";
			}
			
			$empresa_repo = $em->getRepository("FctBundle:Empresa");
			$empresas = $empresa_repo->getBuscarEmpresa($filtros, 5, $page);
			
		}else{
			$empresa_repo = $em->getRepository("FctBundle:Empresa");
			$empresas = $empresa_repo->getPaginationEmpresa(5, $page); //findAll();
		}
		
		$totalitems = count($empresas);
        $pagesCount = ceil($totalitems / 5);



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
            $empresa1['telffijo'] = $empresa->getTelfFijoEmp();
            $empresa1['telfmovil'] = $empresa->getTelfMovilEmp();
            $empresa1['email'] = $empresa->getEmailEmp();
            $empresas1[] = $empresa1;
        }
		
		return $this->render('FctBundle:Empresa:findEmpresa.html.twig', array(
                    "empresas" => $empresas1,
                    "totalitems" => $totalitems,
                    "pagesCount" => $pagesCount,
                    "page" => $page,
                    "provincias" => $provincias,
                    "form" => $form->createView()
        ));
		
	}
	
	public function seemore_empresaAction(Request $request, $id_emp){
		$em = $this->getDoctrine()->getManager();
        $empresa = $em->getRepository("FctBundle:Empresa")->find($id_emp);
		$empresa1 = [];
		
		$empresa1['id_emp'] = $empresa->getIdEmp();
        $empresa1['cif'] = $empresa->getCifEmp();
        $empresa1['nombre'] = $empresa->getNombreEmp();
        $empresa1['tutor'] = $empresa->getTutorEmp();
        $empresa1['direccion'] = $empresa->getDireccionEmp();
        $empresa1['poblacion'] = $empresa->getPoblacionEmp();
        $empresa1['cpostal'] = $empresa->getCpostalEmp();
        $empresa1['provincia'] = $empresa->getProvinciaEmp()->getNombre();
        $empresa1['telffijo'] = $empresa->getTelfFijoEmp();
        $empresa1['telfmovil'] = $empresa->getTelfMovilEmp();
        $empresa1['email'] = $empresa->getEmailEmp();
        $empresas1[] = $empresa1;
		
		return $this->render('FctBundle:Empresa:seemoreEmpresa.html.twig', array(
                    "empresa" => $empresa1
        ));
		
	}

    public function create_empresaAction(Request $request) {
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

    public function delete_empresaAction($id_empresa) {
        $em = $this->getDoctrine()->getManager();
        $empresa_repo = $em->getRepository("FctBundle:Empresa");
        $empresa = $empresa_repo->find($id_empresa);

        $fct_repo = $em->getRepository("FctBundle:Fct");
        $fct = $fct_repo->findBy(['idEmp' => $id_empresa]);

        if (count($fct) == 0) {
            $em->remove($empresa);
            $flush = $em->flush();

            if ($flush != NULL) {
                $status = "Error: La empresa no se pudo eliminar correctamente!! :(";
            } else {
                $status = "El empresa se ha eliminado correctamente!! :)";
            }
            //return $this->render('FctBundle:Ciclo:index.html.twig');
        } else {
            $status = "Error: El empresa no se pudo eliminar, porque hay fct registrados :(";
        }
        $this->session->getFlashBag()->add("status", $status);
        return $this->redirectToRoute('fct_index_empresa');
    }

    public function edit_empresaAction(Request $request, $id_emp) {
        $em = $this->getDoctrine()->getManager();
        $empresa_repo = $em->getRepository("FctBundle:Empresa");
        $empresa = $empresa_repo->find($id_emp);

        $form = $this->createForm(EmpresaType::class, $empresa);
		
		$form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
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
                $status = "Error: El ciclo no se ha registrado, porque el formulario no es valido :(";
            }
            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("fct_index_empresa");
        }
        
        return $this->render('FctBundle:Empresa:editEmpresa.html.twig', array(
                    "form" => $form->createView()
        ));
    }

}
