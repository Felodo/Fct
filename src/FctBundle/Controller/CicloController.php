<?php

namespace FctBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FctBundle\Form\CicloType;
use FctBundle\Entity\Ciclo;
use FctBundle\Form\AlumnoType;

class CicloController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction($page) {
        $em = $this->getDoctrine()->getManager();

        $ciclo_repo = $em->getRepository("FctBundle:Ciclo");
        $ciclos = $ciclo_repo->getPaginationCiclo(5, $page);//findAll();
		
		$totalitems = count($ciclos);
        $pagesCount = ceil($totalitems / 5);
		
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
					"page" => $page,
					"pagesCount" => $pagesCount
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
                    $ciclo = new Ciclo();
                    $ciclo->setCodigo($form->get('codigo')->getData());
                    $ciclo->setNombreCiclo($form->get('nombreCiclo')->getData());
                    $ciclo->setGrado($form->get('grado')->getData());
                    $ciclo->setHorasfct($form->get('horasfct')->getData());

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
	
	public function find_cicloAction(Request $request, $page) {
		$em = $this->getDoctrine()->getManager();
        //$alumno_a = new Alumno();
		$defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
			->add('grado', ChoiceType::class, 
                        array("choices"=>['Grado Basico' => "basico", 
                            "Grado Medio" => "medio", 
                            "Grado Superior" => "superior"], 
					"required" => false,
                    "attr" => ["class" => "form-grado form-control"], 
					"label" => ":"))
			->add('operador_horasfct', ChoiceType::class, 
                        array("choices"=>['Igual' => "igual", 
                            "Mayor" => "mayor", 
                            "Menor" => "menor",
							"Mayor Igual" => "mayorigual",
							"Menor Igual" => "menorigual",
							"Contiene" => "contiene"], 
					"required" => "required",
                    "attr" => ["class" => "form-grado form-control"], 
					"label" => ":"))
			->add('horasfct', TextType::class, array("required" => "required",
                    "attr" => ["class" => "form-horas form-control"], "label" => "Horas:"))
			->add('Buscar', SubmitType::class, array("attr"=>["class"=>"form-submit btn btn-success"]))
			->getForm();
		
		$form->handleRequest($request);
		
		$filtros = [];
		
		if ($form->isSubmitted()) {
			$em = $this->getDoctrine()->getManager();
			
			if($form->get('grado')->getData() != null)
                $grado = $form->get('grado')->getData()->getIdCiclo();
            else
                $grado = "";
			
			$horasfct = $form->get('horasfct')->getData();
            if($horasfct != null || $horasfct != ""){
                $operador_horasfct = $form->get('operador_horasfct')->getData();
            }else{
                $operador_horasfct = "";
            }
			
			if($grado != null && $grado !=""){
					$filtros["grado"] = "a.grado = {$grado}";
			}
			
			if($horasfct != null && $horasfct != ""){
				if($operador_horasfct == "igual"){
					$filtros["horasfct"] = "a.horasfct = '{$horasfct}'";
				}elseif ($operador_horasfct == "mayor"){
					$filtros["horasfct"] = "a.horasfct >'{$horasfct}'";
				}elseif ($operador_horasfct == "menor"){
					$filtros["horasfct"] = "a.horasfct <'{$horasfct}'";
				}elseif ($operador_horasfct == "mayorigual"){
					$filtros["horasfct"] = "a.horasfct >='{$horasfct}'";
				}elseif ($operador_horasfct == "menorigual"){
					$filtros["horasfct"] = "a.horasfct <='{$horasfct}'";
				}elseif ($operador_horasfct == "contiene"){
					$filtros["horasfct"] = "a.horasfct LIKE '%{$horasfct}%'";
                }
			}
			
			$ciclo_repo = $em->getRepository("FctBundle:Ciclo");
			$ciclos = $ciclo_repo->getBuscarCiclo($filtros, 5, $page);
			
			
		}else{
			
			$ciclo_repo = $em->getRepository("FctBundle:Ciclo");
			$ciclos = $ciclo_repo->getPaginationCiclo(5, $page); 
		}
		
		$totalitems = count($ciclos);
        $pagesCount = ceil($totalitems / 5);
		
		$ciclos1 = [];
		
		foreach ($ciclos as $ciclo) {
            $ciclo1['id_ciclo'] = $ciclo->getIdCiclo();
            $ciclo1['codigo'] = $ciclo->getCodigo();
            $ciclo1['nombreCiclo'] = $ciclo->getNombreCiclo();
            $ciclo1['grado'] = $ciclo->getGrado();
            $ciclo1['horas'] = $ciclo->getHorasfct();
            $ciclos1[] = $ciclo1;
        }
		
		return $this->render('FctBundle:Ciclo:findCiclo.html.twig', array(
                    "ciclos" => $ciclos1,
                    "totalitems" => $totalitems,
                    "pagesCount" => $pagesCount,
                    "page" => $page,
                    "form" => $form->createView()
        ));
		
		
	}

}
