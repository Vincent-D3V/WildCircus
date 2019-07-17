<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 16/07/19
 * Time: 15:09
 */
namespace App\Controller;

use App\Form\ContactFormType;
use App\Form\TicketFormType;
use App\Repository\PerformanceRepository;
use App\Repository\ShowRepository;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="home_")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="show")
     */
    public function show(ShowRepository $repository)
    {
        $show = $repository->findAll();
        return $this->render("show.html.twig",
            [
                "shows" => $show,
            ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);
        $data = $form->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            $message = (new \Swift_Message('Un nouveau formulaire de contacte a été soumis.'))
                ->setFrom("vincent.mallard5@gmail.com")
                ->setTo("vincent.mallard5@gmail.com")
                ->setBody(
                    $this->renderView(
                        "contactMail.html.twig",
                        [
                            "data" => $data,
                        ]
                    ),
                    'text/html'
                );
            $mailer->send($message);
            $this->addFlash('success', 'Votre message a bien été transmis');
        }
        return $this->render(
            'contact.html.twig',
            [
                "contactForm" => $form->createView()
            ]
        );
    }

    /**
     * @Route("/ticket/{id}", name="ticketid")
     */
    public function buyTicketsById(int $id, Request $request, Swift_Mailer $mailer, PerformanceRepository $performanceRepository)
    {
        $performance = $performanceRepository->findOneBy(['id' => $id]);
        $ticketNumber = uniqid("000");
        $form = $this->createForm(TicketFormType::class);
        $form->handleRequest($request);
        $data = $form->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            $message = (new \Swift_Message('Recapitulatif de votre commande Wilde Circus'))
                ->setFrom("vincent.mallard5@gmail.com")
                ->setTo("vincent.mallard5@gmail.com")
                ->setBody(
                    $this->renderView(
                        "ticketMail.html.twig",
                        [
                            "ticketNumber" => $ticketNumber,
                            "data" => $data,
                        ]
                    ),
                    'text/html'
                );
            $mailer->send($message);
            $this->addFlash('success', 'Veuillez vérifez votre boite mail afin de finalisé votre commande');
        }
        return $this->render(
            'ticketById.html.twig',
            [
                "ticketForm" => $form->createView(),
                "performances" => $performance,
            ]
        );
    }

    /**
     * @Route("/ticket", name="ticket")
     */
    public function buyTickets(Request $request, Swift_Mailer $mailer)
    {
        $ticketNumber = uniqid("000");
        $form = $this->createForm(TicketFormType::class);
        $form->handleRequest($request);
        $data = $form->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            $message = (new \Swift_Message('Recapitulatif de votre commande Wilde Circus'))
                ->setFrom("vincent.mallard5@gmail.com")
                ->setTo("vincent.mallard5@gmail.com")
                ->setBody(
                    $this->renderView(
                        "ticketMail.html.twig",
                        [
                            "ticketNumber" => $ticketNumber,
                            "data" => $data,
                        ]
                    ),
                    'text/html'
                );
            $mailer->send($message);
            $this->addFlash('success', 'Veuillez vérifez votre boite mail afin de finalisé votre commande');
        }
        return $this->render(
            'ticket.html.twig',
            [
                "ticketForm" => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/numero", name="performance")
     */
    public function performance(PerformanceRepository $repository)
    {
        $performance = $repository->findAll();
        return $this->render("performance.html.twig",
            [
                "performances" => $performance,
            ]);
    }

}