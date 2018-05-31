<?php

/*
 * This file is part of the `gata` project.
 *
 * (c) Aula de Software Libre de la UCO <aulasoftwarelibre@uco.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Idea\Event;

use App\Domain\Idea\Model\IdeaDescription;
use App\Domain\Idea\Model\IdeaId;
use Prooph\EventSourcing\AggregateChanged;

class IdeaDescriptionChanged extends AggregateChanged
{
    public static function withData(IdeaId $ideaId, IdeaDescription $ideaDescription): self
    {
        return self::occur($ideaId->id(), [
            'description' => $ideaDescription->value(),
        ]);
    }

    public function ideaId(): IdeaId
    {
        return new IdeaId($this->aggregateId());
    }

    public function description(): IdeaDescription
    {
        return new IdeaDescription($this->payload()['description']);
    }
}
