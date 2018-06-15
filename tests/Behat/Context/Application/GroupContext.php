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
use App\Application\Group\Command\RenameGroup;
use App\Application\Group\Repository\Groups;
use App\Domain\Group\Event\GroupAdded;
use App\Domain\Group\Event\GroupRenamed;
use App\Domain\Group\Model\GroupId;
use App\Domain\Group\Model\GroupName;
use Behat\Behat\Context\Context;
use Prooph\ServiceBus\CommandBus;
use Tests\Service\Prooph\Plugin\EventsRecorder;
use Webmozart\Assert\Assert;

final class GroupContext implements Context
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
     * @var Groups
     */
    private $groups;

    public function __construct(
        CommandBus $commandBus,
        EventsRecorder $eventsRecorder,
        Groups $groups
    ) {
        $this->commandBus = $commandBus;
        $this->eventsRecorder = $eventsRecorder;
        $this->groups = $groups;
    }

    /**
     * @When /^I add a new group named "([^"]*)"$/
     */
    public function iAddANewGroupNamed(string $name): void
    {
        $this->commandBus->dispatch(AddGroup::create(
            $this->groups->nextIdentity(),
            new GroupName($name)
        ));
    }

    /**
     * @Then /^the group "([^"]*)" should be available in the list$/
     */
    public function theGroupShouldBeAvailableInTheList(string $name): void
    {
        /** @var GroupAdded $event */
        $event = $this->eventsRecorder->getLastMessage()->event();

        Assert::isInstanceOf($event, GroupAdded::class, sprintf(
            'Event has to be of class %s, but %s given',
            GroupAdded::class,
            get_class($event)
        ));
        Assert::true($event->name()->equals(new GroupName($name)));
    }

    /**
     * @When /^I rename (it) to "([^"]*)"$/
     */
    public function iRenameItTo(GroupId $groupId, string $name): void
    {
        $this->commandBus->dispatch(RenameGroup::create(
            $groupId,
            new GroupName($name)
        ));
    }

    /**
     * @Then /^(it) should be renamed to "([^"]*)"$/
     */
    public function itShouldBeRenamedTo(GroupId $groupId, string $name): void
    {
        /** @var GroupRenamed $event */
        $event = $this->eventsRecorder->getLastMessage()->event();

        Assert::isInstanceOf($event, GroupRenamed::class, sprintf(
            'Event has to be of class %s, but %s given',
            GroupRenamed::class,
            get_class($event)
        ));
        Assert::true($event->groupId()->equals($groupId));
        Assert::true($event->name()->equals(new GroupName($name)));
    }
}
