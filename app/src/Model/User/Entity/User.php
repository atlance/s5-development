<?php

declare(strict_types=1);

namespace App\Model\User\Entity;

use App\Doctrine\Dbal\Type\Email;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="users", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"email"})
 * })
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="user_id")
     */
    private Id $id;

    /**
     * @ORM\Column(name="email", type="email", length=32, unique=true, nullable=true)
     */
    private ? Email $email;

    /**
     * @ORM\Embedded(class="Name")
     */
    private Name $name;

    /**
     * @ORM\Column(name="password_hash", type="string")
     */
    private string $passwordHash;

    /**
     * @ORM\Column(name="status", type="user_status", length=16)
     */
    private Status $status;

    /**
     * @ORM\Column(name="role", type="user_role", length=16, nullable=true)
     */
    private Role $role;

    /**
     * @ORM\Column(type="string", name="confirm_token", nullable=true)
     */
    private ? string $confirmToken;

    /**
     * @ORM\Embedded(class="Token", columnPrefix="reset_password_")
     */
    private ? Token $resetPasswordToken;

    /**
     * @ORM\Column(name="created_at", type="date_immutable")
     */
    private DateTimeImmutable $createdAt;

    public function __construct(Id $id, Name $name, Email $email = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->status = new Status();
    }

    public function getId() : Id
    {
        return $this->id;
    }

    public function getEmail() : ? Email
    {
        return $this->email;
    }

    public function getName() : Name
    {
        return $this->name;
    }

    public function getPasswordHash() : string
    {
        return $this->passwordHash;
    }

    public function getStatus() : Status
    {
        return $this->status;
    }

    public function getRole() : ? Role
    {
        return $this->role;
    }

    public function getConfirmToken() : ?string
    {
        return $this->confirmToken;
    }

    public function getResetPasswordToken() : ? Token
    {
        return $this->resetPasswordToken;
    }

    public function getCreatedAt() : DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function confirmSignUp() : void
    {
        if (!$this->status->isWait()) {
            throw new \DomainException('User is already confirmed.');
        }

        $this->role = Role::user();
        $this->status = Status::toActive();
        $this->confirmToken = null;
    }

    public function requestPasswordReset(Token $token, DateTimeImmutable $date) : Token
    {
        if (!$this->status->isActive()) {
            throw new \DomainException('User is not active.');
        }
        if (!$this->email instanceof Email) {
            throw new \DomainException('Email is not specified.');
        }
        if ($this->resetPasswordToken instanceof Token &&
            !$this->resetPasswordToken->isExpiredTo($date)) {
            throw new \DomainException('Resetting is already requested.');
        }

        $this->resetPasswordToken = $token;

        return $token;
    }

    public function passwordReset(\DateTimeImmutable $date, string $hash) : void
    {
        if (!$this->resetPasswordToken instanceof Token) {
            throw new \DomainException('Resetting is not requested.');
        }
        if ($this->resetPasswordToken->isExpiredTo($date)) {
            throw new \DomainException('Reset token is expired.');
        }
        $this->passwordHash = $hash;
        $this->resetPasswordToken = null;
    }

    public function editProfile(Email $email, Name $name, string $hash) : void
    {
        $this->email = $email;
        $this->name = $name;
        $this->passwordHash = $hash;
    }

    /**
     * @ORM\PostLoad()
     */
    public function checkEmbeds() : void
    {
        if ($this->resetPasswordToken instanceof Token &&
            null === $this->resetPasswordToken->getToken()
        ) {
            $this->resetPasswordToken = null;
        }
    }

    public static function signUpByEmail(
        Id $id,
        Name $name,
        Email $email,
        DateTimeImmutable $date,
        string $token,
        string $hash
    ) : self {
        $user = new self($id, $name, $email);
        $user->createdAt = $date;
        $user->confirmToken = $token;
        $user->passwordHash = $hash;
        $user->status->toWait();

        return $user;
    }
}
