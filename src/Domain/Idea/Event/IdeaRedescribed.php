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

use App\Domain\Idea\Model\IdeaDescription;
use App\Domain\Idea\Model\IdeaId;
use Prooph\EventSourcing\AggregateChanged;

class IdeaRedescribed extends AggregateChanged
{
    public static function withData(IdeaId $ideaId, IdeaDescription $ideaDescription): self
    {
        return self::occur($ideaId->value(), [
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
