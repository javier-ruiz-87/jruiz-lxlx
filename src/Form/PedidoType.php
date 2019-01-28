<?php

namespace App\Form;

use App\Entity\Pedido;
use App\Entity\Producto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PedidoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clienteNombre')
            ->add('clienteEmail')
            ->add('clienteTelefono')
            ->add('clienteDireccion')
//            ->add('importe')
            ->add('fechaEntrega')
            ->add('franjaHoraria')
            ->add('pedidoProductos', EntityType::class, [
                'class' => Producto::class,
                'multiple' => true,
                'choice_label' => function (Producto $producto) {
                    return $producto->getNombre().' '.$producto->getPrecioEuros().' €';
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pedido::class,
        ]);
    }
}
