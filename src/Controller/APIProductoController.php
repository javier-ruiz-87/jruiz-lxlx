<?php
/**
 * Created by PhpStorm.
 * User: Javier Ruiz
 * Date: 29/01/19
 * Time: 12:16
 */
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Producto;
use App\Exceptions\NoAPIParametrosException;
use App\Exceptions\ValorIncorrectoException;
use App\Repository\TiendaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class APIProductoController
 * @Route("/api/producto")
 */
class APIProductoController extends AbstractController
{
    /**
     * API para añadir un producto
     * Parametros por POST: nombre, descripcion, unidades en tienda, precio (en centimos), tienda_id
     *
     * @Route("/add", name="producto_api_add", methods={"POST"})
     *
     * @param Request          $request
     * @param TiendaRepository $tiendaRepository
     *
     * @return Response
     */
    public function add(Request $request, TiendaRepository $tiendaRepository)
    {
        try {
            $persistProducto = $this->createNewObject($request, $tiendaRepository);
            $results[] = [
                'mensaje' => 'Exito al guardar',
                'producto_id' => $persistProducto->getId(),
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
     * Crea nuevo objeto y lo persiste
     *
     * @param Request          $request
     * @param TiendaRepository $tiendaRepository
     *
     * @return Producto
     *
     * @throws \Exception
     */
    protected function createNewObject(Request $request, TiendaRepository $tiendaRepository)
    {
        if ($request->request->count() < 5) {
            throw new NoAPIParametrosException('Espero: nombre, descripcion, unidades (en tienda), precio (en centimos), tienda_id');
        }

        //TODO hacer con formulario por validadores
        $producto = new Producto();
        if ('' == $request->get('nombre')) {
            throw new ValorIncorrectoException('nombre');
        }

        $producto->setNombre($request->get('nombre'));

        $producto->setDescripcion($request->get('descripcion'));
        $producto->setUnidades((int)$request->get('unidades'));
        $producto->checkAndSetPrecio($request->get('precio'));

        $tienda = $tiendaRepository->find($request->get('tienda_id'));
        $producto->setTienda($tienda);

        $em = $this->getDoctrine()->getManager();
        $em->persist($producto);
        $em->flush();

        return $producto;
    }

}