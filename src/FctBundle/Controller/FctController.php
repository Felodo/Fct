<?php

namespace FctBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use FctBundle\Form\FctType;
use FctBundle\Entity\Fct;
use FctBundle\Entity\Ciclo;

class FctController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction($page) {
        $em = $this->getDoctrine()->getManager();

        $fct_repo = $em->getRepository("FctBundle:Fct");
        $fcts = $fct_repo->getPaginationFct(5, $page);//findAll();
		
		$totalitems = count($fcts);
        $pagesCount = ceil($totalitems / 5);
		
        $fcts1 = [];

        foreach ($fcts as $fct) {
            $fct1['id_fct'] = $fct->getIdFct();
            $fct1['anio'] = $fct->getAnio();
            $fct1['nombreProf'] = $fct->getIdProf()->getNifProf() . " / ";
            $fct1['nombreProf'] .= $fct->getIdProf()->getNombreProf() . " ";
            $fct1['nombreProf'] .= $fct->getIdProf()->getApellido1Prof() . " ";
            $fct1['nombreProf'] .= $fct->getIdProf()->getApellido2Prof();
            $fct1['nombreEmp'] = $fct->getIdEmp()->getCifEmp() . " / ";
            $fct1['nombreEmp'] .= $fct->getIdEmp()->getNombreEmp();
            $fct1['nombreAlu'] = $fct->getIdAlu()->getNifAlu() . " / ";
            $fct1['nombreAlu'] .= $fct->getIdAlu()->getNombreAlu() . " ";
            $fct1['nombreAlu'] .= $fct->getIdAlu()->getApellido1Alu() . " ";
            $fct1['nombreAlu'] .= $fct->getIdAlu()->getApellido2Alu();
            $fcts1[] = $fct1;
        }
        return $this->render('FctBundle:Fct:index.html.twig', array(
                    "fcts" => $fcts1,
					"totalitems" => $totalitems,
                    "pagesCount" => $pagesCount,
					"page" => $page
        ));
        //return $this->render('FctBundle:Ciclo:index.html.twig');
    }
	
	public function find_fctAction(Request $request, $page){
		$em = $this->getDoctrine()->getManager();
		$defaultData = array('message' => 'Type your message here');
		$form = $this->createFormBuilder($defaultData)
			->add('operador_anio', ChoiceType::class, 
                        array("choices"=>['Igual' => "igual", 
                            "Mayor" => "mayor", 
                            "Menor" => "menor",
							"Mayor Igual" => "mayorigual",
							"Menor Igual" => "menorigual"], 
					"required" => "required",
                    "attr" => ["class" => "form-grado form-control"], 
					"label" => ":"))
			->add('anio', IntegerType::class, array("attr"=>["class"=>"form-id_profesor form-control"], "label"=>"Año:"))
			->add('idProf', EntityType::class, array("class"=>"FctBundle:Profesor",
                "placeholder"=>"Selecciona un/a profesor/a...", 
                "choice_label"=>"nifProf",
                "choice_value"=>"idProf",
                "attr"=>["class"=>"form-id_profesor form-control"], "label"=>"Profesor:", "required" => false))
            ->add('idEmp', EntityType::class, array("class"=>"FctBundle:Empresa",
                "placeholder"=>"Selecciona una empresa...", 
                "choice_label"=>"cifEmp",
                "choice_value"=>"idEmp",
                "attr"=>["class"=>"form-id_empresa form-control"], "label"=>"Empresa:", "required" => false))
            ->add('idAlu', EntityType::class, array("class"=>"FctBundle:Alumno",
                "placeholder"=>"Selecciona un/a alumn@...", 
                "choice_label"=>"nifAlu",
                "choice_value"=>"idAlu",
                "attr"=>["class"=>"form-cod_alumno form-control"], "label"=>"Alumno:", "required" => false))
            ->add('Guardar', SubmitType::class, array("attr"=>["class"=>"form-submit btn btn-success"]))
			->getForm();
		$form->handleRequest($request);
		
		$filtros = [];
		
		if ($form->isSubmitted()) {
			$em = $this->getDoctrine()->getManager();
			
			$anio = $form->get('anio')->getData();
			//var_dump($anio);
			//die();
			if($anio != null || $anio != ""){
                $operador_anio = $form->get('operador_anio')->getData();
            }else{
                $operador_anio = "";
            }
			if($form->get('idProf')->getData() != null)
                $profesor = $form->get('idProf')->getData()->getIdProf();
            else
                $profesor = "";
			if($form->get('idEmp')->getData() != null)
                $empresa = $form->get('idEmp')->getData()->getIdEmp();
            else
                $empresa = "";
			if($form->get('idAlu')->getData() != null)
                $alumno = $form->get('idAlu')->getData()->getIdAlu();
            else
                $alumno = "";
			
			if($anio != null && $anio != ""){
				if($operador_anio == "igual"){
					$filtros["anio"] = "a.anio = '{$anio}'";
				}elseif ($operador_anio == "mayor"){
					$filtros["anio"] = "a.anio >'{$anio}'";
				}elseif ($operador_anio == "menor"){
					$filtros["anio"] = "a.anio <'{$anio}'";
				}elseif ($operador_anio == "mayorigual"){
					$filtros["anio"] = "a.anio >='{$anio}'";
				}elseif ($operador_anio == "menorigual"){
					$filtros["anio"] = "a.anio <='{$anio}'";
				}elseif ($operador_anio == "contiene"){
					$filtros["anio"] = "a.anio LIKE '%{$anio}%'";
                }
			}
			if($profesor != null && $profesor !=""){
					$filtros["profesor"] = "a.idProf = {$profesor}";
			}
			if($empresa != null && $empresa !=""){
					$filtros["empresa"] = "a.idEmp = {$empresa}";
			}
			if($alumno != null && $alumno !=""){
					$filtros["alumno"] = "a.idAlu = {$alumno}";
			}
			$fct_repo = $em->getRepository("FctBundle:Fct");
			$fcts = $fct_repo->getBuscarFct($filtros, 5, $page);//findAll();
			
		}else{
			$fct_repo = $em->getRepository("FctBundle:Fct");
			$fcts = $fct_repo->getPaginationFct(5, $page);//findAll();
		}
		$totalitems = count($fcts);
        $pagesCount = ceil($totalitems / 5);



        $fcts1 = [];

        foreach ($fcts as $fct) {
            $fct1['id_fct'] = $fct->getIdFct();
            $fct1['anio'] = $fct->getAnio();
            $fct1['nombreProf'] = $fct->getIdProf()->getNifProf() . " / ";
            $fct1['nombreProf'] .= $fct->getIdProf()->getNombreProf() . " ";
            $fct1['nombreProf'] .= $fct->getIdProf()->getApellido1Prof() . " ";
            $fct1['nombreProf'] .= $fct->getIdProf()->getApellido2Prof();
            $fct1['nombreEmp'] = $fct->getIdEmp()->getCifEmp() . " / ";
            $fct1['nombreEmp'] .= $fct->getIdEmp()->getNombreEmp();
            $fct1['nombreAlu'] = $fct->getIdAlu()->getNifAlu() . " / ";
            $fct1['nombreAlu'] .= $fct->getIdAlu()->getNombreAlu() . " ";
            $fct1['nombreAlu'] .= $fct->getIdAlu()->getApellido1Alu() . " ";
            $fct1['nombreAlu'] .= $fct->getIdAlu()->getApellido2Alu();
            $fcts1[] = $fct1;
        }
        return $this->render('FctBundle:Fct:findFct.html.twig', array(
                    "fcts" => $fcts1,
					"totalitems" => $totalitems,
                    "pagesCount" => $pagesCount,
					"page" => $page,
					"form" => $form->createView()
        ));
		
	}
	
	public function seemore_fctAction(Request $request, $id_fct){
		$em = $this->getDoctrine()->getManager();
        $fct = $em->getRepository("FctBundle:Fct")->find($id_fct);
		$fct1 = [];
		$fct1["id_fct"] = $fct->getIdFct();
		$fct1['nifProf'] = $fct->getIdProf()->getNifProf();
        $fct1['nombreProf'] = $fct->getIdProf()->getNombreProf();
        $fct1['apellido1Prof'] = $fct->getIdProf()->getApellido1Prof();
        $fct1['apellido2Prof'] = $fct->getIdProf()->getApellido2Prof();
		$fct1['fotografiaProf'] = $fct->getIdProf()->getFotografiaProf();
        $fct1['nombreEmp'] = $fct->getIdEmp()->getCifEmp();
        $fct1['tutorEmp'] = $fct->getIdEmp()->getNombreEmp();
        $fct1['nifAlu'] = $fct->getIdAlu()->getNifAlu();
        $fct1['nombreAlu'] = $fct->getIdAlu()->getNombreAlu();
        $fct1['apellido1Alu'] = $fct->getIdAlu()->getApellido1Alu();
        $fct1['apellido2Alu'] = $fct->getIdAlu()->getApellido2Alu();
		$fct1['fotografiaAlu'] = $fct->getIdAlu()->getFotografiaAlu();
		$fct1['codigoCiclo'] = $fct->getIdAlu()->getCodCiclo()->getCodigo();
		$fct1['nombreCiclo'] = $fct->getIdAlu()->getCodCiclo()->getNombreCiclo();
		$fct1['horasCiclo'] = $fct->getIdAlu()->getCodCiclo()->getHorasfct();
		
		return $this->render('FctBundle:Fct:seemoreFct.html.twig', array(
                    "fct" => $fct1
        ));
		
	}

    public function create_fctAction(Request $request) {
        $fct = new Fct();
        $form = $this->createForm(FctType::class, $fct);

        $form->handleRequest($request);
        $status = "";

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                //$fct = $em->getRepository('FctBundle:Fct')->findOneBy(array("idFct" => $form->get('idFct')->getData()));

              //  if (count($fct) == 0) {
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
                        $status = "Error: La fct no se registró correctamente!! :(";
                    } else {
                        $status = "La fct se ha registrado correctamente!! :)";
                    }
                /*} else {
                    $status = "Error: La empresa ya existe!! :(";
                }*/
            } else {
                $status = "Error: La fct no se ha registrado, porque el formulario no es valido :(";
            }
            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("fct_index_fct");
        }
        return $this->render('FctBundle:Fct:createFct.html.twig', array(
                    "status" => $status,
                    "form" => $form->createView()
        ));
    }

    public function delete_fctAction($id_fct) {
        $em = $this->getDoctrine()->getManager();
        $fct_repo = $em->getRepository("FctBundle:Fct");
        $fct = $fct_repo->find($id_fct);


        $em->remove($fct);
        $flush = $em->flush();

        if ($flush != NULL) {
            $status = "Error: La fct no se pudo eliminar correctamente!! :(";
        } else {
            $status = "La fct se ha eliminado correctamente!! :)";
        }
        //return $this->render('FctBundle:Ciclo:index.html.twig');

        $this->session->getFlashBag()->add("status", $status);
        return $this->redirectToRoute('fct_index_fct');
    }

    public function edit_fctAction(Request $request, $id_fct) {
        $em = $this->getDoctrine()->getManager();
        $fct = $em->getRepository("FctBundle:Fct")->find($id_fct);

        $form = $this->createForm(FctType::class, $fct);
		
		$form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $fct->setAnio($form->get('anio')->getData());
                $fct->setIdProf($form->get('idProf')->getData());
                $fct->setIdAlu($form->get('idAlu')->getData());
                $fct->setIdEmp($form->get('idEmp')->getData());

                //y persistimos los datos almacenándolos dentro de doctrine
                $em->persist($fct);
                //Volcamos los datos del ORM en la base de datos
                $flush = $em->flush();

                if ($flush != NULL) {
                    $status = "Error: La fct no se registró correctamente!! :(";
                } else {
                    $status = "La fct se ha registrado correctamente!! :)";
                }
            } else {
                $status = "Error: El fct no se ha registrado, porque el formulario no es valido :(";
            }
            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("fct_index_fct");
        }

        return $this->render('FctBundle:Fct:editFct.html.twig', array(
                    "form" => $form->createView()
        ));
    }

}
