<?php

namespace App\Controller\Admin;

use App\Entity\Calculator;
use App\Form\CalculatorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/calculator')]
class CalculatorController extends AbstractController
{
    #[Route('', name: 'app_admin_calculator_index')]
    public function index(): Response
    {
        return $this->render('admin/calculator/index.html.twig', [
            'controller_name' => 'CalculatorController',
        ]);
    }
    #[Route('/new', name: 'app_admin_calculator_new')]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $entity = new Calculator();
        $form = $this->createForm(CalculatorType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entity);
            $manager->flush();
            return $this->redirectToRoute('app_admin_calculator_index');
        }
        return $this->render('admin/calculator/new.html.twig', [
            'form' => $form,
        ]);
    }
}
