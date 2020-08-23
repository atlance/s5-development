<?php

declare(strict_types=1);

namespace App\Model\User\Service;

use App\Doctrine\Dbal\Type\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class SignUpConfirmEmailTokenSender
{
    private MailerInterface $mailer;
    private string $fromAppEmail;

    public function __construct(MailerInterface $mailer, string $fromAppEmail)
    {
        $this->mailer = $mailer;
        $this->fromAppEmail = $fromAppEmail;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(Email $address, string $token) : void
    {
        $email = (new TemplatedEmail())
            ->from($this->fromAppEmail)
            ->to($address->getValue())
            ->subject('Подтверждение регистрации')
            ->htmlTemplate('user/use_case/signup/email/confirm.html.twig')
            ->context([
                'token' => $token,
            ])
        ;

        $this->mailer->send($email);
    }
}
