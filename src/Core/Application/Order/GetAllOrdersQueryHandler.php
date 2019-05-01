<?php
declare(strict_types=1);

namespace Core\Application\Order;

use Core\Domain\Order\Order;
use Core\Domain\Order\OrderRepository;
use Core\Domain\User\UserId;

class GetAllOrdersQueryHandler
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
     * GetAllOrdersQueryHandler constructor.
     *
     * @param OrderRepository   $repository
     * @param OrderDtoAssembler $dtoAssembler
     */
    public function __construct(OrderRepository $repository, OrderDtoAssembler $dtoAssembler)
    {
        $this->repository   = $repository;
        $this->dtoAssembler = $dtoAssembler;
    }

    public function __invoke(GetAllOrders $query): array
    {
        $userId = new UserId($query->userId());
        $orders = $this->repository->ordersOfUserId($userId);

        return array_map(function (Order $order) {
            return $this->dtoAssembler->writeDto($order);
        }, $orders);
    }
}
