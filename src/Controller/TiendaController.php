<?php

namespace App\Controller;

use App\Entity\Tienda;
use App\Form\TiendaType;
use App\Repository\TiendaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tienda")
 */
class TiendaController extends AbstractController
{
    /**
     * @Route("/", name="tienda_index", methods={"GET"})
     */
    public function index(TiendaRepository $tiendaRepository): Response
    {
        return $this->render('tienda/index.html.twig', [
            'tiendas' => $tiendaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tienda_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tienda = new Tienda();
        $form = $this->createForm(TiendaType::class, $tienda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tienda);
            $entityManager->flush();

            return $this->redirectToRoute('tienda_index');
        }

        return $this->render('tienda/new.html.twig', [
            'tienda' => $tienda,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tienda_show", methods={"GET"})
     */
    public function show(Tienda $tienda): Response
    {
        return $this->render('tienda/show.html.twig', [
            'tienda' => $tienda,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tienda_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tienda $tienda): Response
    {
        $form = $this->createForm(TiendaType::class, $tienda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tienda_index', [
                'id' => $tienda->getId(),
            ]);
        }

        return $this->render('tienda/edit.html.twig', [
            'tienda' => $tienda,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tienda_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tienda $tienda): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tienda->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tienda);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tienda_index');
    }
}
