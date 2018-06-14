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

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Group\Model\GroupId;
use App\Infrastructure\ReadModel\Group\Repository\GroupViews;
use App\Infrastructure\ReadModel\Group\View\GroupView;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class GroupViewORMRepository extends ServiceEntityRepository implements GroupViews
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupView::class);
    }

    public function add(GroupView $groupView): void
    {
        $this->_em->persist($groupView);
    }

    public function get(GroupId $groupId): GroupView
    {
        return $this->find($groupId->value());
    }

    public function save(): void
    {
        $this->_em->flush();
    }
}
