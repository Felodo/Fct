<?php

namespace FctBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

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
            $empresa1['id_alu'] = $empresa->getIdAlu();
            $empresa1['nif'] = $empresa->getNifAlu();
            $empresa1['nickname'] = $empresa->getNicknameAlu();
            $empresa1['nombre'] = $empresa->getNombreAlu();
            $empresa1['apellido1'] = $empresa->getApellido1Alu();
            $empresa1['apellido2'] = $empresa->getApellido2Alu();
            $empresa1['email'] = $empresa->getEmailAlu();
            $empresa1['codigoCiclo'] = $empresa->getCodCiclo()->getCodigo();
            $empresas1[] = $empresa1;
        }



        return $this->render('FctBundle:Empresa:index.html.twig', array(
                    "empresas" => $empresas1,
        ));
        
        
        //return $this->render('FctBundle:Ciclo:index.html.twig');
    }
    
    public function create_empresaAction(){
        
    }
}
