<?php
declare(strict_types=1);

namespace Tests\Util\Mock;

use Prophecy\Prophecy\ObjectProphecy;

abstract class Mock
{
    private $prophecy;

    public function __construct(ObjectProphecy $prophecy)
    {
        $this->prophecy = $prophecy;
    }

    /**
     * @return ObjectProphecy
     */
    protected function prophecy(): ObjectProphecy
    {
        return $this->prophecy;
    }

    public function reveal()
    {
        return $this->prophecy->reveal();
    }
}
