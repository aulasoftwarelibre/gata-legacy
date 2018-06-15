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

namespace App\Infrastructure\Repository;

use App\Application\Idea\Exception\IdeaNotFoundException;
use App\Application\Idea\Repository\Ideas;
use App\Domain\Idea\Model\Idea;
use App\Domain\Idea\Model\IdeaId;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Ramsey\Uuid\Uuid;

final class EventStoreIdeas extends AggregateRepository implements Ideas
{
    public function save(Idea $idea): void
    {
        $this->saveAggregateRoot($idea);
    }

    public function get(IdeaId $ideaId): ?Idea
    {
        $idea = $this->getAggregateRoot($ideaId->value());

        if (!$idea instanceof Idea) {
            throw new IdeaNotFoundException();
        }

        return $idea;
    }

    public function nextIdentity(): IdeaId
    {
        return new IdeaId(Uuid::uuid4()->toString());
    }
}
