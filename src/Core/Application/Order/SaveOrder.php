<?php
declare(strict_types=1);

namespace Core\Application\Order;

class SaveOrder
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var StepDto[]
     */
    private $steps;

    /**
     * CreateOrder constructor.
     *
     * @param string $id
     * @param string $userId
     * @param array  $steps
     */
    public function __construct(string $id, string $userId, array $steps)
    {
        $this->id     = $id;
        $this->userId = $userId;
        $this->steps  = $this->buildStepDtos($steps);
    }

    /**
     * @param array $steps
     * @return StepDto[]
     */
    private function buildStepDtos(array $steps): array
    {
        return array_map(function (array $step) {
            return new StepDto(
                (int) $step['position'],
                $step['type'],
                $step['exchangeId'],
                $step['symbol'],
                (float) $step['value'],
                isset($step['dependsOf']) ? (int) $step['dependsOf'] : null
            );
        }, $steps);
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function userId(): string
    {
        return $this->userId;
    }

    /**
     * @return StepDto[]
     */
    public function steps(): array
    {
        return $this->steps;
    }
}
