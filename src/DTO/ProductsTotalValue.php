<?php

declare(strict_types=1);

namespace App\DTO;

class ProductsTotalValue
{
    private int $value = 0;

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }
}
