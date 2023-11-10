<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct(private MailerInterface $mailer)
    {
    }
    public function sendEmail(
        $to = 'brice.mich@gmail.com',
        $content = '<p>See Twig integration for better HTML integration!</p>',
        $subject = 'Time for Symfony Mailer!'
    ): void {
        $email = (new Email())
            ->from('choixenligne@minesecdrh.cm')
            ->to($to)
            ->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            ->html($content);
        $this->mailer->send($email);
    }
}
