<?php
declare(strict_types=1);

namespace Core\Infrastructure\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\Serializer\SerializerInterface;

class JwtEventListener
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * JwtEventSubscriber constructor.
     *
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function handle(JWTCreatedEvent $event): void
    {
        $data = $event->getData();
        /** @var UserCredentials $user */
        $user = $event->getUser();
        $data['id'] = $user->getId();
        $event->setData($data);
    }
}
