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
            ->add('nifAlu')
            ->add('nombreAlu')
            ->add('apellido1Alu')
            ->add('apellido2Alu')
            ->add('fotografiaAlu')
            ->add('nicknameAlu')
            ->add('direccionAlu')
            ->add('poblacionAlu')
            ->add('cpostalAlu')
            ->add('telfFijoAlu')
            ->add('telfMovilAlu')
            ->add('emailAlu', EmailType::class, array("required"=>"required", 
                "attr"=>["class"=>"form-email form-control"],"label" => "Correo electronico:"))
            ->add('codCiclo', EntityType::class, array("class"=>"FctBundle::Ciclo",
                "placeholder"=>"Selecciona un ciclo...", 
                "choice_label"=>"nombreCiclo",
                "choice_value"=>"idCiclo"))
            ->add('provinciaAlu', EntityType::class, array("class"=>"FctBundle::Provincia",
                "placeholder"=>"Selecciona una provincia...", 
                "choice_label"=>"nombre",
                "choice_value"=>"idProvincia"))
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
