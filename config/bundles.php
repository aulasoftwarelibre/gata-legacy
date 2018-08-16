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

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Prooph\Bundle\EventStore\ProophEventStoreBundle::class => ['all' => true],
    Prooph\Bundle\ServiceBus\ProophServiceBusBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => true],
    AulaSoftwareLibre\DDD\BaseBundle\BaseBundle::class => ['all' => true],
    AulaSoftwareLibre\DDD\TestsBundle\TestBundle::class => ['test' => true],
];
