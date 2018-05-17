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
use App\Domain\User\Model\UserId;
use Prooph\EventSourcing\AggregateChanged;

class IdeaVoted extends AggregateChanged
{
    public static function withData(IdeaId $ideaId, UserId $userId): self
    {
        return self::occur($ideaId->id(), [
            'userId' => $userId->id(),
        ]);
    }

    public function ideaId(): IdeaId
    {
        return new IdeaId($this->aggregateId());
    }

    public function userId(): UserId
    {
        return new UserId($this->payload()['userId']);
    }
}
