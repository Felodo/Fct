<?php

namespace FctBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class FctType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('anio')
            ->add('idProf', EntityType::class, array("class"=>"FctBundle:Profesor",
                "placeholder"=>"Selecciona un/a profesor/a...", 
                "choice_label"=>"nifProf",
                "choice_value"=>"idProf",
                "attr"=>["class"=>"form-id_profesor form-control"], "label"=>"Profesor:"))
            ->add('idEmp', EntityType::class, array("class"=>"FctBundle:Empresa",
                "placeholder"=>"Selecciona una empresa...", 
                "choice_label"=>"cifEmp",
                "choice_value"=>"idEmp",
                "attr"=>["class"=>"form-id_empresa form-control"], "label"=>"Empresa:"))
            ->add('idAlu', EntityType::class, array("class"=>"FctBundle:Alumno",
                "placeholder"=>"Selecciona un/a alumn@...", 
                "choice_label"=>"nifAlu",
                "choice_value"=>"idAlu",
                "attr"=>["class"=>"form-cod_alumno form-control"], "label"=>"Alumno:"))
            ->add('Guardar', SubmitType::class, array("attr"=>["class"=>"form-submit btn btn-success"]))
                
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FctBundle\Entity\Fct'
        ));
    }
}
