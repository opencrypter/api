<?php
declare(strict_types=1);

namespace Core\Application\Credentials;

use Core\Domain\Credentials\CredentialsId;
use Core\Domain\Credentials\CredentialsRepository;
use Core\Domain\User\UserId;

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
        $id     = new CredentialsId($query->id());
        $userId = new UserId($query->userId());

        if (null === $credentials = $this->repository->credentialsOfId($id)) {
            throw new CredentialsNotFound($id);
        }

        if (!$credentials->userId()->equals($userId)) {
            throw new CredentialsDoNotBelongToTheUser($id, $userId);
        }

        return $this->dtoAssembler->writeDto($credentials);
    }
}
