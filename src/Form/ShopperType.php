<?php

namespace App\Form;

use App\Entity\Shopper;
use App\Entity\Tienda;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShopperType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('tienda', EntityType::class, [
                'class' => Tienda::class,
                'choice_label' => function (Tienda $tienda) {
                    return $tienda->getNombre();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Shopper::class,
        ]);
    }
}
