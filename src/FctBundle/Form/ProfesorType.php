<?php

namespace FctBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

class ProfesorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('nifProf', TextType::class, array("required"=>"required", 
                "attr"=>["class"=>"form-nif form-control"], "label" => "NIF:"))
            ->add('nombreProf', TextType::class, array("required"=>false,
                "attr"=>["class"=>"form-name form-control"], "label" => "Nombre:"))
            ->add('apellido1Prof', TextType::class, array("required"=>false,
                "attr"=>["class"=>"form-surname form-control"], "label" => "Primer apellido:"))
            ->add('apellido2Prof', TextType::class, array("required"=>false,
                "attr"=>["class"=>"form-surname form-control"],"label" => "Segundo apellido:"))
            /*->add('fotografiaProf', TextType::class, array("attr"=>["class"=>"form-photo form-control"], 
                "label" => "Fotografia:"))*/
            ->add('fotografiaProf', FileType::class,  array(
                "required"=>false, 
                "attr"=>["class"=>"form-surname1 form-control"], 
                "label" => "Imagen:"))
            ->add('nicknameProf', TextType::class, array("required"=>"required", 
                "attr"=>["class"=>"form-nickname form-control"], "label" => "Nickname:"))
			->add("passwordProf", RepeatedType::class, array(
				"type" => PasswordType::class,
				'invalid_message' => 'The password fields must match.',
				'options' => array('attr' => array("class"=>"form-password form-control")),
				'required' => true,
				'first_options'  => array('label' => 'Contraseña:'),
				'second_options' => array('label' => 'Confirma contraseña:')))
            ->add('telfFijoProf', TextType::class, array("required"=>false, "attr"=>["class"=>"form-fijo form-control"],
                "label" => "Telefono fijo:"))
            ->add('telfMovilProf', TextType::class, array("required"=>false,"attr"=>["class"=>"form-movil form-control"], 
                "label" => "Telefono movil:"))
            ->add('emailProf', EmailType::class, array("required"=>true, 
                "attr"=>["class"=>"form-email form-control"],"label" => "Correo electronico:"))
            //->add('passwordProf', PasswordType::class, array("required"=>"required", 
            //    "attr"=>["class"=>"form-password form-control"], "label" => "Contraseña:"))
            ->add('Guardar', SubmitType::class, array("attr"=>["class"=>"form-submit btn btn-success"]))
            ->add('Cancelar', ResetType::class, array("attr"=>["class"=>"form-reset btn btn-alert"]))
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
