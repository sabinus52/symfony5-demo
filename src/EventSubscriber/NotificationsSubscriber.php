<?php

namespace App\EventSubscriber;

use Olix\BackOfficeBundle\Model\NotificationModel;
use Olix\BackOfficeBundle\Event\NotificationsEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class NotificationsSubscriber implements EventSubscriberInterface
{

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            NotificationsEvent::class => ['onNotifications', 100],
        ];
    }


    /**
     * @param NotificationListEvent $event
     */
    public function onNotifications(NotificationsEvent $event)
    {
        # Déclaration des routes
        $event->setMax(4)->setRoute('notif_one')->SetRouteAll('notif_all');
        $notification = new NotificationModel('titi');
        $notification
            ->setMessage('A demo message')
            ->setColor('danger')
            ->setInfo('1 min');
        $event->addNotification($notification);

        $event->addNotification(new NotificationModel('tutu', ['message' => 'Message 2']));
        $event->addNotification(new NotificationModel(null, ['message' => 'Message 3', 'color' => 'info', 'icon' => 'far fa-flag']));
        $event->addNotification(new NotificationModel(null, ['message' => 'Message 4', 'color' => 'warning']));
        $event->addNotification(new NotificationModel(null, ['message' => 'Message 5', 'color' => 'info']));
        $event->addNotification(new NotificationModel(null, ['message' => 'Message 6', 'color' => 'success']));

        //$notification = new NotificationModel('You are logged-in!', Constants::TYPE_SUCCESS, 'fas fa-sign-in-alt');
        //$event->addNotification($notification);
    }

    

}
