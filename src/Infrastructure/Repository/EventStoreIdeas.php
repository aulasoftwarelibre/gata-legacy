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

namespace AulaSoftwareLibre\Gata\Infrastructure\Repository;

use AulaSoftwareLibre\Gata\Application\Idea\Exception\IdeaNotFoundException;
use AulaSoftwareLibre\Gata\Application\Idea\Repository\Ideas;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\Idea;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId;
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
        $idea = $this->getAggregateRoot($ideaId->toString());

        if (!$idea instanceof Idea) {
            throw new IdeaNotFoundException();
        }

        return $idea;
    }

    public function nextIdentity(): IdeaId
    {
        return IdeaId::fromString(Uuid::uuid4()->toString());
    }
}
