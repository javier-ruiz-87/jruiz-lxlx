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
     * Parametros por POST: nombre, descripcion, unidades en tienda, precio (en centimos)
     *
     * @Route("/add", name="producto_api_add", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function add(Request $request)
    {
        try {
            $persistProducto = $this->createNewObject($request);
            $results[] = [
                'mensaje' => 'Exito al guardar',
                'codigo' => '1',
                'producto_id' => $persistProducto->getId(),
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
     * @param Request $request
     *
     * @return Producto
     */
    protected function createNewObject(Request $request)
    {
        $producto = new Producto();

        $producto->setNombre($request->get('nombre'));
        $producto->setDescripcion($request->get('descripcion'));
        $producto->setUnidades($request->get('unidades'));
        $producto->checkAndSetPrecio($request->get('precio'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($producto);
        $em->flush();

        return $producto;
    }

}