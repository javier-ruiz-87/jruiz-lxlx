<?php
/**
 * Created by PhpStorm.
 * User: Javier Ruiz
 * Date: 29/01/19
 * Time: 16:35
 */
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Producto;
use App\Entity\Shopper;
use App\Exceptions\NoAPIParametrosException;
use App\Repository\PedidoProductoRepository;
use App\Repository\PedidoRepository;
use App\Repository\ShopperRepository;
use App\Repository\TiendaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class APIShopperController
 * @Route("/api/shopper")
 */
class APIShopperController extends AbstractController
{
    /**
     * API para añadir un shopper a la base de datos
     * Parametros por POST:
     * nombre, tienda_id
     *
     * @Route("/add", name="shopper_api_add", methods={"POST"})
     *
     * @param Request          $request
     * @param TiendaRepository $tiendaRepository
     *
     * @return Response
     */
    public function add(Request $request, TiendaRepository $tiendaRepository)
    {
        try {
            $persistShopper = $this->createNewObject($request, $tiendaRepository);
            $results[] = [
                'mensaje' => 'Exito al guardar',
                'codigo' => '1',
                'shopper_id' => $persistShopper->getId(),
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
     * @param Request $request
     * @param TiendaRepository $tiendaRepository
     *
     * @return Shopper
     *
     * @throws \Exception
     */
    private function createNewObject(Request $request, TiendaRepository $tiendaRepository)
    {
        if (empty($request->request->count())) {
            throw new NoAPIParametrosException();
        }
        $shopper = new Shopper();
        $shopper->setNombre($request->get('nombre'));

        $tienda = $tiendaRepository->find($request->get('tienda_id'));
        $shopper->setTienda($tienda);

        $em = $this->getDoctrine()->getManager();
        $em->persist($shopper);
        $em->flush();

        return $shopper;
    }

    /**
     * @Route("/dispatch", name="shopper_api_dipatch", methods={"GET"})
     */
    public function dispatchPedidos(Request $request, ShopperRepository $shopperRepository, PedidoRepository $pedidoRepository, TiendaRepository $tiendaRepository,PedidoProductoRepository $pedidoProductoRepository)
    {
        if (empty($request->query->count())) {
            throw new NoAPIParametrosException();
        }
        //ID tienda y ID shopper y devuelva pedido y productos que ha de comprar (pueden ser de varios pedidos)
        $tienda  = $tiendaRepository->find($request->get('tienda_id'));
        $shopper = $shopperRepository->find($request->get('shopper_id'));
        //TODO buscar pedidos con productos de la tienda
        $pedidos = $pedidoRepository->findAll();
//        $pedidoProducto = $pedidoProductoRepository->findAll();

//        dump($pedidos[1]);
//        die();
        $productosTienda=array();

        foreach($pedidos as $pedido) {
            $pedidoProductos = $pedido->getPedidoProductos();
            foreach($pedidoProductos as $pedidoProducto) {
                /** @var Producto $producto */
                $producto = $pedidoProducto->getProducto();
                if($producto->getTienda()->getId() == $tienda->getId()) {
                    $productosTienda[] = [
                      $pedido->getId() => $producto->getId()
                    ];
                }
            }
        }
//        dump($productosTienda);
//        die();
        try {

            $results[] = [
                'mensaje' => 'Exito al guardar',
                'codigo' => '1',
                'items' => $productosTienda
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
}