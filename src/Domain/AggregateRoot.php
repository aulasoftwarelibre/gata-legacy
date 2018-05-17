<?php

/*
 * This file is part of the `gata` project.
 *
 * (c) Aula de Software Libre de la UCO <aulasoftwarelibre@uco.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain;

use Prooph\Common\Messaging\Message;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot as BaseAggregateRoot;

abstract class AggregateRoot extends BaseAggregateRoot
{
    protected function apply(AggregateChanged $event): void
    {
        $this->applyMessage($event);
    }

    protected function applyMessage(Message $event): void
    {
        $eventClass = get_class($event);
        $applyMethodName = mb_strtolower('apply'.mb_substr($eventClass, mb_strrpos($eventClass, '\\') + 1));
        $applyMethodNames = array_map(
            function (string $class): string {
                return mb_strtolower($class);
            },
            get_class_methods(static::class)
        );

        if (!in_array($applyMethodName, $applyMethodNames, true)) {
            return;
        }

        $this->$applyMethodName($event);
    }
}
