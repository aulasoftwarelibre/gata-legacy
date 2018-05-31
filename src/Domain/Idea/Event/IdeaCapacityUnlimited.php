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

namespace App\Domain\Idea\Event;

use App\Domain\Idea\Model\IdeaId;
use Prooph\EventSourcing\AggregateChanged;

final class IdeaCapacityUnlimited extends AggregateChanged
{
    public static function withData(IdeaId $ideaId): self
    {
        return self::occur($ideaId->value());
    }

    public function ideaId(): IdeaId
    {
        return new IdeaId($this->aggregateId());
    }
}
