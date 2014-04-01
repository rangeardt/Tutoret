<?php

namespace Projet\ReseauBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrdinateurType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('salle', 'entity', array(
            'class' => 'ProjetReseauBundle:Salle',
            'property' => 'nom',
            'multiple' => false));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Projet\ReseauBundle\Entity\Ordinateur'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'projet_reseaubundle_ordinateur';
    }
}
