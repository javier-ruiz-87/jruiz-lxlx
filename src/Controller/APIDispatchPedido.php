<?php
/**
 * Created by PhpStorm.
 * User: Javier Ruiz
 * Date: 2/02/19
 * Time: 14:15
 */

namespace App\Controller;

use App\Entity\PedidoProducto;
use App\Entity\Producto;
use App\Entity\Tienda;
use App\Exceptions\NoAPIParametrosException;
use App\Exceptions\NoHayPedidosException;
use App\Exceptions\ValorIncorrectoException;
use App\Repository\PedidoRepository;
use App\Repository\ShopperRepository;
use App\Repository\TiendaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class APIDispatchPedido
 * @Route("/api/dispatch")
 */
class APIDispatchPedido extends AbstractController
{
    /**
     * Api para consultar el pedido para un shopper y tienda en concreto.
     * Parametros de peticion: tienda_id y shopper_id
     * Devuelve:  pedido y productos que ha de comprar (pueden ser de varios pedidos)
     *
     * @Route("/", name="api_dipatch_pedidos", methods={"GET"})
     *
     * @param Request           $request
     * @param ShopperRepository $shopperRepository
     * @param PedidoRepository  $pedidoRepository
     * @param TiendaRepository  $tiendaRepository
     *
     * @return JsonResponse
     */
    public function dispatchPedidos(Request $request, ShopperRepository $shopperRepository, PedidoRepository $pedidoRepository, TiendaRepository $tiendaRepository)
    {
        try {
            if ($request->query->count() < 2) {
                throw new NoAPIParametrosException('Espero: tienda_id y shopper_id');
            }
            if (null == $tienda = $tiendaRepository->find($request->get('tienda_id'))) {
                throw new ValorIncorrectoException('tienda_id');
            }
            if (null == $shopper = $shopperRepository->find($request->get('shopper_id'))) {
                throw new ValorIncorrectoException('shopper_id');
            }

            $productosTienda = $this->getProductosTienda($pedidoRepository->findAll(), $tienda);

            $results[] = [
                'mensaje' => 'Datos de pedido: ',
                'items' => $productosTienda,
                'tienda' => $tienda->getNombre(),
                'tienda_direccion' => $tienda->getDireccion(),
                'shopper' => $shopper->getNombre(),
                'code' => '1',
            ];
        }
        catch (\Throwable $e) {
            $results[] = [
                'mensaje' => 'Hay algun error',
                'error_mensaje' => $e->getMessage(),
                'code'    => $e->getCode(),
            ];
        }

        return $this->json($results);
    }

    /**
     * @param array $pedidos
     * @param Tienda $tienda
     *
     * @return array
     *
     * @throws NoHayPedidosException
     */
    private function getProductosTienda(array $pedidos, Tienda $tienda)
    {
        $productosTienda = array();

        foreach($pedidos as $pedido) {
            $pedidoProductos = $pedido->getPedidoProductos();
            foreach($pedidoProductos as $pedidoProducto) {
                /** @var PedidoProducto $pedidoProducto */
                /** @var Producto $producto */
                $producto = $pedidoProducto->getProducto();
                if($producto->getTienda()->getId() == $tienda->getId()) {
                    $productosTienda[] = [
                        'Pedido_id: '.$pedido->getId() =>
                            'Producto_id: '.$producto->getId().
                            ', Nombre: '.$producto->getNombre().
                            ', Cantidad: '.$pedidoProducto->getUnidades().
                            ', Precio: '.$producto->getPrecioEuros().' €'
                    ];
                }
            }
        }

        if (empty($productosTienda)) {
            throw new NoHayPedidosException("No hay productos para la tienda indicada aun");
        }

        return $productosTienda;
    }
}