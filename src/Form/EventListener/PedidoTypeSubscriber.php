<?php
/**
 * Created by PhpStorm.
 * User: Javier Ruiz
 * Date: 29/01/19
 * Time: 10:02
 */

declare(strict_types=1);

namespace App\Form\EventListener;

use App\Entity\Pedido;
use App\Entity\PedidoProducto;
use App\Repository\PedidoProductoRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Class PedidoTypeSubscriber
 */
class PedidoTypeSubscriber implements EventSubscriberInterface
{
    /** @var  PedidoProductoRepository $pedidoProductoRepository */
    private $pedidoProductoRepository;

    /**
     * PedidoTypeSubscriber constructor.
     *
     * @param PedidoProductoRepository $pedidoProductoRepository
     */
    public function __construct(PedidoProductoRepository $pedidoProductoRepository)
    {
        $this->pedidoProductoRepository = $pedidoProductoRepository;
    }


    public static function getSubscribedEvents()
    {
        return [
            FormEvents::POST_SUBMIT => 'postSubmit'
        ];
    }

    public function postSubmit(FormEvent $event)
    {
        /** @var Pedido $pedido */
        $pedido = $event->getData();
        $importe = 0;
        for($i=1;$i<=3;$i++) {
            if(null !== $event->getForm()->get("producto_$i")) {
                $producto = $event->getForm()->get("producto_$i")->getData();
                $cantidad = $event->getForm()->get("producto_cantidad_$i")->getData();
                $pedidoProducto = new pedidoProducto($producto, $pedido);
                $pedidoProducto->setUnidades($cantidad);
                $pedido->addPedidoProducto($pedidoProducto);
                $importe += $producto->getPrecio();
            }
        }

        $pedido->setImporte($importe);

        $event->stopPropagation();

        return;
    }
}