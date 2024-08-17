<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ApiOrderController extends AbstractController
{
    private $entityManager;
    private $orderRepository;

    public function __construct(EntityManagerInterface $entityManager, OrderRepository $orderRepository)
    {
        $this->entityManager = $entityManager;
        $this->orderRepository = $orderRepository;
    }

    #[Route('/api/order', name: 'app_api_order')]
    public function index(): JsonResponse
    {
        $order = $this->orderRepository->findAll();
        //return $this->json($order);
        return $this->json(['aa' => 'bb']);
    }


    #[Route('/api/order', name: 'app_api_order_create')]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $order = new Order();
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        return $this->json($order, 201);
    }

    #[Route('/api/order', name: 'app_api_order_update')]
    public function update($id, Request $request): JsonResponse
    {
        $order = $this->orderRepository->find($id);
        if (!$order) {
            return $this->json(['message' => 'Ordine non trovato'], 404);
        }
        $data = json_decode($request->getContent(), true);
        // Aggiorna l'ordine con i nuovi dati
        $this->entityManager->flush();
        return $this->json($order);
    }

    #[Route('/api/order', name: 'app_api_order_delete')]
    public function delete($id): JsonResponse
    {
        $order = $this->orderRepository->find($id);
        if (!$order) {
            return $this->json(['message' => 'Ordine non trovato'], 404);
        }
        $this->entityManager->remove($order);
        $this->entityManager->flush();
        return $this->json(['message' => 'Ordine eliminato']);
    }
}
