<?php
declare(strict_types=1);

namespace Core\Application\Credentials;

use Core\Domain\Credentials\Credentials;
use Core\Domain\Credentials\CredentialsRepository;
use Core\Domain\User\UserId;

class GetAllCredentialsHandler
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
     * @param GetAllCredentials $query
     * @return CredentialsDto[]
     */
    public function __invoke(GetAllCredentials $query): array
    {
        $userId = new UserId($query->userId());

        $all = $this->repository->allOfUserId($userId);

        return $this->writeDto($all);
    }

    /**
     * @param array $all
     * @return CredentialsDto[]
     */
    private function writeDto(array $all): array
    {
        return array_map(function (Credentials $credentials) {
            return $this->dtoAssembler->writeDto($credentials);
        }, $all);
    }
}
