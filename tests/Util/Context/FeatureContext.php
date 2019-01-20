<?php

namespace Tests\Util\Context;

use Behat\Behat\Context\Context;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;

class FeatureContext implements Context
{
    /**
     * @var EntityManager
     */
    private $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @BeforeScenario
     */
    public function clearData(): void
    {
        (new ORMPurger($this->manager))->purge();
    }
}
