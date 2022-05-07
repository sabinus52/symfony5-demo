<?php

namespace App\EventSubscriber;

use App\Model\MenuItem;
use Olix\BackOfficeBundle\Model\MenuItemModel;
use Olix\BackOfficeBundle\Event\SidebarMenuEvent;
use Olix\BackOfficeBundle\EventSubscriber\MenuFactorySubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class MenuBuilderSubscriber extends MenuFactorySubscriber
{

    /**
     * @return array
     */
    /*public static function getSubscribedEvents(): array
    {
        return [
            SidebarMenuEvent::class => ['onSetupNavbar', 100],
            //BreadcrumbMenuEvent::class => ['onSetupNavbar', 100],
        ];
    }*/

    public function build(SidebarMenuEvent $event): void
    {
        $child1 = new MenuItem('home', [
            'label'         => 'Tableau de bord',
            'route'         => 'home',
            'routeArgs'     => array('param1' => 1, 'param2' => 'toto'),
            'icon'          => 'ico1.png',
            'badge'         => 'badge1',
            'color'         => 'red',
        ]);

        



        $child2 = new MenuItem('child2', [
            'label'         => 'Child two',
            'icon'          => 'ico2.png',
            'badge'         => 'badge2',
        ]);
        //$child2->setIsActive(true);
        $c21 = new MenuItem('c21', [
            'label'         => 'Child C21',
            'route'         => 'toto',
            'icon'          => 'ico1.png',
            'badge'         => 'badge1',
        ]);
        //$c21->setIsActive(true);
        
        $m = [];
        $menus = $this->entityManager->getRepository('App:Menu')->findAll();
        foreach ($menus as $key => $menu) {
            $m[$key] = new MenuItem( 'em'.$menu->getId() , [
                'label' => $menu->getLabel(),
                'route' => 'home2'.$menu->getId(),
            ]);
            ///if ($key == 0) $m[$key]->setIsActive(true);
            $c21->addChild($m[$key]);
        }
        $child2->addChild($c21);

        $childi = new MenuItem('c21', [
            'label'         => 'SÉPARATION',
        ]);

        $child3 = new MenuItem('child3', [
            'label'         => 'Child tree',
            'icon'          => 'ico3.png',
        ]);
        $child3->setIsActive(false);
        $c31 = new MenuItem('c31', [
            'label'         => 'Child 3 one',
            'route'         => 'home31',
            'routeArgs'     => array('param1' => 31, 'param2' => 'titi'),
        ]);
        $c32 = new MenuItem('c32', []);
        $c32
            ->setLabel('Child C32')
            ->setRoute('home32')
            ->setRouteArgs(array('param1' => 32, 'param2' => 'titi'))
            ->setIcon('icon32.png')
            ->setBadge(null)
            ->setIsActive(false);
        $child3->addChild($c31)->addChild($c32);
        $event
            ->addItem($child1)
            ->addItem($child2)
            ->addItem($childi)
            ->addItem($child3);
        //$m[0]->setIsActive(true);
    }

    

}
