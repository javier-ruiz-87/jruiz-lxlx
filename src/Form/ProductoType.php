<?php

namespace App\Form;

use App\Entity\Producto;
use App\Entity\Tienda;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('descripcion')
            ->add('unidades')
            ->add('precio')
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
            'data_class' => Producto::class,
        ]);
    }
}
