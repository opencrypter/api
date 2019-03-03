<?php
declare(strict_types=1);

namespace Core\Domain\Order;

use Core\Domain\AggregateRoot;
use Core\Domain\CreatedAt;
use Core\Domain\Order\Step\AnExecutedStepIsImmutable;
use Core\Domain\Order\Step\Step;
use Core\Domain\User\UserId;
use Doctrine\Common\Collections\ArrayCollection;

class Order extends AggregateRoot
{
    /**
     * @var OrderId
     */
    private $id;

    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var ArrayCollection|Step[]
     */
    private $steps;

    /**
     * @var CreatedAt
     */
    private $createdAt;

    /**
     * Order constructor.
     *
     * @param OrderId $id
     * @param UserId  $userId
     * @param array   $steps
     */
    public function __construct(OrderId $id, UserId $userId, array $steps)
    {
        $this->id        = $id;
        $this->userId    = $userId;
        $this->steps     = new ArrayCollection($steps);
        $this->createdAt = CreatedAt::now();

        $this->record(OrderCreated::create($this));
    }

    /**
     * @return OrderId
     */
    public function id(): OrderId
    {
        return $this->id;
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * @param UserId $userId
     * @return bool
     */
    public function belongsTo(UserId $userId): bool
    {
        return $this->userId->equalsTo($userId);
    }

    /**
     * @return Step[]
     */
    public function steps(): array
    {
        return $this->steps->toArray();
    }

    /**
     * @param Step[] $steps
     * @throws AnExecutedStepIsImmutable
     */
    public function updateSteps(array $steps): void
    {
        $givenSteps = new ArrayCollection($steps);

        $this->assertExecutedStepsAreIn($givenSteps);

        $this->steps = $givenSteps->map(function (Step $step) {
            return $this->buildStep($step);
        });

        OrderStepsUpdated::create($this);
    }

    /**
     * @param Step $step
     * @return Step
     * @throws AnExecutedStepIsImmutable
     */
    private function buildStep(Step $step): Step
    {
        if (null === $existingStep = $this->stepOfPosition($step)) {
            return $step;
        }

        if ($existingStep->hasBeenExecuted() && !$existingStep->equals($step)) {
            throw new AnExecutedStepIsImmutable($this->id, $step->position());
        }

        return $existingStep->copyFrom($step);
    }

    /**
     * @param Step $step
     * @return Step|null
     */
    private function stepOfPosition(Step $step): ?Step
    {
        $step = $this->steps->filter(function (Step $existingStep) use ($step) {
            return $existingStep->position()->equals($step->position());
        })->first();

        return $step !== false ? $step : null;
    }

    /**
     * @param ArrayCollection $givenSteps
     * @throws AnExecutedStepIsImmutable
     */
    private function assertExecutedStepsAreIn(ArrayCollection $givenSteps): void
    {
        /** @var Step[] $executedSteps */
        $executedSteps = $this->steps->filter(function (Step $step) {
            return $step->hasBeenExecuted();
        });

        foreach ($executedSteps as $step) {
            if (!$givenSteps->contains($step)) {
                throw new AnExecutedStepIsImmutable($this->id, $step->position());
            };
        }
    }

    /**
     * @return CreatedAt
     */
    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }
}
