<?php

declare(strict_types=1);

/**
 *  This file is part of OlixBackOfficeBundle.
 *  (c) Sabinus52 <sabinus52@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\EventSubscriber;

use Olix\BackOfficeBundle\Event\NotificationsEvent;
use Olix\BackOfficeBundle\Model\NotificationModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event pour l'affichage des notifications dans la barre de navigation.
 */
class NotificationsSubscriber implements EventSubscriberInterface
{
    /**
     * @return array<mixed>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            NotificationsEvent::class => ['onNotifications', 100],
        ];
    }

    /**
     * @param NotificationsEvent $event
     */
    public function onNotifications(NotificationsEvent $event): void
    {
        // Déclaration des routes
        $event->setMax(4)->setRoute('notif_one')->SetRouteAll('notif_all');
        $notification = new NotificationModel('titi');
        $notification
            ->setMessage('A demo message')
            ->setColor('danger')
            ->setInfo('1 min')
        ;
        $event->addNotification($notification);

        $event->addNotification(new NotificationModel('tutu', ['message' => 'Message 2']));
        $event->addNotification(new NotificationModel(null, ['message' => 'Message 3', 'color' => 'info', 'icon' => 'far fa-flag']));
        $event->addNotification(new NotificationModel(null, ['message' => 'Message 4', 'color' => 'warning']));
        $event->addNotification(new NotificationModel(null, ['message' => 'Message 5', 'color' => 'info']));
        $event->addNotification(new NotificationModel(null, ['message' => 'Message 6', 'color' => 'success']));

        // $notification = new NotificationModel('You are logged-in!', Constants::TYPE_SUCCESS, 'fas fa-sign-in-alt');
        // $event->addNotification($notification);
    }
}
