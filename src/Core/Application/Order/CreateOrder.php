<?php
declare(strict_types=1);

namespace Core\Application\Order;

class CreateOrder
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var StepDto[]
     */
    private $steps;

    /**
     * CreateOrder constructor.
     *
     * @param string $id
     * @param array  $steps
     */
    public function __construct(string $id, array $steps)
    {
        $this->id    = $id;
        $this->steps = $this->buildStepDtos($steps);
    }

    /**
     * @param array $steps
     * @return StepDto[]
     */
    private function buildStepDtos(array $steps): array
    {
        return array_map(function (array $step) {
            return new StepDto(
                $step['position'],
                $step['type'],
                $step['exchangeId'],
                $step['symbol'],
                $step['value'],
                $step['dependsOf'] ?? null
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
     * @return StepDto[]
     */
    public function steps(): array
    {
        return $this->steps;
    }
}
