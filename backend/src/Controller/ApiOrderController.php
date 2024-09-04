<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function index(Request $request): JsonResponse
    {
        $name = $request->query->get('name');
        $description = $request->query->get('description');
        $date = $request->query->get('date');
        $queryBuilder = $this->orderRepository->createQueryBuilder('o');

        if ($name) {
            $queryBuilder->andWhere('o.name LIKE :name')
                ->setParameter('name', "%$name%");
        }

        if ($description) {
            $queryBuilder->andWhere('o.description LIKE :description')
                ->setParameter('description', "%$description%");
        }

        if ($date) {
            $date = new \DateTime($date);

            $startOfDay = clone $date;
            $startOfDay->setTime(0, 0, 0);

            $endOfDay = clone $date;
            $endOfDay->setTime(23, 59, 59);

            $queryBuilder->andWhere('o.date BETWEEN :start AND :end')
                ->setParameter('start', $startOfDay)
                ->setParameter('end', $endOfDay);
        }

        $orders = $queryBuilder->getQuery()->getResult();
        //$orders = $this->orderRepository->findAll();

        // Convert the orders to an array
        $data = array_map(function ($order) {
            return [
                'id' => $order->getId(),
                'name' => $order->getName(),
                'description' => $order->getDescription(),
                'date' => $order->getDate()->format('Y-m-d H:i:s'), // Format date if needed
                'products' => array_map(function ($product) {
                    return [
                        'id' => $product->getId(),
                        'name' => $product->getName(),
                        'price' => $product->getPrice(),
                    ];
                }, $order->getProducts()->toArray()),
            ];
        }, $orders);

        // Return JSON response
        return new JsonResponse($data);
    }

    #[Route('/api/order/view/{id}', name: 'app_api_order_view', methods: ['GET'])]
    public function view($id, Request $request): JsonResponse
    {
        $order = $this->orderRepository->find($id);

        if (!$order) {
            return new JsonResponse(['error' => 'Order not found'], Response::HTTP_NOT_FOUND);
        }

        $products = $order->getProducts();

        $orderData = [
            'id' => $order->getId(),
            'name' => $order->getName(),
            'description' => $order->getDescription(),
            'date' => $order->getDate()->format('Y-m-d H:i:s'),
            'products' => array_map(function ($product) {
                return [
                    'id' => $product->getId(),
                    'name' => $product->getName(),
                    'price' => $product->getPrice(),
                ];
            }, $products->toArray()),
        ];

        return new JsonResponse($orderData);
    }

    #[Route('/api/order/create', name: 'app_api_order_create')]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $order = new Order();

        $order->setName($data['name']);
        $order->setDescription($data['description']);
        $order->setDate(new \DateTime($data['date']));

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        // Restituisce la risposta JSON
        return $this->json([
            'id' => $order->getId(),
            'name' => $order->getName(),
            'description' => $order->getDescription(),
            'date' => $order->getDate()->format('Y-m-d H:i:s'),
        ], Response::HTTP_CREATED);
    }

    #[Route('/api/order/edit/{id}', name: 'app_api_order_edit')]
    public function update($id, Request $request): JsonResponse
    {
        $order = $this->orderRepository->find($id);
        if (!$order) {
            return $this->json(['message' => 'Ordine non trovato'], Response::HTTP_NOT_FOUND);
        }
        $data = json_decode($request->getContent(), true);

        $order->setName($data['name']);
        $order->setDescription($data['description']);
        $order->setDate(new \DateTime($data['date']));

        $this->entityManager->persist($order);
        $this->entityManager->flush();
        return $this->json([
            'id' => $order->getId(),
            'name' => $order->getName(),
            'description' => $order->getDescription(),
            'date' => $order->getDate()->format('Y-m-d H:i:s'),
        ], Response::HTTP_OK);
    }

    #[Route('/api/order/delete/{id}', name: 'app_api_order_delete', methods: ['DELETE'])]
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
