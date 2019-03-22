<?php
declare(strict_types=1);

namespace Core\Application\Credentials;

class GetCredentialsDetail
{
    /**
     * @var string
     */
    private $id;

    /**
     * GetCredentialsDetail constructor.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }
}
