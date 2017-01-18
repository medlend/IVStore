<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16/01/17
 * Time: 13:58
 */

namespace IVS\IVStoreBundle\Form;

use IVS\IVStoreBundle\Entity\Point;
use IVS\IVStoreBundle\Entity\Zone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZoneType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
            ->add('couleur')
            ->add('listePoints', CollectionType::class, [
                'entry_type' => PointType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => Zone::class,
            'cascade_validation' => true
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ivs_zone';
    }
}