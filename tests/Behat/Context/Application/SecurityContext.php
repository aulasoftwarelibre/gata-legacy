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

namespace Tests\Behat\Context\Application;

use App\Domain\User\Model\UserId;
use Behat\Behat\Context\Context;
use Prooph\ServiceBus\CommandBus;
use Ramsey\Uuid\Uuid;
use Tests\Service\Prooph\Plugin\EventsRecorder;
use Tests\Service\SharedStorage;

final class SecurityContext implements Context
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var EventsRecorder
     */
    private $eventsRecorder;

    /**
     * @var SharedStorage
     */
    private $sharedStorage;

    public function __construct(
        CommandBus $commandBus,
        EventsRecorder $eventsRecorder,
        SharedStorage $sharedStorage
    ) {
        $this->commandBus = $commandBus;
        $this->eventsRecorder = $eventsRecorder;
        $this->sharedStorage = $sharedStorage;
    }

    /**
     * @Given /^I am logged in$/
     */
    public function iAmLoggedInAs(): void
    {
        $userId = new UserId(Uuid::uuid4()->toString());

        $this->sharedStorage->set('myUserId', $userId);
    }
}
