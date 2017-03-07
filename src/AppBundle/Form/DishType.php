<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Language;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class DishType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name')->add('isActive')->add('priority')->add('isDishWeek')->add('photo', FileType::class, array(
                    "label" => "Imagen:",
                    "attr" => array("class" => "form-control"),
                    "data_class" => null))
                ->add('category', EntityType::class, array(
                    'class' => 'AppBundle:Category',
                    'choice_label' => 'name'));

        $builder->add('languages', CollectionType::class, array(
            'entry_type' => DishLanguageType::class
        ));

        $builder->add('portions', CollectionType::class, array(
            'entry_type' => DishPortionType::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Dish'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_dish';
    }

}
