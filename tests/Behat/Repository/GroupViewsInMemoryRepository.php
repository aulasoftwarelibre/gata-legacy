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

namespace Tests\Behat\Repository;

use AulaSoftwareLibre\DDD\TestsBundle\Service\AbstractInMemoryRepository;
use AulaSoftwareLibre\Gata\Infrastructure\ReadModel\Repository\GroupViews;
use AulaSoftwareLibre\Gata\Infrastructure\ReadModel\View\GroupView;

class GroupViewsInMemoryRepository extends AbstractInMemoryRepository implements GroupViews
{
    /** @var GroupView[] */
    protected static $stack = [];

    public function __construct()
    {
        $this->groups = [];
    }

    public function add(GroupView $groupView): void
    {
        $this->_add($groupView->id(), $groupView);
    }

    public function ofId(string $groupId): GroupView
    {
        return $this->_ofId($groupId);
    }

    public function rename(string $groupId, string $newName): void
    {
        $groupView = $this->ofId($groupId);
        $groupView->rename($newName);
    }
}
