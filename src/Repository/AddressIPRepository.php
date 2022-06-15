<?php

declare(strict_types=1);

/**
 *  This file is part of OlixBackOfficeBundle.
 *  (c) Sabinus52 <sabinus52@gmail.com>
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\AddressIP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AddressIP>
 *
 * @method Menu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Menu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Menu[]    findAll()
 * @method Menu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddressIPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AddressIP::class);
    }

    public function findByIPLike(string $term, int $page): Paginator
    {
        $query = $this->createQueryBuilder('m')
            ->andWhere('m.ip LIKE :val')
            ->setParameter('val', '%'.$term.'%')
            ->orderBy('m.ip', 'ASC')
            ->setFirstResult($page * 10)
            ->setMaxResults(10)
            ->getQuery()
        ;

        return new Paginator($query, true);
    }
}
