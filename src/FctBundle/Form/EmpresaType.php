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
            ->add('cifEmp')
            ->add('nombreEmp')
            ->add('tutorEmp')
            ->add('direccionEmp')
            ->add('poblacionEmp')
            ->add('cpostalEmp')
            ->add('telfFijoEmp')
            ->add('telfMovilEmp')
            ->add('emailEmp')
            ->add('provinciaEmp')
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
