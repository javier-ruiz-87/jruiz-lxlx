<?php
/**
 * Created by PhpStorm.
 * User: Javier Ruiz
 * Date: 29/01/19
 * Time: 15:05
 */
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Pedido;
use App\Entity\PedidoProducto;
use App\Entity\Producto;
use App\Repository\ProductoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class APIPedidoController
 * @Route("/api/pedido")
 */
class APIPedidoController extends AbstractController
{
    /**
     * API para añadir un pedido
     * Parametros por POST:
     * cliente_nombre, cliente_apellidos, cliente_direccion, cliente_telefono, cliente_email,
     * producto y producto_cantidad pueden ir con formato productoID:cantidad,
     * fecha_entrega, franja_horaria
     *
     * @Route("/add", name="pedido_api_add", methods={"POST"})
     *
     * @param Request            $request
     * @param ProductoRepository $productoRepository
     *
     * @return Response
     */
    public function add(Request $request, ProductoRepository $productoRepository)
    {
        try {
            $persistPedido = $this->createNewObject($request, $productoRepository);
            $results[] = [
                'mensaje' => 'Exito al guardar',
                'codigo' => '1',
                'pedido_id' => $persistPedido->getId(),
                'importe' => $persistPedido->getImporte().' centimos de euro'
            ];
        }
        catch (\Throwable $e) {
            $results[] = [
                'mensaje' => 'Hay algun error',
                'error_mensaje' => $e->getMessage(),
                'code'    => $e->getCode(),
                'codigo'  => '0'
            ];
        }

        return $this->json($results);
    }

    /**
     * Crea nuevo objeto y lo persiste
     *
     * @param Request            $request
     * @param ProductoRepository $productoRepository
     *
     * @return Pedido
     */
    protected function createNewObject(Request $request, ProductoRepository $productoRepository)
    {
        $pedido = new Pedido();
        $pedido->setClienteNombre($request->get('cliente_nombre'));
        $pedido->setClienteDireccion($request->get('cliente_direccion'));
        $pedido->setClienteEmail($request->get('cliente_email'));
        $pedido->setClienteTelefono((int)$request->get('cliente_telefono'));

        $pedido->setFechaEntrega(new \DateTime($request->get('fecha_entrega')));
        $pedido->setFranjaHoraria($request->get('franja_horaria'));

        $manageProductos = $this->manageProducts($request, $pedido, $productoRepository);

        $pedido->setImporte($manageProductos['importe']);

        foreach ($manageProductos['pedidoProductos'] as $pedidoProducto) {
            $pedido->addPedidoProducto($pedidoProducto);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($pedido);
        $em->flush();

        return $pedido;
    }

    /**
     * @param Request            $request
     * @param Pedido             $pedido
     * @param ProductoRepository $productoRepository
     *
     * @return array
     */
    public function manageProducts(Request $request, Pedido $pedido, ProductoRepository $productoRepository)
    {
        $pedidoProductoPedido = array();
        $importe = 0;
        //TODO mejorar esto. Limitar a minimo 5 productos maximo 20. Excepciones
        for($i=1;$i<=20;$i++) {
            if(null != $request->get("producto_$i")) {
                $productosYCantidadArray = explode(':',$request->get("producto_$i"));
                $productoCantidad = $productosYCantidadArray[1];
                /** @var Producto $producto */
                $producto = $productoRepository->findOneBy(array('id'=>$productosYCantidadArray[0]));
                $importe += ((int)$producto->getPrecio())*((int)$productoCantidad);

                $pedidoProducto = new PedidoProducto($producto, $pedido);
                $pedidoProducto->setUnidades((int)$productoCantidad);
                $pedidoProductoPedido[] = $pedidoProducto;

            }
        }

//        dump($pedidoProductoPedido);
//        dump($importe);

        return [
          'importe' => $importe,
          'pedidoProductos' => $pedidoProductoPedido
        ];
    }

    public function calcularImporte()
    {

    }
}