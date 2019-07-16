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
        }
        return $this->render(
            'contact.html.twig',
            [
                "contactForm" => $form->createView()
            ]
        );
    }

    /**
     * @Route("/ticket", name="ticket")
     */
    public function buyTickets(Request $request, Swift_Mailer $mailer)
    {
        $form = $this->createForm(TicketFormType::class);
        $form->handleRequest($request);
        $data = $form->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            $message = (new \Swift_Message('Un nouveau formulaire de contacte a été soumis.'))
                ->setFrom("vincent.mallard5@gmail.com")
                ->setTo("vincent.mallard5@gmail.com")
                ->setBody(
                    $this->renderView(
                        "ticketMail.html.twig",
                        [
                            "data" => $data,
                        ]
                    ),
                    'text/html'
                );
            $mailer->send($message);
        }
        return $this->render(
            'ticket.html.twig',
            [
                "ticketForm" => $form->createView()
            ]
        );
    }
}