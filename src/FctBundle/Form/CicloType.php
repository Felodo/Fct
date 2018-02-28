<?php

namespace FctBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CicloType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder
                ->add('codigo', TextType::class, array("required" => "required",
                    "attr" => ["class" => "form-codigo form-control"], "label" => "Siglas:"))
                ->add('nombreCiclo', TextType::class, array("required" => "required",
                    "attr" => ["class" => "form-name form-control"], "label" => "Nombre del ciclo:"))
                ->add('grado', ChoiceType::class, array("choices"=>['Grado Básico' => "Grado Básico", "Grado Medio" => "Grado Medio", "Grado Superior" => "Grado Superior"], "required" => "required",
                    "attr" => ["class" => "form-grado form-control"], "label" => "Grado:"))
                ->add('horasfct', TextType::class, array("required" => "required",
                    "attr" => ["class" => "form-horas form-control"], "label" => "Horas:"))
                ->add('Guardar', SubmitType::class, array("attr" => ["class" => "form-submit btn btn-success"]))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'FctBundle\Entity\Ciclo'
        ));
    }

}
