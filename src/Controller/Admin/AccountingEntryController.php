<?php

namespace App\Controller\Admin;

use App\Entity\AccountingEntry;
use App\Enum\CalculatorStatus;
use App\Form\AccountingEntryType;
use App\Repository\AccountingEntryRepository;
use App\Repository\CalculatorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/accounting-entry')]
class AccountingEntryController extends AbstractController
{
    #[Route('', name: 'app_admin_accounting_entry_index', methods: ['GET'])]
    public function index(Request $request, AccountingEntryRepository $repository): Response
    {
        $dates = [];
        if ($request->query->has('start')) {
            $dates['start'] = $request->query->get('start');
        }
        if ($request->query->has('end')) {
            $dates['end'] = $request->query->get('end');
        }

        $entries = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new QueryAdapter($repository->findByDate($dates)),
            $request->query->get('page', 1),
            10
        );

        return $this->render('admin/accounting_entry/index.html.twig', [
            'entries' => $entries,
            'balance' => $repository->balance(),
        ]);
    }

    #[Route('/new', name: 'app_admin_accounting_entry_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_admin_accounting_entry_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?AccountingEntry $entry, Request $request, EntityManagerInterface $manager, CalculatorRepository $repository): Response
    {
        //$entry ??= new AccountingEntry();
        if ($entry == null) { // new
            $entry ??= new AccountingEntry();
            $qb = $repository->findByStatus('in');
        } else {              // edit
            $qb = $repository->findByStatus('');
        }
        $calculators=$qb->getQuery()->getResult();
        $form = $this->createForm(AccountingEntryType::class, $entry, [
            'calculators' => $calculators,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($entry);
            if (null !== $entry->getCalculator() && $entry->getAmount() > 0) {
                $calculator_id = $entry->getCalculator()->getId();
                $calculator=$repository->find($calculator_id)->setStatus(CalculatorStatus::Out);
                $manager->persist($calculator);
            }
            $manager->flush();

            return $this->redirectToRoute('app_admin_accounting_entry_show', [
                'id' => $entry->getId(),
            ]);
        }

        return $this->render('admin/accounting_entry/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_accounting_entry_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?AccountingEntry $entry): Response
    {
        return $this->render('admin/accounting_entry/show.html.twig', [
            'entry' => $entry,
        ]);
    }
}
