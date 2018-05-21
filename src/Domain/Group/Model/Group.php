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

namespace App\Domain\Group\Model;

use App\Domain\AggregateRoot;
use App\Domain\Group\Event\GroupAdded;
use App\Domain\Group\Event\GroupUpdated;

final class Group extends AggregateRoot
{
    /**
     * @var GroupId
     */
    private $groupId;

    /**
     * @var GroupName
     */
    private $groupName;

    public static function add(GroupId $groupId, GroupName $groupName): self
    {
        $group = new self();

        $group->recordThat(GroupAdded::withData($groupId, $groupName));

        return $group;
    }

    public function __toString(): string
    {
        return $this->groupName()->name();
    }

    public function groupId(): GroupId
    {
        return $this->groupId;
    }

    public function groupName(): GroupName
    {
        return $this->groupName;
    }

    public function changeGroupName(GroupName $groupName): void
    {
        $this->recordThat(GroupUpdated::withData($this->groupId(), $groupName));
    }

    protected function aggregateId(): string
    {
        return $this->groupId()->id();
    }

    protected function applyGroupAdded(GroupAdded $event): void
    {
        $this->groupId = $event->groupId();
        $this->groupName = $event->groupName();
    }

    protected function applyGroupUpdated(GroupUpdated $event): void
    {
        $this->groupName = $event->groupName();
    }
}
