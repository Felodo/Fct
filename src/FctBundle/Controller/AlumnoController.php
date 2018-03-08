<?php

namespace FctBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FctBundle\Entity\Alumno;
use FctBundle\Entity\Provincia;
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
        $alumnos = $alumno_repo->getPaginationAlumno(5, $page); //findAll();

        $totalitems = count($alumnos);
        $pagesCount = ceil($totalitems / 5);



        $alumnos1 = [];
        //$ciclo_repo = $em->getRepository("FctBundle:Ciclo");
        //$ciclos = $ciclo_repo->findAll();

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

    public function find_alumnoAction(Request $request, $page) {
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
			->add('idCiclo', EntityType::class, array("class"=>"FctBundle:Ciclo",
                "placeholder"=>"Selecciona un ciclo...", 
                "choice_label"=>"nombreCiclo",
                "choice_value"=>"idCiclo",
                "attr"=>["class"=>"form-cod_ciclo form-control"],"required"=>false, "label"=>"Ciclo:"))
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
		
		$ciclo_repo = $em->getRepository("FctBundle:Ciclo");
		$ciclos = $ciclo_repo->findAll();
		$filtros = [];
		
		if ($form->isSubmitted()) {
			
			$em = $this->getDoctrine()->getManager();
			//$alumno = new Alumno();
			//var_dump($form);
			//die();
			//$alumno = $em->getRepository('FctBundle:Alumno')->findOneBy(array("idCiclo" => $form->get('idCiclo')->getData(), "provinciaAlu" => $form->get('idProvincia')->getData()));
			/*$data = array(
				"direccion" => $form->get('direccion')->getData(),
				"operador_direccion" => $form->get('operador_direccion')->getData(),
				"cpostal" => $form->get('cpostal')->getData(),
				"operador_cpostal" => $form->get('operador_cpostal')->getData(), 
				"ciclo" => $form->get('idCiclo')->getData(),
				"provincia" => $form->get('idProvincia')->getData()
			);*/
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
            if($form->get('idCiclo')->getData() != null)
                $ciclo = $form->get('idCiclo')->getData()->getIdCiclo();
            else
                $ciclo = "";
            
            if($form->get('idProvincia')->getData() != null)
                $provincia = $form->get('idProvincia')->getData()->getIdProvincia();
            else
                $provincia = "";
            
            var_dump($direccion);
            var_dump($operador_direccion);
            var_dump($cpostal);
            var_dump($operador_cpostal);
            var_dump($ciclo);
            var_dump($provincia);
            /*$operador_cpostal = $data['operador_cpostal'];
            if($data['ciclo'].getIdCiclo() != null)
                $ciclo = $data['ciclo'].getIdCiclo();
            else
                $ciclo = "";
			//var_dump($data);
			var_dump($operador_cpostal);
			var_dump($ciclo->idCiclo);*/
			//die();
		//if(isset($direccion) != null || isset($cpostal) != null || isset($ciclo) != null || isset($provincia) != null){
			if($direccion != null && $direccion != ""){
				if($operador_direccion == "igual"){
					$filtros["direccion"] = "a.direccionAlu = '{$direccion}'";
				}elseif ($operador_direccion == "mayor"){
					$filtros["direccion"] = "a.direccionAlu >'{$direccion}'";
				}elseif ($operador_direccion == "menor"){
					$filtros["direccion"] = "a.direccionAlu <'{$direccion}'";
				}elseif ($operador_direccion == "mayorigual"){
					$filtros["direccion"] = "a.direccionAlu >='{$direccion}'";
				}elseif ($operador_direccion == "menorigual"){
					$filtros["direccion"] = "a.direccionAlu <='{$direccion}'";
				}elseif ($operador_direccion == "contiene"){
					$filtros["direccion"] = "a.direccionAlu LIKE '%{$direccion}%'";
                }
			}
			if($cpostal != null && $cpostal !=""){
				if($operador_cpostal == "igual"){
					$filtros["cpostal"] = "a.cpostalAlu = {$cpostal}";
				}elseif ($operador_cpostal == "mayor"){
					$filtros["cpostal"] = "a.cpostalAlu > {$cpostal}";
				}elseif ($operador_cpostal == "menor"){
					$filtros["cpostal"] = "a.cpostalAlu < {$cpostal}";
				}elseif ($operador_cpostal == "mayorigual"){
					$filtros["cpostal"] = "a.cpostalAlu >= {$cpostal}";
				}elseif ($operador_cpostal == "menorigual"){
					$filtros["cpostal"] = "a.cpostalAlu <={$cpostal}";
				}elseif ($operador_cpostal == "contiene"){
					$filtros["cpostal"] = "a.cpostalAlu LIKE '%{$cpostal}%'";
				}
			}
			if($provincia != null && $provincia !=""){
					$filtros["id_provincia"] = "a.provinciaAlu = {$provincia}";
			}
			if($ciclo != null && $ciclo !=""){
					$filtros["id_ciclo"] = "a.codCiclo = {$ciclo}";
			}
			$alumno_repo = $em->getRepository("FctBundle:Alumno");
			$alumnos = $alumno_repo->getBuscarAlumno($filtros, 5, $page);
		}
		else{
			$alumno_repo = $em->getRepository("FctBundle:Alumno");
			$alumnos = $alumno_repo->getPaginationAlumno(5, $page); //findAll();
		}

        $totalitems = count($alumnos);
        $pagesCount = ceil($totalitems / 5);



        $alumnos1 = [];
        //$ciclo_repo = $em->getRepository("FctBundle:Ciclo");
        //$ciclos = $ciclo_repo->findAll();

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



        return $this->render('FctBundle:Alumno:findAlumno.html.twig', array(
                    "alumnos" => $alumnos1,
                    "totalitems" => $totalitems,
                    "pagesCount" => $pagesCount,
                    "page" => $page,
                    "provincias" => $provincias,
					"ciclos" => $ciclos,
                    "form" => $form->createView()
        ));
    }
	
	public function seemore_alumnoAction(Request $request, $id_alu){
		$em = $this->getDoctrine()->getManager();
        $alumno = $em->getRepository("FctBundle:Alumno")->find($id_alu);
		$alumno1 = [];
		
		$alumno1['id'] = $alumno->getIdAlu();
		$alumno1['nif'] = $alumno->getNifAlu();
        $alumno1['nickname'] = $alumno->getNicknameAlu();
        $alumno1['nombre'] = $alumno->getNombreAlu();
        $alumno1['apellido1'] = $alumno->getApellido1Alu();
        $alumno1['apellido2'] = $alumno->getApellido2Alu();
        $alumno1['email'] = $alumno->getEmailAlu();
		$alumno1['fotografia'] = $alumno->getFotografiaAlu();
		$alumno1['direccion'] = $alumno->getDireccionAlu();
		$alumno1['poblacion'] = $alumno->getPoblacionAlu();
		$alumno1['provincia'] = $alumno->getProvinciaAlu()->getNombre();
		$alumno1['cpostal'] = $alumno->getCpostalAlu();
        $alumno1['codigoCiclo'] = $alumno->getCodCiclo()->getCodigo();
		$alumno1['nombreCiclo'] = $alumno->getCodCiclo()->getNombreCiclo();
		$alumno1['telfFijo'] = $alumno->getTelffijoAlu();
		$alumno1['telfMovil'] = $alumno->getTelfMovilAlu();
		
		return $this->render('FctBundle:Alumno:seemoreAlumno.html.twig', array(
                    "alumno" => $alumno1
        ));
		
	}
	
	public function show_alumnoAction($page){
		$em = $this->getDoctrine()->getManager();

        $alumno_repo = $em->getRepository("FctBundle:Alumno");
        $alumnos = $alumno_repo->getBuscarAlumno($filtros, 5, $page); //findAll();

        $totalitems = count($alumnos);
        $pagesCount = ceil($totalitems / 5);



        $alumnos1 = [];
        //$ciclo_repo = $em->getRepository("FctBundle:Ciclo");
        //$ciclos = $ciclo_repo->findAll();

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
