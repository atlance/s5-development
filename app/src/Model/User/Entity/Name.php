<?php

declare(strict_types=1);

namespace App\Model\User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Embeddable
 */
class Name
{
    /**
     * @ORM\Column(name="first", type="string", length=16)
     */
    private string $first;

    /**
     * @ORM\Column(name="last", type="string", length=16)
     */
    private string $last;

    public function __construct(string $first, string $last)
    {
        Assert::notEmpty($first, "first name can't be empty");
        Assert::notEmpty($last, "last name can't be empty");
        Assert::unicodeLetters($first, 'First name expected a value to contain only letters');
        Assert::unicodeLetters($last, 'Last name expected a value to contain only letters');

        $this->first = mb_convert_case($first, MB_CASE_TITLE, 'UTF-8');
        $this->last = mb_convert_case($last, MB_CASE_TITLE, 'UTF-8');
    }

    public function getFirst() : string
    {
        return $this->first;
    }

    public function getLast() : string
    {
        return $this->last;
    }

    public function getFull() : string
    {
        return $this->first . ' ' . $this->last;
    }
}
