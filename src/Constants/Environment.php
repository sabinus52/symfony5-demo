<?php

declare(strict_types=1);

/**
 *  This file is part of OlixBackOfficeBundle.
 *  (c) Sabinus52 <sabinus52@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\Constants;

/**
 * Liste des environment.
 *
 * @author Sabinus52 <sabinus52@gmail.com>
 */
class Environment
{
    public const PRODUCTION = 'X';
    public const MIXTEPROD = 'Z';
    public const PREPRODUCTION = 'B';
    public const QUALIFICATION = 'Q';
    public const DEVELOPPEMENT = 'D';
    public const INTEGRATION = 'I';
    public const FORMATION = 'F';
    public const RECETTE = 'R';
    public const BACASABLE = 'S';
    public const TEST = 'T';
    public const HORSPROD = 'Y';
    public const SECOURS = 'H';

    /**
     * Liste des environnements.
     *
     * @var array<array<string,string>>
     */
    protected static $environments = [
        self::PRODUCTION => ['color' => 'purple',   'label' => 'PRODUCTION'],
        self::MIXTEPROD => ['color' => 'purple',   'label' => 'MIXTE (AVEC PROD)'],
        self::PREPRODUCTION => ['color' => 'orange',   'label' => 'PRE-PRODUCTION'],
        self::QUALIFICATION => ['color' => 'blue',     'label' => 'QUALIFICATION'],
        self::DEVELOPPEMENT => ['color' => 'dark',     'label' => 'DEVELOPPEMENT'],
        self::INTEGRATION => ['color' => 'blue',     'label' => 'INTEGRATION'],
        self::FORMATION => ['color' => 'blue',     'label' => 'FORMATION'],
        self::RECETTE => ['color' => 'blue',     'label' => 'RECETTE'],
        self::BACASABLE => ['color' => 'dark',     'label' => 'BAC A SABLE'],
        self::TEST => ['color' => 'dark',     'label' => 'TEST'],
        self::HORSPROD => ['color' => 'blue',     'label' => 'MIXTE (TOUS SAUF PROD)'],
        self::SECOURS => ['color' => 'default',  'label' => 'SECOURS'],
    ];

    /**
     * Valeur de l'environnement.
     *
     * @var string
     */
    protected $value;

    /**
     * Retourne la liste pour le ChoiceType des formulaires.
     *
     * @return array<Environment>
     */
    public static function getChoices(): array
    {
        $result = [];

        foreach (array_keys(self::$environments) as $env) {
            $result[] = new self($env);
        }

        return $result;
    }

    /**
     * Retourne la liste pour le filtre dasn les Datatables.
     *
     * @param string $field
     *
     * @return array<string>
     */
    public static function getFilters(string $field = 'label'): array
    {
        $result = [];

        foreach (self::$environments as $env => $array) {
            $result[$env] = $array[$field];
        }

        return $result;
    }

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getLabel(): string
    {
        return self::$environments[$this->value]['label'];
    }

    public function getColor(): string
    {
        return self::$environments[$this->value]['color'];
    }

    public function getBadge(): string
    {
        return '<span class="badge bg-'.$this->getColor().'">'.$this->getLabel().'</span>';
    }

    public function __toString()
    {
        return $this->getLabel();
    }
}
