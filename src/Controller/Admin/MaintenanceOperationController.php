<?php

namespace App\Controller\Admin;

use App\Entity\MaintenanceOperation;
use App\Form\MaintenanceOperationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/maintenance-operation')]
class MaintenanceOperationController extends AbstractController
{
    #[Route('', name: 'app_admin_maintenance_operation_index')]
    public function index(): Response
    {
        return $this->render('admin/maintenance_operation/index.html.twig', [
            'controller_name' => 'MaintenanceOperationController',
        ]);
    }
    #[Route('/new', name: 'app_admin_maintenance_operation_new')]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $entity = new MaintenanceOperation();
        $form = $this->createForm(MaintenanceOperationType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entity);
            $manager->flush();
            return $this->redirectToRoute('app_admin_maintenance_operation_index');
        }
        return $this->render('admin/maintenance_operation/new.html.twig', [
            'form' => $form,
        ]);
    }
}
