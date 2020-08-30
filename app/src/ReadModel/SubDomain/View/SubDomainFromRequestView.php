<?php

declare(strict_types=1);

namespace App\ReadModel\SubDomain\View;

use App\ReadModel\AbstractView;

class SubDomainFromRequestView extends AbstractView
{
    public string $id;

    public function __toString() : string
    {
        return $this->id;
    }
}
