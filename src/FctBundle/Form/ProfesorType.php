<?php

namespace FctBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProfesorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreProf', TextType::class, array("required"=>"required", 
                "attr"=>["class"=>"form-name form-control"]))
            ->add('apellido1Prof', TextType::class, array("required"=>"required", 
                "attr"=>["class"=>"form-surname form-control"]))
            ->add('apellido2Prof', TextType::class, array("required"=>"required", 
                "attr"=>["class"=>"form-surname form-control"]))
            ->add('fotografiaProf', TextType::class)
            ->add('nicknameProf', TextType::class, array("required"=>"required", 
                "attr"=>["class"=>"form-nickname form-control"]))
            ->add('telfFijoProf')
            ->add('telfMovilProf')
            ->add('emailProf', EmailType::class, array("required"=>"required", 
                "attr"=>["class"=>"form-email form-control"]))
            ->add('passwordProf', PasswordType::class, array("required"=>"required", 
                "attr"=>["class"=>"form-password form-control"]))
            ->add('Guardar', SubmitType::class)
            //->add('rolProf')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FctBundle\Entity\Profesor'
        ));
    }
}
