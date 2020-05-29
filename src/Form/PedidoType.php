<?php

namespace App\Form;

use App\Entity\Pedido;
use App\Entity\Producto;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PedidoType extends AbstractType
{
    /** @var EventSubscriberInterface */
    private $subscriber;

    /**
     * PedidoType constructor.
     * @param EventSubscriberInterface $subscriber
     */
    public function __construct(EventSubscriberInterface $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clienteNombre')
            ->add('clienteEmail')
            ->add('clienteTelefono')
            ->add('clienteDireccion')
            ->add('fechaEntrega')
            ->add('franjaHoraria')
            ->add('producto_1', EntityType::class, [
                'class' => Producto::class,
                'mapped' => false,
                'choice_label' => function (Producto $producto) {
                    return $producto->getNombre().' '.$producto->getPrecioEuros().' €';
                },
            ])
            ->add('producto_cantidad_1', IntegerType::class, [
                'mapped' => false
            ])
            ->add('producto_2', EntityType::class, [
                'class' => Producto::class,
                'mapped' => false,
                'choice_label' => function (Producto $producto) {
                    return $producto->getNombre().' '.$producto->getPrecioEuros().' €';
                },
            ])
            ->add('producto_cantidad_2', IntegerType::class, [
                'mapped' => false
            ])
            ->add('producto_3', EntityType::class, [
                'class' => Producto::class,
                'mapped' => false,
                'choice_label' => function (Producto $producto) {
                    return $producto->getNombre().' '.$producto->getPrecioEuros().' €';
                },
            ])
            ->add('producto_cantidad_3', IntegerType::class, [
                'mapped' => false
            ])
        ;

        $builder->addEventSubscriber($this->subscriber);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pedido::class,
        ]);
    }
}
