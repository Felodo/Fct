<?php

namespace FctBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;


class AlumnoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nifAlu', TextType::class, array("required"=>"required", 
                "attr"=>["class"=>"form-nif form-control"], "label" => "NIF:"))
            ->add('nombreAlu', TextType::class, array( 
                "attr"=>["class"=>"form-name form-control"], "label" => "Nombre:"))
            ->add('apellido1Alu', TextType::class, array( 
                "attr"=>["class"=>"form-surname1 form-control"], "label" => "Primer apellido:"))
            ->add('apellido2Alu', TextType::class, array(
                "attr"=>["class"=>"form-surname2 form-control"], "label" => "Segundo apellido:"))
            //->add('fotografiaAlu')
            ->add('nicknameAlu', TextType::class, array("required"=>"required", 
                "attr"=>["class"=>"form-nickname form-control"], "label" => "Nickname:"))
            ->add('direccionAlu', TextType::class, array( 
                "attr"=>["class"=>"form-address form-control"], "label" => "Direccion:"))
            ->add('poblacionAlu', TextType::class, array( 
                "attr"=>["class"=>"form-poblation form-control"], "label" => "Poblacion:"))
            ->add('cpostalAlu', TextType::class, array(
                "attr"=>["class"=>"form-cp form-control"], "label" => "Codigo Postal:"))
            ->add('telfFijoAlu', TextType::class, array(
                "attr"=>["class"=>"form-nif form-control"], "label" => "Nº de Telefono Fijo:"))
            ->add('telfMovilAlu', TextType::class, array(
                "attr"=>["class"=>"form-nif form-control"], "label" => "Nº de Telefono Movil:"))
            ->add('emailAlu', EmailType::class, array("required"=>"required", 
                "attr"=>["class"=>"form-email form-control"],"label" => "Correo electronico:"))
            ->add('codCiclo', EntityType::class, array("class"=>"FctBundle:Ciclo",
                "placeholder"=>"Selecciona un ciclo...", 
                "choice_label"=>"nombreCiclo",
                "choice_value"=>"idCiclo",
                "attr"=>["class"=>"form-cod_ciclo form-control"], "label"=>"Ciclo:"))
            ->add('provinciaAlu', EntityType::class, array("class"=>"FctBundle:Provincia",
                "placeholder"=>"Selecciona una provincia...", 
                "choice_label"=>"nombre",
                "choice_value"=>"idProvincia",
                "attr"=>["class"=>"form-cod_provincia form-control"], "label"=>"Provincia:"))
            ->add('Guardar', SubmitType::class, array("attr"=>["class"=>"form-submit btn btn-success"]))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FctBundle\Entity\Alumno'
        ));
    }
}
