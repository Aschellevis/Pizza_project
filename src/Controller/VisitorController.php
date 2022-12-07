<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Order;
use App\Entity\User;
use App\Form\OrderType;
use App\Entity\Product;
use App\Repository\OrderRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class VisitorController extends AbstractController
{
    #[Route('/', name: 'app_visitor')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $categories = $doctrine->getRepository(Category::class)->findAll();

        return $this->render('visitor/index.html.twig', [
            'categories'=>$categories,
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function aboutAction(): Response
    {
        return $this->render('visitor/about.html.twig', [
            'about' => 'VisitorController',
        ]);
    }

    #[Route('/pizza/{category_id}', name: 'app_category')]
    public function show(ManagerRegistry $doctrine, int $category_id, Request $request): Response
    {
        $category = $doctrine->getRepository(Category::class)->find($category_id);
        return $this->render("visitor/pizza.html.twig",[
            'category'=>$category]);
    }

    #[Route('/login', name: 'app_login')]
    public function loginAction(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
          return $this->render('visitor/login.html.twig', [
              'last_username' => $lastUsername,
              'error'         => $error,
          ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contactAction(): Response
    {
        return $this->render('visitor/contact.html.twig', [
            'contact' => 'VisitorController',
        ]);
    }

    #[Route('/order/{id}', name: 'app_order')]
    public function new(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        // just set up a fresh $task object (remove the example data)
        $order = new Order();

        $form = $this->createForm(OrderType::class, $order);
        $product = $doctrine->getRepository(Product::class)->find($id);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $order = $form->getData();
            $order->setPizza($product);
            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($order);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('app_payed');
        }

        return $this->renderForm('visitor/order.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/payed', name: 'app_payed')]
    public function payedAction(): Response
    {
        return $this->render('visitor/payed.html.twig', [
            'payed' => 'VisitorController',
        ]);
    }

//    #[Route('/test', name: 'app_test')]
//    public function test(UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine)
//    {
//        $entityManager = $doctrine->getManager();
//
//        // ... e.g. get the user data from a registration form
//        $user = new User();
//        $plaintextPassword = "qwerty";
//
//        // hash the password (based on the security.yaml config for the $user class)
//        $hashedPassword = $passwordHasher->hashPassword(
//            $user,
//            $plaintextPassword
//        );
//        $user->setPassword($hashedPassword);
//        $user->setEmail("baker@email.com");
//        $user->setRoles((array)"ROLE_ADMIN");
//
//        $entityManager->persist($user);
//
//        $entityManager->flush();
//
//        return $this->redirectToRoute('app_visitor');
//    }
}
