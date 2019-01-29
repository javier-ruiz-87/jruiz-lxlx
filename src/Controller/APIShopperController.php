<?php
/**
 * Created by PhpStorm.
 * User: Javier Ruiz
 * Date: 29/01/19
 * Time: 16:35
 */
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Shopper;
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
     * @Route("/add", name="pedido_api_add", methods={"POST"})
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
     * @param Request          $request
     * @param TiendaRepository $tiendaRepository
     *
     * @return Shopper
     */
    private function createNewObject(Request $request, TiendaRepository $tiendaRepository)
    {
        $shopper = new Shopper();
        $shopper->setNombre($request->get('nombre'));
        $tienda = $tiendaRepository->findOneBy(['id'=>$request->get('tienda_id')]);

        $shopper->setTienda($tienda);

        $em = $this->getDoctrine()->getManager();
        $em->persist($shopper);
        $em->flush();

        return $shopper;
    }

}