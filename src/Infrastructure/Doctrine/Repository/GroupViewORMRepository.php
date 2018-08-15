<?php

declare(strict_types=1);

/*
 * This file is part of the `gata` project.
 *
 * (c) Aula de Software Libre de la UCO <aulasoftwarelibre@uco.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AulaSoftwareLibre\Gata\Infrastructure\Doctrine\Repository;

use AulaSoftwareLibre\Gata\Infrastructure\Doctrine\SchemaManagerORMTrait;
use AulaSoftwareLibre\Gata\Infrastructure\ReadModel\Group\Repository\GroupViews;
use AulaSoftwareLibre\Gata\Infrastructure\ReadModel\Group\View\GroupView;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class GroupViewORMRepository extends ServiceEntityRepository implements GroupViews
{
    use SchemaManagerORMTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupView::class);
    }

    public function add(GroupView $groupView): void
    {
        $this->_em->persist($groupView);
        $this->_em->flush();
    }

    public function get(string $groupId): GroupView
    {
        return $this->find($groupId);
    }

    public function rename(string $groupId, string $newName): void
    {
        $qb = $this->createQueryBuilder('o');

        $qb->update()
            ->set('o.name', ':name')
            ->where('o.id = :id')
            ->setParameters([
                'id' => $groupId,
                'name' => $newName,
            ])
            ->getQuery()
            ->execute()
        ;
    }
}
