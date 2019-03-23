<?php
declare(strict_types=1);

namespace Core\Application\Order;

use Core\Domain\Order\OrderId;
use Core\Domain\Order\OrderRepository;
use Core\Domain\User\UserId;

class GetOrderQueryHandler
{
    /**
     * @var OrderRepository
     */
    private $repository;

    /**
     * @var OrderDtoAssembler
     */
    private $dtoAssembler;

    /**
     * GetOrderHandler constructor.
     *
     * @param OrderRepository   $repository
     * @param OrderDtoAssembler $dtoAssembler
     */
    public function __construct(OrderRepository $repository, OrderDtoAssembler $dtoAssembler)
    {
        $this->repository   = $repository;
        $this->dtoAssembler = $dtoAssembler;
    }


    /**
     * @param GetOrder $query
     * @return OrderDto
     * @throws OrderNotFound
     */
    public function __invoke(GetOrder $query): OrderDto
    {
        $orderId = new OrderId($query->id());
        $userId  = new UserId($query->userId());

        $order = $this->repository->orderOfId($orderId);

        if ($order === null) {
            throw OrderNotFound::create($orderId);
        }

        if (!$order->belongsTo($userId)) {
            throw new OrderDoesNotBelongToTheUser($orderId, $userId);
        }

        return $this->dtoAssembler->writeDto($order);
    }
}
