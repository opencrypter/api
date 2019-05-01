<?php
declare(strict_types=1);

namespace Core\Infrastructure\EventSubscriber\Symfony;

use Core\Infrastructure\Security\UserCredentials;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class JwtEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'lexik_jwt_authentication.on_jwt_created' => 'onJwtCreated',
        ];
    }

    public function onJwtCreated(JWTCreatedEvent $event): void
    {
        $data = $event->getData();
        /** @var UserCredentials $user */
        $user = $event->getUser();
        $data['id'] = $user->getId();
        $event->setData($data);
    }
}
