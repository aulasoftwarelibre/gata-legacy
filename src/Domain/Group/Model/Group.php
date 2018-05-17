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

class Group extends AggregateRoot
{
    /**
     * @var GroupId
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    public static function add(GroupId $groupId, string $name): self
    {
        $group = new self();

        $group->recordThat(GroupAdded::withData($groupId, $name));

        return $group;
    }

    public function id(): GroupId
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }

    public function changeName($name)
    {
        $this->recordThat(GroupUpdated::withData($this->id(), $name));
    }

    protected function aggregateId(): string
    {
        return $this->id()->id();
    }

    protected function applyGroupAdded(GroupAdded $event): void
    {
        $this->id = $event->id();
        $this->name = $event->name();
    }

    protected function applyGroupUpdated(GroupUpdated $event): void
    {
        $this->name = $event->name();
    }
}
