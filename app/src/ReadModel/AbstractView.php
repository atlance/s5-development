<?php

declare(strict_types=1);

namespace App\ReadModel;

abstract class AbstractView
{
    public function __construct(array $data = [])
    {
        $this->setup(array_intersect_key($data, $this->toArray()));
    }

    public function toArray() : array
    {
        return get_object_vars($this);
    }

    private function setup(array $properties) : self
    {
        foreach ($properties as $property => $value) {
            $method = 'set' . ucfirst($property);
            if (\is_callable([$this, $method])) {
                $this->{$method}($value); /* @phpstan-ignore-line */

                continue;
            }

            $this->{$property} = $value; /* @phpstan-ignore-line */
        }

        return $this;
    }
}
