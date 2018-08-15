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

namespace AulaSoftwareLibre\Gata\Infrastructure\ReadModel;

use Prooph\Bundle\EventStore\Projection\ReadModelProjection;
use Prooph\Common\Messaging\Message;
use Prooph\EventStore\Projection\ReadModelProjector;

abstract class AbstractReadModelProjector implements ReadModelProjection
{
    /**
     * @var string
     */
    private $streamName;

    public function __construct(string $streamName = 'event_stream')
    {
        $this->streamName = $streamName;
    }

    public function project(ReadModelProjector $projector): ReadModelProjector
    {
        return $projector
            ->fromStream($this->streamName)
            ->whenAny(function ($state, Message $event) {
                $this->readModel()->stack('apply', $event);
            })
        ;
    }
}
