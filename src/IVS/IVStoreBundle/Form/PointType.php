<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16/01/17
 * Time: 13:57
 */

namespace IVS\IVStoreBundle\Form;

use IVS\IVStoreBundle\Entity\Point;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PointType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('x');
        $builder->add('y');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => Point::class,
        ]);
    }

}