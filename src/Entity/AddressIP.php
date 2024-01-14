<?php

declare(strict_types=1);

/**
 *  This file is part of OlixBackOfficeBundle.
 *  (c) Sabinus52 <sabinus52@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\Entity;

use App\Repository\AddressIPRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AddressIP.
 *
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
#[ORM\Table(name: 'addressip')]
#[ORM\Entity(repositoryClass: AddressIPRepository::class)]
class AddressIP implements \Stringable
{
    /**
     * Constantes des différents statuts.
     */
    final public const STATUS_FREE = 0;
    final public const STATUS_BUSY = 1;
    final public const STATUS_BOOK = 2;
    final public const STATUS_UNAV = 3;

    /**
     * Liste des différents statuts.
     *
     * @var array<mixed>
     */
    protected static $states = [
        self::STATUS_FREE => ['color' => 'success', 'label' => 'Libre'],
        self::STATUS_BUSY => ['color' => 'danger',  'label' => 'Occupée'],
        self::STATUS_BOOK => ['color' => 'warning', 'label' => 'Réservée'],
        self::STATUS_UNAV => ['color' => 'default', 'label' => 'Non dispo'],
    ];

    /**
     * @var int
     */
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private $id; /** @phpstan-ignore-line */
    /**
     * Adresse IP.
     *
     * @var string
     */
    #[ORM\Column(name: 'ip', type: 'string', unique: true, length: 20)]
    #[Assert\Ip]
    private $ip;

    /**
     * Hostname correspondant à l'IP.
     *
     * @var string
     */
    #[ORM\Column(name: 'hostname', type: 'string', nullable: true, length: 255)]
    #[Assert\Regex('/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$/')]
    private $hostname;

    /**
     * Numéro pour le tri.
     *
     * @var int
     */
    #[ORM\Column(name: 'number', type: 'smallint')]
    private $number;

    /**
     * Statut si alloué ou pas.
     *
     * @var int
     */
    #[ORM\Column(name: 'state', type: 'integer')]
    private $state;

    /**
     * Notes et commentaire.
     *
     * @var string
     */
    #[ORM\Column(name: 'comment', type: 'string', length: 2000, nullable: true)]
    private $comment;

    /**
     * Si reponse au ping au pas.
     *
     * @var bool
     */
    #[ORM\Column(name: 'ping', type: 'boolean', options: ['default' => false])]
    private $ping;

    /**
     * Si reponse au ping au pas avec le hostname.
     *
     * @var bool
     */
    #[ORM\Column(name: 'fqdn', type: 'boolean', options: ['default' => false])]
    private $fqdn;

    /**
     * Liaison avec les serveurs //, cascade={"persist"}, mappedBy="addressIPs".
     *
     * @var Server
     */
    #[ORM\ManyToOne(targetEntity: Server::class, cascade: ['persist'], inversedBy: 'addressIPs')]
    private $server;

    /**
     * Retourne la liste des status.
     *
     * @param string $field : Nom du champs à retourner
     *
     * @return array<mixed>
     */
    public static function getStates($field = null): array
    {
        if (!$field) {
            return self::$states;
        }
        $result = [];
        foreach (self::$states as $key => $state) {
            if (!isset($state[$field])) {
                throw new \ErrorException("Le champs \"{$field}\" n'existe pas dans la propriété \"states\" de l'entité \"AddressIP\"");
            }
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
        $this->state = self::STATUS_FREE;
        $this->ping = false;
        $this->fqdn = false;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "{$this->ip}";
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ip.
     *
     * @param string $ip
     *
     * @return AddressIP
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip.
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Get ip and host.
     *
     * @return string
     */
    public function getIpAndHost()
    {
        return "{$this->ip} ({$this->hostname})";
    }

    /**
     * Set hostname.
     *
     * @param string $hostname
     *
     * @return AddressIP
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;

        return $this;
    }

    /**
     * Get hostname.
     *
     * @return string
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * Set number.
     *
     * @param int $number
     *
     * @return AddressIP
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number.
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set state.
     *
     * @param int $state
     *
     * @return AddressIP
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state.
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Get label of state.
     *
     * @return int
     */
    public function getStateLabel()
    {
        return self::$states[$this->state]['label'];
    }

    /**
     * Get color of state.
     *
     * @return int
     */
    public function getStateColor()
    {
        return self::$states[$this->state]['color'];
    }

    /**
     * Set comment.
     *
     * @param string $comment
     *
     * @return AddressIP
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment.
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set ping.
     *
     * @param bool $ping
     *
     * @return AddressIP
     */
    public function setPing($ping)
    {
        $this->ping = $ping;

        return $this;
    }

    /**
     * Get ping.
     *
     * @return bool
     */
    public function isPing()
    {
        return $this->ping;
    }

    /**
     * Set fqdn.
     *
     * @param bool $fqdn
     *
     * @return AddressIP
     */
    public function setFqdn($fqdn)
    {
        $this->fqdn = $fqdn;

        return $this;
    }

    /**
     * Get fqdn.
     *
     * @return bool
     */
    public function isFqdn()
    {
        return $this->fqdn;
    }

    /**
     * Set server.
     *
     * @return AddressIP
     */
    public function setServer(Server $server = null): self
    {
        $this->server = $server;

        return $this;
    }

    /**
     * Get server.
     *
     * @return Server
     */
    public function getServer(): Server
    {
        return $this->server;
    }
}
