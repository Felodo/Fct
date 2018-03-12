<?php

namespace FctBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FctBundle\Entity\Profesor;
use FctBundle\Entity\Fct;
use FctBundle\Form\ProfesorType;
use FctBundle\Repository\ProfesorRepository;

class ProfesorController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction($page) {
        $em = $this->getDoctrine()->getManager();

        $profesor_repo = $em->getRepository("FctBundle:Profesor");
        $profesores = $profesor_repo->getPaginationProfesor(5, $page);//findAll();
		
		$totalitems = count($profesores);
        $pagesCount = ceil($totalitems / 5);
		
		
        $profesores1 = [];

        foreach ($profesores as $profesor) {
            $profesor1['id_prof'] = $profesor->getIdProf();
            $profesor1['nif_prof'] = $profesor->getNifProf();
            $profesor1['nombre_prof'] = $profesor->getNombreProf();
            $profesor1['apellido1_prof'] = $profesor->getApellido1Prof();
            $profesor1['apellido2_prof'] = $profesor->getApellido2Prof();
            $profesor1['nickname_prof'] = $profesor->getNicknameProf();
            $profesor1['telffijo_prof'] = $profesor->getTelfFijoProf();
            $profesor1['telfmovil_prof'] = $profesor->getTelfMovilProf();
            $profesor1['email_prof'] = $profesor->getEmailProf();
            $profesores1[] = $profesor1;
        }
        return $this->render('FctBundle:Profesor:index.html.twig', array(
                    "profesores" => $profesores1,
					"totalitems" => $totalitems,
                    "pagesCount" => $pagesCount,
                    "page" => $page
        ));
    }
    
    public function find_profesorAction(Request $request, $page) {
        $em = $this->getDoctrine()->getManager();
        //$alumno_a = new Alumno();
		$defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
                ->add('rol', ChoiceType::class, 
                        array("choices"=>['Direccion' => "ROLE_DIRECCION", 
                            "Profesor" => "ROLE_PROFESOR"], 
					"required" => "required",
                    "attr" => ["class" => "form-grado form-control"], 
					"label" => "Rol:"))
                ->add('operador_fijo', ChoiceType::class, 
                        array("choices"=>['Igual' => "igual", 
                            "Mayor" => "mayor", 
                            "Menor" => "menor",
							"Mayor Igual" => "mayorigual",
							"Menor Igual" => "menorigual",
							"Contiene" => "contiene"], 
					"required" => "required",
                    "attr" => ["class" => "form-grado form-control"], 
					"label" => ":"))
                ->add('telfFijoProf', TextType::class, array("required"=>false,
                    "attr"=>["class"=>"form-fijo form-control"],
                    "label" => "Telefono fijo:"))
                ->add('operador_movil', ChoiceType::class, 
                        array("choices"=>['Igual' => "igual", 
                            "Mayor" => "mayor", 
                            "Menor" => "menor",
							"Mayor Igual" => "mayorigual",
							"Menor Igual" => "menorigual",
							"Contiene" => "contiene"], 
					"required" => "required",
                    "attr" => ["class" => "form-grado form-control"], 
					"label" => ":"))
                ->add('telfMovilProf', TextType::class, array("required"=>false,
                    "attr"=>["class"=>"form-movil form-control"], 
                    "label" => "Telefono movil:"))
                ->add('operador_email', ChoiceType::class, 
                        array("choices"=>['Igual' => "igual", 
                            "Mayor" => "mayor", 
                            "Menor" => "menor",
							"Mayor Igual" => "mayorigual",
							"Menor Igual" => "menorigual",
							"Contiene" => "contiene"], 
					"required" => "required",
                    "attr" => ["class" => "form-grado form-control"], 
					"label" => ":"))
                ->add('emailProf', EmailType::class, array("required"=>false, 
                "attr"=>["class"=>"form-email form-control"],"label" => "Correo electronico:"))
                ->add('Buscar', SubmitType::class, array("attr"=>["class"=>"form-submit btn btn-success"]))
                ->getForm();
        $form->handleRequest($request);
        $filtros = [];
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            
            $rol = $form->get('rol')->getData();
            
            var_dump($rol);
            //die();
            $telfFijo = $form->get('telfFijoProf')->getData();
            if($telfFijo != null || $telfFijo != ""){
                $operador_fijo = $form->get('operador_fijo')->getData();
            }else {
                $operador_fijo = "";
            }
            $telfMovil = $form->get('telfMovilProf')->getData();
            if($telfMovil != null || $telfMovil != ""){
                $operador_movil = $form->get('operador_movil')->getData();
            }else {
                $operador_movil = "";
            }
            $email = $form->get('emailProf')->getData();
            if($email != null || $email != ""){
                $operador_email = $form->get('operador_email')->getData();
            }else {
                $operador_email = "";
            }
            
            if($rol != null && $rol !=""){
					$filtros["rol"] = "a.rolProf = '{$rol}'";
			}
            if($telfFijo != null && $telfFijo != ""){
				if($operador_fijo == "igual"){
					$filtros["telfFijo"] = "a.telfFijoProf = '{$telfFijo}'";
				}elseif ($operador_fijo == "mayor"){
					$filtros["telfFijo"] = "a.telfFijoProf >'{$telfFijo}'";
				}elseif ($operador_fijo == "menor"){
					$filtros["telfFijo"] = "a.telfFijoProf <'{$telfFijo}'";
				}elseif ($operador_fijo == "mayorigual"){
					$filtros["telfFijo"] = "a.telfFijoProf >='{$telfFijo}'";
				}elseif ($operador_fijo == "menorigual"){
					$filtros["telfFijo"] = "a.telfFijoProf <='{$telfFijo}'";
				}elseif ($operador_fijo == "contiene"){
					$filtros["telfFijo"] = "a.telfFijoProf LIKE '%{$telfFijo}%'";
                }
			}
            if($telfMovil != null && $telfMovil != ""){
				if($operador_movil == "igual"){
					$filtros["telfMovil"] = "a.telfMovilProf = '{$telfMovil}'";
				}elseif ($operador_movil == "mayor"){
					$filtros["telfMovil"] = "a.telfMovilProf >'{$telfMovil}'";
				}elseif ($operador_movil == "menor"){
					$filtros["telfMovil"] = "a.telfMovilProf <'{$telfMovil}'";
				}elseif ($operador_movil == "mayorigual"){
					$filtros["telfMovil"] = "a.telfMovilProf >='{$telfMovil}'";
				}elseif ($operador_movil == "menorigual"){
					$filtros["telfMovil"] = "a.telfMovilProf <='{$telfMovil}'";
				}elseif ($operador_movil == "contiene"){
					$filtros["telfMovil"] = "a.telfMovilProf LIKE '%{$telfMovil}%'";
                }
			}
            if($email != null && $email != ""){
				if($operador_email == "igual"){
					$filtros["email"] = "a.emailProf = '{$email}'";
				}elseif ($operador_email == "mayor"){
					$filtros["email"] = "a.emailProf >'{$email}'";
				}elseif ($operador_movil == "menor"){
					$filtros["email"] = "a.emailProf <'{$email}'";
				}elseif ($operador_movil == "mayorigual"){
					$filtros["email"] = "a.emailProf >='{$email}'";
				}elseif ($operador_movil == "menorigual"){
					$filtros["email"] = "a.emailProf <='{$email}'";
				}elseif ($operador_movil == "contiene"){
					$filtros["email"] = "a.emailProf LIKE '%{$email}%'";
                }
			}
            $profesor_repo = $em->getRepository("FctBundle:Profesor");
			$profesores = $profesor_repo->getBuscarProfesor($filtros, 5, $page);
            
        } else {
            $profesor_repo = $em->getRepository("FctBundle:Profesor");
			$profesores = $profesor_repo->getPaginationProfesor(5, $page); //findAll();
        }
        
        $totalitems = count($profesores);
        $pagesCount = ceil($totalitems / 5);
        
        $profesores1 = [];

        foreach ($profesores as $profesor) {
            $profesor1['id_prof'] = $profesor->getIdProf();
            $profesor1['nif_prof'] = $profesor->getNifProf();
            $profesor1['nombre_prof'] = $profesor->getNombreProf();
            $profesor1['apellido1_prof'] = $profesor->getApellido1Prof();
            $profesor1['apellido2_prof'] = $profesor->getApellido2Prof();
            $profesor1['nickname_prof'] = $profesor->getNicknameProf();
            $profesor1['telffijo_prof'] = $profesor->getTelfFijoProf();
            $profesor1['telfmovil_prof'] = $profesor->getTelfMovilProf();
            $profesor1['email_prof'] = $profesor->getEmailProf();
            $profesores1[] = $profesor1;
        }
        return $this->render('FctBundle:Profesor:findProfesor.html.twig', array(
                    "profesores" => $profesores1,
                    "totalitems" => $totalitems,
                    "pagesCount" => $pagesCount,
                    "page" => $page,
                    "form" => $form->createView()
        ));
    }

    public function loginAction(Request $request) {
        $authenticationUtils = $this->get("security.authentication_utils");
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($error){
            $status = "Error: No te has logueado correctamente!! :(";
        }else{
            $status = "Te has logueado correctamente!! :)";
		}

        return $this->render("FctBundle:Profesor:login.html.twig", [
                    "error" => $error,
                    "status" => $status,
                    "last_username" => $lastUsername
        ]);
    }
	
	public function seemore_profesorAction(Request $request, $id_prof){
		$em = $this->getDoctrine()->getManager();
        $profesor = $em->getRepository("FctBundle:Profesor")->find($id_prof);
		$profesor1 = [];
		
		$profesor1['id'] = $profesor->getIdProf();
		$profesor1['nif'] = $profesor->getNifProf();
        $profesor1['nickname'] = $profesor->getNicknameProf();
        $profesor1['nombre'] = $profesor->getNombreProf();
        $profesor1['apellido1'] = $profesor->getApellido1Prof();
        $profesor1['apellido2'] = $profesor->getApellido2Prof();
        $profesor1['email'] = $profesor->getEmailProf();
		$profesor1['fotografia'] = $profesor->getFotografiaProf();
		$profesor1['telfFijo'] = $profesor->getTelffijoProf();
		$profesor1['telfMovil'] = $profesor->getTelfMovilProf();
		
		return $this->render('FctBundle:Profesor:seemoreProfesor.html.twig', array(
                    "profesor" => $profesor1
        ));
		
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

                    $file = $form['fotografiaProf']->getData();

                    if (!empty($file) && $file != null) {
                        $ext = $file->guessExtension();
                        $file_name = time() . "." . $ext;
                        $file->move('../assets/imagen', $file_name);
                        $profesor->setFotografiaProf($file_name);
                    } else {
                        $profesor->setFotografiaProf(null);
                    }
                    //$profesor->setFotografiaProf(null);


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
                $status = "Error: El profesor no se registró correctamente, debido que que los datos no son válidos :(";
            }
            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute('sign_up');
        }



        return $this->render("FctBundle:Profesor:createProfesor.html.twig", [
                    //"error" => $error,
                    //"last_username" => $lastUsername,
                    "status" => $status,
                    "form" => $form->createView()
        ]);

        //$em = $this->getDoctrine()->getManager();
    }

    public function delete_profesorAction($id_prof) {
        $em = $this->getDoctrine()->getManager();
        $profesor_repo = $em->getRepository("FctBundle:Profesor");
        $profesor = $profesor_repo->find($id_prof);
        
        $fct_repo = $em->getRepository("FctBundle:Fct");
        $fct = $fct_repo->findBy(['idProf' => $id_prof]);

        if (count($fct) == 0) {
            $em->remove($profesor);
            $flush = $em->flush();

            if ($flush != NULL) {
                $status = "Error: El profesor no se pudo eliminar correctamente!! :(";
            } else {
                $status = "El profesor se ha eliminado correctamente!! :)";
            }


            //return $this->render('FctBundle:Ciclo:index.html.twig');
        } else {
            $status = "Error: El profesor no se pudo eliminar correctamente!! Está asociado a una fct :(";
        }
        $this->session->getFlashBag()->add("status", $status);
        return $this->redirectToRoute('fct_index_profesor');
    }

    public function edit_perfilAction(Request $request, $id_prof) {
        $em = $this->getDoctrine()->getManager();
        $profesor = $em->getRepository("FctBundle:Profesor")->find($id_prof);
		$rol = $profesor->getRolProf();


        $form = $this->createForm(ProfesorType::class, $profesor);



        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {
                //$profesor = new Profesor();
                $profesor->setNifProf($form->get('nifProf')->getData());
                $profesor->setNombreProf($form->get('nombreProf')->getData());
                $profesor->setApellido1Prof($form->get('apellido1Prof')->getData());
                $profesor->setApellido2Prof($form->get('apellido2Prof')->getData());

                $file = $form['fotografiaProf']->getData();

                if (!empty($file) && $file != null) {
                    $ext = $file->guessExtension();
                    $file_name = time() . "." . $ext;
                    $file->move('../assets/imagen', $file_name);
                    $profesor->setFotografiaProf($file_name);
                } else {
                    $profesor->setFotografiaProf(null);
                }
                //$profesor->setFotografiaProf(null);


                $profesor->setNicknameProf($form->get('nicknameProf')->getData());
                $profesor->setTelfFijoProf($form->get('telfFijoProf')->getData());
                $profesor->setTelfMovilProf($form->get('telfMovilProf')->getData());
                $profesor->setEmailProf($form->get('emailProf')->getData());

                $factory = $this->get("security.encoder_factory");
                $encoder = $factory->getEncoder($profesor);
                $password = $encoder->encodePassword($form->get('passwordProf')->getData(), $profesor->getSalt());

                $profesor->setPasswordProf($password);
				$profesor->setRolProf($rol);

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
                $status = "Error: El profesor no se editó correctamente!! :(";
            }
            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("fct_index_profesor");
        }
        
        return $this->render("FctBundle:Profesor:editPerfil.html.twig", [
                    "form" => $form->createView()
        ]);
    }
	
	public function edit_rolAction(Request $request, $id_prof){
		$em = $this->getDoctrine()->getManager();
        $profesor = $em->getRepository("FctBundle:Profesor")->find($id_prof);
		
		$defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
                ->add('rol', ChoiceType::class, 
                        array("choices"=>['Direccion' => "ROLE_DIRECCION", 
                            "Profesor" => "ROLE_PROFESOR"], 
					"required" => "required",
                    "attr" => ["class" => "form-grado form-control"], 
					"label" => "Rol:"))
				->add('Guardar cambios', SubmitType::class, array("attr"=>["class"=>"form-submit btn btn-success"]))
                ->getForm();
				
		$form->handleRequest($request);
		
		if ($form->isSubmitted()) {
			$profesor->setRolProf($form->get('rol')->getData());
			
			//y persistimos los datos almacenándolos dentro de doctrine
                $em->persist($profesor);
                //Volcamos los datos del ORM en la base de datos
                $flush = $em->flush();
				
			if ($flush != NULL) {
                    $status = "Error: No se realizó el cambio de rol correctamente!! :(";
                } else {
                    $status = "Se realizó el cambio de rol correctamente!! :)";
                }
				
			$this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("fct_index_profesor");
		}
		
		return $this->render("FctBundle:Profesor:editRol.html.twig", [
                    "form" => $form->createView()
        ]);
	}

}
