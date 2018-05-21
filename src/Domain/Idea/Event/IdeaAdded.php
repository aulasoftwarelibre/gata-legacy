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

class IdeaAdded extends AggregateChanged
{
    public static function withData(IdeaId $ideaId, string $title, string $description): self
    {
        return self::occur($ideaId->id(), [
            'title' => $title,
            'description' => $description,
        ]);
    }

    public function ideaId(): IdeaId
    {
        return new IdeaId($this->aggregateId());
    }

    public function title(): string
    {
        return $this->payload()['title'];
    }

    public function description(): string
    {
        return $this->payload()['description'];
    }
}
