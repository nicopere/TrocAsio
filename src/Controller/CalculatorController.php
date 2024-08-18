<?php

namespace App\Controller;

use App\Entity\Calculator;
use App\Enum\CalculatorStatus;
use App\Repository\CalculatorRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/calculator')]
class CalculatorController extends AbstractController
{
    #[Route('', name: 'app_calculator_index')]
    public function index(Request $request, CalculatorRepository $repository): Response
    {
        $calculators = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new QueryAdapter($repository->findByStatus('in')),
            $request->query->get('page', 1),
            10
        );

        return $this->render('calculator/index.html.twig', [
            'calculators' => $calculators,
            'count' => $repository->count([
                'status' => CalculatorStatus::In,
            ])
        ]);
    }

    #[Route('/{id}', name: 'app_calculator_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Calculator $calculator): Response
    {
        return $this->render('calculator/show.html.twig', [
            'calculator' => $calculator,
        ]);
    }
}
