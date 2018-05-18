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
use App\Domain\Group\Model\Name;
use Prooph\EventSourcing\AggregateChanged;

class GroupUpdated extends AggregateChanged
{
    public static function withData(GroupId $groupId, Name $name): self
    {
        return self::occur($groupId->id(), ['name' => $name->value()]);
    }

    public function id(): GroupId
    {
        return new GroupId($this->aggregateId());
    }

    public function name(): Name
    {
        return new Name($this->payload()['name']);
    }
}
