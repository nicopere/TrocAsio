<?php

namespace App\Controller\Admin;

use App\Entity\MaintenanceOperation;
use App\Form\MaintenanceOperationType;
use App\Repository\MaintenanceOperationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/maintenance-operation')]
class MaintenanceOperationController extends AbstractController
{
    #[Route('', name: 'app_admin_maintenance_operation_index', methods: ['GET'])]
    public function index(Request $request, MaintenanceOperationRepository $repository): Response
    {
        $dates = [];
        if ($request->query->has('start')) {
            $dates['start'] = $request->query->get('start');
        }
        if ($request->query->has('end')) {
            $dates['end'] = $request->query->get('end');
        }

        $operations = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new QueryAdapter($repository->findByDate()),
            $request->query->get('page', 1),
            10
        );

        return $this->render('admin/maintenance_operation/index.html.twig', [
            'operations' => $operations,
        ]);
    }

    #[Route('/new', name: 'app_admin_maintenance_operation_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_admin_maintenance_operation_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?MaintenanceOperation $operation, Request $request, EntityManagerInterface $manager): Response
    {
        $operation ??= new MaintenanceOperation();
        $form = $this->createForm(MaintenanceOperationType::class, $operation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($operation);
            $manager->flush();

            return $this->redirectToRoute('app_admin_maintenance_operation_show', [
                'id' => $operation->getId(),
            ]);
        }

        return $this->render('admin/maintenance_operation/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_maintenance_operation_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?MaintenanceOperation $operation): Response
    {
        return $this->render('admin/maintenance_operation/show.html.twig', [
            'operation' => $operation,
        ]);
    }
}
