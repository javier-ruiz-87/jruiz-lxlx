<?php

namespace App\Controller;

use App\Entity\Shopper;
use App\Form\ShopperType;
use App\Repository\ShopperRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shopper")
 */
class ShopperController extends AbstractController
{
    /**
     * @Route("/", name="shopper_index", methods={"GET"})
     */
    public function index(ShopperRepository $shopperRepository): Response
    {
        return $this->render('shopper/index.html.twig', [
            'shoppers' => $shopperRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="shopper_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $shopper = new Shopper();
        $form = $this->createForm(ShopperType::class, $shopper);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($shopper);
            $entityManager->flush();

            return $this->redirectToRoute('shopper_index');
        }

        return $this->render('shopper/new.html.twig', [
            'shopper' => $shopper,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shopper_show", methods={"GET"})
     */
    public function show(Shopper $shopper): Response
    {
        return $this->render('shopper/show.html.twig', [
            'shopper' => $shopper,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="shopper_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Shopper $shopper): Response
    {
        $form = $this->createForm(ShopperType::class, $shopper);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('shopper_index', [
                'id' => $shopper->getId(),
            ]);
        }

        return $this->render('shopper/edit.html.twig', [
            'shopper' => $shopper,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shopper_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Shopper $shopper): Response
    {
        if ($this->isCsrfTokenValid('delete'.$shopper->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($shopper);
            $entityManager->flush();
        }

        return $this->redirectToRoute('shopper_index');
    }
}
