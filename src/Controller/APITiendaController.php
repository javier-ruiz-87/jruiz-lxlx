<?php
/**
 * Created by PhpStorm.
 * User: Javier Ruiz
 * Date: 29/01/19
 * Time: 11:37
 */
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Tienda;
use App\Exceptions\NoAPIParametrosException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiTiendaController
 * @Route("/api/tienda")
 */
class APITiendaController extends AbstractController
{
    /**
     * API para añadir una tienda
     * Parametros por POST: nombre, direccion
     *
     * @Route("/add", name="tienda_api_add", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function add(Request $request)
    {
        try {
            $persistTienda = $this->createNewObject($request);
            $results[] = [
                    'mensaje' => 'Exito al guardar',
                    'tienda_id' => $persistTienda->getId(),
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
     * @param Request $request
     *
     * @return Tienda
     *
     * @throws NoAPIParametrosException
     */
    protected function createNewObject(Request $request)
    {
        if ($request->request->count() < 2) {
            throw new NoAPIParametrosException('Espero: nombre y direccion');
        }
        $tienda = new Tienda();
        $tienda->setNombre($request->get('nombre'));
        $tienda->setDireccion($request->get('direccion'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($tienda);
        $em->flush();

        return $tienda;
    }
}