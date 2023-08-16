<?php

namespace App\Notification;

use App\Entity\Contact;
use Monolog\Handler\SwiftMailerHandler;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;

class ContactNotification
{
    /**
     * 
     * @var MailerInterface
     */
    private MailerInterface $mailer;
    /**
     * @param \Symfony\Component\Mailer\MailerInterface $mailer
     * @param \Twig\Environment $renderer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Constitue une représentation de la personne qui souhaite nous contacter
     * @param \App\Entity\Contact $contact
     * @return void
     */
    public function notify(Contact $contact)
    {
        $message = (new TemplatedEmail())
            ->from('noreply@agence.fr')
            ->to('contact@agence.fr')
            ->replyTo($contact->getEmail())
            ->subject('Agence : ' . $contact->getHousing()->getTitle())
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                'contact' => $contact
            ]);

        $this->mailer->send($message);
    }
}
