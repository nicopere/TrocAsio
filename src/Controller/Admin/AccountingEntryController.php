<?php

namespace App\Controller\Admin;

use App\Entity\AccountingEntry;
use App\Form\AccountingEntryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/accounting-entry')]
class AccountingEntryController extends AbstractController
{
    #[Route('', name: 'app_admin_accounting_entry_index')]
    public function index(): Response
    {
        return $this->render('admin/accounting_entry/index.html.twig', [
            'controller_name' => 'AccountingEntryController',
        ]);
    }
    #[Route('/new', name: 'app_admin_accounting_entry_new')]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $entity = new AccountingEntry();
        $form = $this->createForm(AccountingEntryType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entity);
            $manager->flush();
            return $this->redirectToRoute('app_admin_accounting_entry_index');
        }
        return $this->render('admin/accounting_entry/new.html.twig', [
            'form' => $form,
        ]);
    }
}
