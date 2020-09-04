<?php

declare(strict_types=1);

namespace App\ReadModel\SubDomainPage\View;

use App\ReadModel\AbstractView;

class SubDomainPageView extends AbstractView
{
    public string $template;

    public function __toString() : string
    {
        return $this->template;
    }
}
