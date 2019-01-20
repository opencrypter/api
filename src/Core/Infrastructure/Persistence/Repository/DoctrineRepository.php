<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Repository;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

abstract class DoctrineRepository
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    abstract protected function entityClassName(): string;

    protected function manager(): ObjectManager
    {
        return $this->doctrine->getManager();
    }

    protected function repository(): ObjectRepository
    {
        return $this->manager()->getRepository($this->entityClassName());
    }

    protected function persistAndFlush($entity): void
    {
        $this->manager()->persist($entity);
        $this->manager()->flush($entity);
    }
}
