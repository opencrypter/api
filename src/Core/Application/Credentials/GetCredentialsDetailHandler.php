<?php
declare(strict_types=1);

namespace Core\Application\Credentials;

use Core\Domain\Credentials\CredentialsId;
use Core\Domain\Credentials\CredentialsRepository;

class GetCredentialsDetailHandler
{
    /**
     * @var CredentialsRepository
     */
    private $repository;

    /**
     * @var CredentialsDtoAssembler
     */
    private $dtoAssembler;

    public function __construct(CredentialsRepository $repository, CredentialsDtoAssembler $dtoAssembler)
    {
        $this->repository   = $repository;
        $this->dtoAssembler = $dtoAssembler;
    }

    /**
     * @param GetCredentialsDetail $query
     * @return CredentialsDto
     */
    public function __invoke(GetCredentialsDetail $query)
    {
        $id = new CredentialsId($query->id());

        if (null === $credentials = $this->repository->credentialsOfId($id)) {
            throw new CredentialsNotFound($id);
        }

        return $this->dtoAssembler->writeDto($credentials);
    }
}
