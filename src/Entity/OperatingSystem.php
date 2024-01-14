<?php

declare(strict_types=1);

/**
 *  This file is part of OlixBackOfficeBundle.
 *  (c) Sabinus52 <sabinus52@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entité des systèmes d'exploitation.
 *
 * @ORM\Table(name="os")
 *
 * @ORM\Entity
 */
class OperatingSystem implements \Stringable
{
    /**
     * Liste des fabriquants.
     *
     * @var array<string>
     */
    protected static $vendors = [
        'Microsoft' => 'Microsoft',
        'Novell' => 'Novell',
        'Redhat' => 'Redhat',
        'Debian' => 'Debian',
        'HP' => 'HP',
        'VMware' => 'VMware',
        'IBM' => 'IBM',
        'EMC' => 'EMC',
        'Autre' => 'Autre',
    ];

    /**
     * Liste des famille d'OS.
     *
     * @var array<string>
     */
    protected static $families = [
        'Linux' => 'Linux',
        'Windows' => 'Windows',
        'Autre' => 'Autre',
    ];

    /**
     * Liste des tailles des bus.
     *
     * @var array<string>
     */
    protected static $bus = [
        32 => '32 bits',
        64 => '64 bits',
    ];

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     *
     * @ORM\Id
     *
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id; /** @phpstan-ignore-line */

    /**
     * Nom du fabriquant.
     *
     * @var string
     *
     * @ORM\Column(name="vendor", type="string", length=20)
     *
     * @Assert\NotBlank
     */
    private $vendor;

    /**
     * Famille de l'OS (Linux Windows).
     *
     * @var string
     *
     * @ORM\Column(name="family", type="string", length=20)
     *
     * @Assert\NotBlank
     */
    private $family;

    /**
     * Nom de l'OS (SLES 11, Server 2008).
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     *
     * @Assert\NotBlank
     *
     * @Assert\Length(max="50", maxMessage="Taille maximum de {{ limit }} caractères")
     */
    private $name;

    /**
     * Servicepack de l'OS (SP1 SP2).
     *
     * @var string
     *
     * @ORM\Column(name="service_pack", type="string", length=10, nullable=true)
     *
     * @Assert\Length(max="10", maxMessage="Taille maximum de {{ limit }} caractères")
     */
    private $servicePack;

    /**
     * Version de l'OS.
     *
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=20, nullable=true)
     *
     * @Assert\Length(max="20", maxMessage="Taille maximum de {{ limit }} caractères")
     */
    private $version;

    /**
     * Nombre de bus de l'OS.
     *
     * @var int
     *
     * @ORM\Column(name="bits", type="smallint")
     *
     * @Assert\NotBlank
     */
    private $bits;

    /**
     * Infos additionnel.
     *
     * @var string
     *
     * @ORM\Column(name="additional", type="string", length=50, nullable=true)
     *
     * @Assert\Length(max="50", maxMessage="Taille maximum de {{ limit }} caractères")
     */
    private $additional;

    /**
     * Fin du support.
     *
     * @var \DateTime
     *
     * @ORM\Column(name="support_end", type="date", nullable=true)
     */
    private $supportEnd;

    /**
     * Icone.
     *
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=20, nullable=true)
     */
    private $icon;

    /**
     * Retourne le nom complet de l'OS pour les formulaires entre autre.
     *
     * @return string
     */
    public function __toString(): string
    {
        return "{$this->name} ({$this->bits}) {$this->version} {$this->additional}";
    }

    /**
     * Retourne la liste des fabriquants.
     *
     * @return array<string>
     */
    public static function getVendors(): array
    {
        return self::$vendors;
    }

    /**
     * Retourne la liste des familles d'OS.
     *
     * @return array<string>
     */
    public static function getFamilies(): array
    {
        return self::$families;
    }

    /**
     * Retourne la liste des bus.
     *
     * @return array<string>
     */
    public static function getBus(): array
    {
        return self::$bus;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set vendor.
     *
     * @return OperatingSystem
     */
    public function setVendor(string $vendor): self
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * Get vendor.
     *
     * @return string
     */
    public function getVendor(): string
    {
        return $this->vendor;
    }

    /**
     * Set family.
     *
     * @return OperatingSystem
     */
    public function setFamily(string $family): self
    {
        $this->family = $family;

        return $this;
    }

    /**
     * Get family.
     *
     * @return string
     */
    public function getFamily(): string
    {
        return $this->family;
    }

    /**
     * Set name.
     *
     * @return OperatingSystem
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set servicePack.
     *
     * @param string $servicePack
     *
     * @return OperatingSystem
     */
    public function setServicePack(?string $servicePack): self
    {
        $this->servicePack = $servicePack;

        return $this;
    }

    /**
     * Get servicePack.
     *
     * @return string
     */
    public function getServicePack(): ?string
    {
        return $this->servicePack;
    }

    /**
     * Set version.
     *
     * @param string $version
     *
     * @return OperatingSystem
     */
    public function setVersion(?string $version): self
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version.
     *
     * @return string
     */
    public function getVersion(): ?string
    {
        return $this->version;
    }

    /**
     * Set bits.
     *
     * @return OperatingSystem
     */
    public function setBits(int $bits): self
    {
        $this->bits = $bits;

        return $this;
    }

    /**
     * Get bits.
     *
     * @return int
     */
    public function getBits(): ?int
    {
        return $this->bits;
    }

    /**
     * Set additional.
     *
     * @param string $additional
     *
     * @return OperatingSystem
     */
    public function setAdditional(?string $additional): self
    {
        $this->additional = $additional;

        return $this;
    }

    /**
     * Get additional.
     *
     * @return string
     */
    public function getAdditional(): ?string
    {
        return $this->additional;
    }

    /**
     * Set supportEnd.
     *
     * @param \DateTime $supportEnd
     *
     * @return OperatingSystem
     */
    public function setSupportEnd(?\DateTime $supportEnd): self
    {
        $this->supportEnd = $supportEnd;

        return $this;
    }

    /**
     * Get supportEnd.
     *
     * @return \DateTime
     */
    public function getSupportEnd(): ?\DateTime
    {
        return $this->supportEnd;
    }

    /**
     * Set icon.
     *
     * @return OperatingSystem
     */
    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon.
     *
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }
}
