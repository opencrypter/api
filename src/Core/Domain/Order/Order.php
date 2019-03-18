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
        return $this->userId->equals($userId);
    }

    /**
     * @return Step[]
     */
    public function steps(): array
    {
        return $this->steps->getValues();
    }

    /**
     * @param Step[] $steps
     * @throws AnExecutedStepIsImmutable
     */
    public function updateSteps(array $steps): void
    {
        $givenSteps = new ArrayCollection($steps);

        $this->removeStepsNotIn($givenSteps);

        foreach ($givenSteps as $step) {
            $this->putStep($step);
        }
    }

    /**
     * @param Step $step
     * @throws AnExecutedStepIsImmutable
     */
    private function putStep(Step $step): void
    {
        if (null === $existingStep = $this->stepOfPosition($step)) {
            $this->steps->add($step);
            $this->record(OrderStepsUpdated::create($this));

            return;
        }

        if ($existingStep->hasBeenExecuted() && !$existingStep->equals($step)) {
            throw AnExecutedStepIsImmutable::create($this->id, $step->position());
        }

        if (!$existingStep->equals($step)) {
            $existingStep->copyFrom($step);
            $this->record(OrderStepsUpdated::create($this));
        }
    }

    /**
     * @param ArrayCollection $givenSteps
     * @throws AnExecutedStepIsImmutable
     */
    private function removeStepsNotIn(ArrayCollection $givenSteps): void
    {
        foreach ($this->steps as $step) {
            $exists = $givenSteps->exists(function (int $key, Step $givenStep) use ($step) {
                return $givenStep->position()->equals($step->position());
            });

            if (!$exists) {
                if ($step->hasBeenExecuted()) {
                    throw AnExecutedStepIsImmutable::create($this->id, $step->position());
                }

                $this->steps->removeElement($step);
                $this->record(OrderStepsUpdated::create($this));
            }
        }
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
     * @return CreatedAt
     */
    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }
}
