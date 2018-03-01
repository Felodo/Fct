<?php

namespace FctBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpresaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cifEmp', TextType::class, array("required"=>"required", 
                "attr"=>["class"=>"form-nif form-control"], "label" => "CIF:"))
            ->add('nombreEmp',  TextType::class, array("required"=>"required", 
                "attr"=>["class"=>"form-name form-control"], "label" => "Nombre de la empresa:"))
            ->add('tutorEmp', TextType::class, array("required"=>"required", 
                "attr"=>["class"=>"form-tutor form-control"], "label" => "Nombre del tutor de la empresa:"))
            ->add('direccionEmp', TextType::class, array("required"=>"required", 
                "attr"=>["class"=>"form-direccion form-control"], "label" => "Direccion:"))
            ->add('poblacionEmp', TextType::class, array("required"=>"required", 
                "attr"=>["class"=>"form-nif form-control"], "label" => "Poblacion:"))
            ->add('cpostalEmp', TextType::class, array(
                "attr"=>["class"=>"form-cp form-control"], "label" => "Codigo Postal:"))
            ->add('telfFijoEmp', TextType::class, array(
                "attr"=>["class"=>"form-nif form-control"], "label" => "Nº de Telefono Fijo:"))
            ->add('telfMovilEmp', TextType::class, array(
                "attr"=>["class"=>"form-nif form-control"], "label" => "Nº de Telefono Movil:"))
            ->add('emailEmp', EmailType::class, array("required"=>"required", 
                "attr"=>["class"=>"form-email form-control"],"label" => "Correo electronico:"))
            ->add('provinciaEmp', EntityType::class, array("class"=>"FctBundle:Provincia",
                "placeholder"=>"Selecciona una provincia...", 
                "choice_label"=>"nombre",
                "choice_value"=>"idProvincia",
                "attr"=>["class"=>"form-cod_provincia form-control"], "label"=>"Provincia:"))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FctBundle\Entity\Empresa'
        ));
    }
}
