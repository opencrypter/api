<?php
declare(strict_types=1);

namespace Core\Domain;

interface RootAggregate
{
    /**
     * @return Id
     */
    public function id();
}
