<?php

declare(strict_types=1);

/**
 *  This file is part of OlixBackOfficeBundle.
 *  (c) Sabinus52 <sabinus52@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\Model;

use Olix\BackOfficeBundle\Model\MenuItemInterface;
use Olix\BackOfficeBundle\Model\MenuItemModel;

/**
 * Surcharge de la classe Menu en rajoutant de la couleur.
 */
class MenuItem extends MenuItemModel
{
    /**
     * @var string
     */
    protected $color;

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
     *
     * @return MenuItemInterface
     */
    public function setColor(string $color): MenuItemInterface
    {
        $this->color = $color;

        return $this;
    }
}
