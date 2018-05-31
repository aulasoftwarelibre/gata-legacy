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

namespace App\Domain\Group\Event;

use App\Domain\Group\Model\GroupId;
use App\Domain\Group\Model\GroupName;
use Prooph\EventSourcing\AggregateChanged;

final class GroupNameChanged extends AggregateChanged
{
    public static function withData(GroupId $groupId, GroupName $groupName): self
    {
        return self::occur($groupId->value(), [
            'name' => $groupName->value(),
        ]);
    }

    public function groupId(): GroupId
    {
        return new GroupId($this->aggregateId());
    }

    public function name(): GroupName
    {
        return new GroupName($this->payload()['name']);
    }
}
