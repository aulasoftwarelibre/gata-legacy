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

use App\Application\Group\Command\AddGroup;
use App\Domain\Group\Event\GroupAdded;
use App\Domain\Group\Model\GroupId;
use App\Domain\Group\Model\GroupName;
use Behat\Behat\Context\Context;
use Prooph\ServiceBus\CommandBus;
use Ramsey\Uuid\Uuid;
use Tests\Service\Prooph\Plugin\EventsRecorder;
use Webmozart\Assert\Assert;

class GroupContext implements Context
{
    /**
     * @var CommandBus
     */
    private $commandBus;
    /**
     * @var EventsRecorder
     */
    private $eventsRecorder;

    public function __construct(
        CommandBus $commandBus,
        EventsRecorder $eventsRecorder
    ) {
        $this->commandBus = $commandBus;
        $this->eventsRecorder = $eventsRecorder;
    }

    /**
     * @When I add a new group called :groupName
     */
    public function iAddANewGroupCalled($groupName): void
    {
        $this->commandBus->dispatch(
            AddGroup::create(new GroupId(Uuid::uuid4()->toString()), new GroupName($groupName))
        );
    }

    /**
     * @Then the group :groupName should be available in the list
     */
    public function theGroupShouldBeAvailableInTheList(string $groupName): void
    {
        $message = $this->eventsRecorder->getLastMessage();

        /** @var GroupAdded $event */
        $event = $message->event();
        Assert::isInstanceOf($event, GroupAdded::class, sprintf(
            'Event has to be of class %s, but %s given',
            GroupAdded::class,
            get_class($event)
        ));
        Assert::eq($event->name(), new GroupName($groupName));
    }
}
