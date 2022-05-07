<?php
/**
 * Classe de chaque élément composant la menu de la barre latérale
 * 
 * @author Olivier <sabinus52@gmail.com>
 * @package Olix
 * @subpackage BackOfficeBundle
 */

namespace App\Model;

use Olix\BackOfficeBundle\Model\MenuItemModel;


class MenuItem extends MenuItemModel
{

    

    /**
     * @var string
     */
    protected $color = null;


    public function __construct(string $code, array $options = [])
    {
        parent::__construct($code, $options);
        $this->color = (isset($options['color'])) ? $options['color'] : null;
    }



    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return MenuItemInterface
     */
    public function setColor(string $color): MenuItemInterface
    {
        $this->color = $color;
        return $this;
    }


}