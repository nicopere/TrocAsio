<?php

namespace App\Controller\Admin;

use App\Entity\Calculator;
use App\Form\CalculatorType;
use App\Repository\CalculatorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/calculator')]
class CalculatorController extends AbstractController
{
    #[Route('', name: 'app_admin_calculator_index', methods: ['GET'])]
    public function index(Request $request, CalculatorRepository $repository): Response
    {
        $status = '';
        if ($request->query->has('status')) {
            $status = $request->query->get('status');
        }

        $calculators = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new QueryAdapter($repository->findByStatus($status)),
            $request->query->get('page', 1),
            10
        );

        return $this->render('admin/calculator/index.html.twig', [
            'calculators' => $calculators,
        ]);
    }

    #[Route('/new', name: 'app_admin_calculator_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_admin_calculator_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Calculator $calculator, Request $request, EntityManagerInterface $manager): Response
    {
        $calculator ??= new Calculator();
        $form = $this->createForm(CalculatorType::class, $calculator);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($calculator);
            $manager->flush();

            return $this->redirectToRoute('app_admin_calculator_show', [
                'id' => $calculator->getId(),
            ]);
        }

        $repository = $manager->GetRepository(Calculator::class);
        $nextId = $repository->nextId();
        return $this->render('admin/calculator/new.html.twig', [
            'form' => $form,
            'nextId' => $nextId,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_calculator_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Calculator $calculator): Response
    {
        return $this->render('admin/calculator/show.html.twig', [
            'calculator' => $calculator,
        ]);
    }
}
