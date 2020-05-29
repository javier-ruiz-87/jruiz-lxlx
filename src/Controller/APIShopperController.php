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
use App\Exceptions\NoAPIParametrosException;
use App\Repository\ShopperRepository;
use App\Repository\TiendaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

/**
 * Class APIShopperController
 * @Route("/api/shopper")
 */
class APIShopperController extends AbstractController
{
    /**
     * API para añadir un shopper a la base de datos
     * Parametros por POST: nombre, tienda_id
     *
     * @Route("/add", name="shopper_api_add", methods={"POST"})
     *
     * @param Request          $request
     * @param TiendaRepository $tiendaRepository
     *
     * @return JsonResponse
     */
    public function add(Request $request, TiendaRepository $tiendaRepository)
    {
        try {
            $persistShopper = $this->createNewObject($request, $tiendaRepository);
            $results[] = [
                'mensaje' => 'Exito al guardar',
                'shopper_id' => $persistShopper->getId(),
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
     * @Route("/list", name="shopper_api_list")
     *
     * @param ShopperRepository $shopperRepository
     *
     * @return JsonResponse
     */
    public function list(ShopperRepository $shopperRepository)
    {
        try {
            $shoppers = $shopperRepository->findAll();
            $shoppersArray = [];
            foreach ($shoppers as $shopper)
            {
                $shoppersArray[] = $this->dataTransform($shopper);
            }

            $results[] = [
                'mensaje' => 'Shoppers',
                'shoppers' => $shoppersArray,
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
     * @param Request $request
     * @param TiendaRepository $tiendaRepository
     *
     * @return Shopper
     *
     * @throws \Exception
     */
    private function createNewObject(Request $request, TiendaRepository $tiendaRepository)
    {
        if ($request->request->count() < 2) {
            throw new NoAPIParametrosException('Espero: nombre y tienda_id');
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
     * @param Shopper $shopper
     *
     * @return array
     */
    private function dataTransform(Shopper $shopper)
    {
        return [
          'id' => $shopper->getId(),
          'nombre' => $shopper->getNombre(),
          'tienda' => $shopper->getTienda()->getNombre(),
           'alta' => $shopper->getCreatedAt()->format('d-m-Y')
        ];
    }
}