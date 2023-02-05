<?php

declare(strict_types=1);

/**
 *  This file is part of OlixBackOfficeBundle.
 *  (c) Sabinus52 <sabinus52@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\Entity;

use App\Constants\Environment;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entité des serveurs.
 *
 * @ORM\Table(name="server")
 * @ORM\Entity(repositoryClass="App\Repository\ServerRepository")
 * @UniqueEntity(fields="hostname", message="Ce Hostname est déjà utilisé, merci d'en choisir un autre")
 * @UniqueEntity(fields="addrip", message="Cette IP est déjà utilisée, merci d'en choisir un autre")
 */
class Server
{
    /**
     * Constantes des différents statuts.
     */
    public const STATE_OFF = 0;
    public const STATE_ON = 1;
    public const STATE_DELETED = 9;

    /**
     * Liste des différents statuts.
     *
     * @var array<mixed>
     */
    private static $states = [
        self::STATE_OFF => ['color' => 'dark',  'label' => 'Eteint'],
        self::STATE_ON => ['color' => 'green', 'label' => 'Allumé'],
        self::STATE_DELETED => ['color' => 'red',   'label' => 'Supprimé'],
    ];

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id; /** @phpstan-ignore-line */

    /**
     * Nom court local du serveur.
     *
     * @var string
     *
     * @ORM\Column(name="hostname", type="string", unique=true, length=50)
     * @Assert\NotBlank
     * @Assert\Regex("/^([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*)$/")
     */
    private $hostname;

    /**
     * Valeur du FQDN = Reverse du DNS.
     *
     * @var string
     *
     * @ORM\Column(name="fqdn", type="string", unique=true, length=50)
     * @Assert\NotBlank
     * @Assert\Regex("/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$/")
     */
    private $fqdn;

    /**
     * Liaison avec les Adresses IPs.
     *
     * @var AddressIP
     *
     * @ORM\OneToOne(targetEntity="App\Entity\AddressIP")
     */
    private $addrip;

    /**
     * Liaison avec les serveurs.
     *
     * @var ArrayCollection<AddressIP>
     *
     * @ORM\OneToMany(targetEntity="App\Entity\AddressIP", cascade={"persist"}, mappedBy="server")
     */
    private $addressIPs;

    /**
     * @var bool
     *
     * @ORM\Column(name="virtual", type="boolean")
     */
    private $virtual;

    /**
     * @var Environment
     *
     * @ORM\Column(name="environment", type="environment", length=1)
     */
    private $environment;

    /**
     * Liaison avec les OS.
     *
     * @var OperatingSystem
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\OperatingSystem")
     * @ORM\JoinColumn(name="os_id", referencedColumnName="id")
     * @Assert\NotBlank
     */
    private $operatingSystem;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=500, nullable=true)
     */
    private $comment;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="smallint", nullable=true)
     */
    private $state;

    /**
     * Date de la suppression du serveur.
     *
     * @var DateTime
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * Retourne la liste des statuts.
     *
     * @param string $field : Nom du champs à retourner
     *
     * @return array<mixed>
     */
    public static function getStates(?string $field = null): array
    {
        if (!$field) {
            return self::$states;
        }
        $result = [];
        foreach (self::$states as $key => $state) {
            $result[$key] = $state[$field];
        }

        return $result;
    }

    /**
     * @return array<int>
     */
    public static function getChoiceStates(): array
    {
        $result = [];
        foreach (self::$states as $key => $state) {
            $result[$state['label']] = $key;
        }

        return $result;
    }

    /**
     * Constructeur.
     */
    public function __construct()
    {
        $this->addressIPs = new ArrayCollection();
        $this->state = self::STATE_ON;
        $this->virtual = true;
    }

    /**
     * Retourne le nom complet du serveur.
     *
     * @return string
     */
    public function __toString(): string
    {
        return "{$this->hostname}";
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
     * Set hostname.
     *
     * @param string $hostname
     *
     * @return Server
     */
    public function setHostname(string $hostname): self
    {
        $this->hostname = $hostname;

        return $this;
    }

    /**
     * Get hostname.
     *
     * @return string
     */
    public function getHostname(): string
    {
        return $this->hostname;
    }

    /**
     * Retourne le host et l'adresse IP.
     *
     * @return string
     */
    public function getHostAndIp(): string
    {
        if (null !== $this->addrip) {
            return $this->hostname.' ('.$this->addrip->getIp().')';
        }

        return $this->hostname;
    }

    /**
     * Set fqdn.
     *
     * @param string $fqdn
     *
     * @return Server
     */
    public function setFqdn(string $fqdn): self
    {
        $this->fqdn = $fqdn;

        return $this;
    }

    /**
     * Get fqdn.
     *
     * @return string
     */
    public function getFqdn(): string
    {
        return $this->fqdn;
    }

    /**
     * Set addrip.
     *
     * @param AddressIP $addrip
     *
     * @return Server
     */
    public function setAddrip(?AddressIP $addrip = null): self
    {
        $this->addrip = $addrip;

        return $this;
    }

    /**
     * Get addrip.
     *
     * @return AddressIP
     */
    public function getAddrip(): ?AddressIP
    {
        return $this->addrip;
    }

    /**
     * Add addressIPs.
     *
     * @param AddressIP $addressIPs
     *
     * @return Server
     */
    public function addAddressIP(AddressIP $addressIPs): self
    {
        if (!$this->addressIPs->contains($addressIPs)) {
            $this->addressIPs[] = $addressIPs;
        }

        return $this;
    }

    /**
     * Remove addressIPs.
     *
     * @param AddressIP $addressIPs
     */
    public function removeAddressIP(AddressIP $addressIPs): void
    {
        $this->addressIPs->removeElement($addressIPs);
    }

    /**
     * Get addressIPs.
     *
     * @return ArrayCollection
     */
    public function getAddressIPs()
    {
        return $this->addressIPs;
    }

    /**
     * Set deletedAt.
     *
     * @param DateTime $deletedAt
     *
     * @return Server
     */
    public function setDeletedAt(?DateTime $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt.
     *
     * @return DateTime
     */
    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }

    /**
     * Set virtual.
     *
     * @param bool $virtual
     *
     * @return Server
     */
    public function setVirtual(bool $virtual): self
    {
        $this->virtual = $virtual;

        return $this;
    }

    /**
     * Get virtual.
     *
     * @return bool
     */
    public function isVirtual(): bool
    {
        return $this->virtual;
    }

    /**
     * Set environment.
     *
     * @param Environment $environment
     *
     * @return Server
     */
    public function setEnvironment(Environment $environment): self
    {
        $this->environment = $environment;

        return $this;
    }

    /**
     * Get environment.
     *
     * @return Environment
     */
    public function getEnvironment(): ?Environment
    {
        return $this->environment;
    }

    /**
     * Set comment.
     *
     * @param string $comment
     *
     * @return Server
     */
    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment.
     *
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * Set state.
     *
     * @param int $state
     *
     * @return Server
     */
    public function setState(int $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state.
     *
     * @return int
     */
    public function getState(): int
    {
        return $this->state;
    }

    public function getStateLabel(): string
    {
        return self::$states[$this->state]['label'];
    }

    /**
     * Get state color.
     *
     * @return string
     */
    public function getStateColor(): string
    {
        return self::$states[$this->state]['color'];
    }

    /**
     * Set os.
     *
     * @param OperatingSystem $operatingSystem
     *
     * @return Server
     */
    public function setOperatingSystem(OperatingSystem $operatingSystem = null): self
    {
        $this->operatingSystem = $operatingSystem;

        return $this;
    }

    /**
     * Get operatingSystem.
     *
     * @return OperatingSystem
     */
    public function getOperatingSystem(): ?OperatingSystem
    {
        return $this->operatingSystem;
    }
}
