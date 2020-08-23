<?php

declare(strict_types=1);

namespace App\Model\User\Service;

use App\Doctrine\Dbal\Type\Email;
use App\Model\User\Entity\Token;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class ResetPasswordTokenSender
{
    private MailerInterface $mailer;
    private string $fromAppEmail;

    public function __construct(MailerInterface $mailer, string $fromAppEmail)
    {
        $this->mailer = $mailer;
        $this->fromAppEmail = $fromAppEmail;
    }

    public function send(Email $address, Token $token) : void
    {
        $email = (new TemplatedEmail())
            ->from($this->fromAppEmail)
            ->to($address->getValue())
            ->subject('Подтверждение сброса пароля')
            ->htmlTemplate('user/use_case/reset_password/request.html.twig')
            ->context([
                'token' => $token,
            ])
        ;

        $this->mailer->send($email);
    }
}
