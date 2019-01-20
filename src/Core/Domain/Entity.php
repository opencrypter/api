<?php
declare(strict_types=1);

namespace Core\Domain;

interface Entity
{
    /**
     * @return Id
     */
    public function id();
}
