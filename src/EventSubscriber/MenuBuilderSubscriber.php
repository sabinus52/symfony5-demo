<?php

declare(strict_types=1);

/**
 *  This file is part of OlixBackOfficeBundle.
 *  (c) Sabinus52 <sabinus52@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\EventSubscriber;

use App\Entity\Menu;
use App\Model\MenuItem;
use Olix\BackOfficeBundle\Event\SidebarMenuEvent;
use Olix\BackOfficeBundle\EventSubscriber\MenuFactorySubscriber;

/**
 * Event sur la construction du menu.
 */
class MenuBuilderSubscriber extends MenuFactorySubscriber
{
    public function build(SidebarMenuEvent $event): void
    {
        $child1 = new MenuItem('home', [
            'label' => 'Tableau de bord',
            'route' => 'home',
            'routeArgs' => ['param1' => 1, 'param2' => 'toto'],
            'icon' => 'ico1.png',
            'badge' => 'badge1',
            'color' => 'red',
        ]);

        $form = new MenuItem('form', [
            'label' => 'Formulaires',
        ]);
        $form
            ->addChild(new MenuItem('form-vert', [
                'label' => 'Forms vertical',
                'route' => 'forms_vertical',
            ]))
            ->addChild(new MenuItem('form-horz', [
                'label' => 'Forms horizontal',
                'route' => 'forms_horizontal',
            ]))
            ->addChild(new MenuItem('form-test', [
                'label' => 'Forms test',
                'route' => 'forms_test',
            ]))
            ->addChild(new MenuItem('form-modal', [
                'label' => 'Forms modal',
                'route' => 'forms_modal',
            ]))
        ;

        $table = new MenuItem('table', [
            'label' => 'Tables',
        ]);
        $table
            ->addChild(new MenuItem('table-server', [
                'label' => 'Liste des serveurs',
                'route' => 'table_server_list',
            ]))
            ->addChild(new MenuItem('table-adrip', [
                'label' => 'Liste des IPs',
                'route' => 'table_adrip__list',
            ]))
        ;

        $child2 = new MenuItem('child2', [
            'label' => 'Child two',
            'icon' => 'ico2.png',
            'badge' => 'badge2',
        ]);
        // $child2->setIsActive(true);
        $c21 = new MenuItem('c21', [
            'label' => 'Child C21',
            'route' => 'toto',
            'icon' => 'ico1.png',
            'badge' => 'badge1',
        ]);
        // $c21->setIsActive(true);

        $mmenu = [];
        $menus = $this->entityManager->getRepository(Menu::class)->findAll();
        foreach ($menus as $key => $menu) {
            $mmenu[$key] = new MenuItem('em'.$menu->getId(), [
                'label' => $menu->getLabel(),
                'route' => 'home2'.$menu->getId(),
            ]);
            // /if ($key == 0) $m[$key]->setIsActive(true);
            $c21->addChild($mmenu[$key]);
        }
        $child2->addChild($c21);

        $childi = new MenuItem('c21', [
            'label' => 'SÉPARATION',
        ]);

        $child3 = new MenuItem('child3', [
            'label' => 'Child tree',
            'icon' => 'ico3.png',
        ]);
        $child3->setIsActive(false);
        $c31 = new MenuItem('c31', [
            'label' => 'Child 3 one',
            'route' => 'home31',
            'routeArgs' => ['param1' => 31, 'param2' => 'titi'],
        ]);
        $c32 = new MenuItem('c32', []);
        $c32
            ->setLabel('Child C32')
            ->setRoute('home32')
            ->setRouteArgs(['param1' => 32, 'param2' => 'titi'])
            ->setIcon('icon32.png')
            ->setBadge(null)
            ->setIsActive(false)
        ;
        $child3->addChild($c31)->addChild($c32);
        $login = new MenuItem('login', [
            'label' => 'Login',
            'route' => 'olix_login',
        ]);
        $event
            ->addItem($child1)
            ->addItem($form)
            ->addItem($table)
            ->addItem($child2)
            ->addItem($childi)
            ->addItem($child3)
            ->addItem($login)
        ;
        // $m[0]->setIsActive(true);
    }
}
