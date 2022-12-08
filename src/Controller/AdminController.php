<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        // just set up a fresh $task object (remove the example data)
        $admin = new Admin();

        $form = $this->createForm(AdminType::class, $admin);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $admin = $form->getData();

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($admin);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('app_admin');
        }

        return $this->renderForm('visitor/order.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/admin', name: 'app_admin')]
    public function adminAction(Request $request, ManagerRegistry $doctrine): Response
    {
        $orders = $doctrine->getRepository(Order::class)->findAll();

        return $this->render('admin/index.html.twig', [
            'orders' => $orders,
        ]);
    }
}
