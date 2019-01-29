<?php

namespace App\Form;

use App\Entity\Pedido;
use App\Entity\Producto;
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
            ->add('pedidoProductos', EntityType::class, [
                'class' => Producto::class,
                'multiple' => true,
                'mapped' => false,
                'choice_label' => function (Producto $producto) {
                    return $producto->getNombre().' '.$producto->getPrecioEuros().' €';
                },
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
