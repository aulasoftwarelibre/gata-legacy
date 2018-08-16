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

use AulaSoftwareLibre\DDD\TestsBundle\Service\Prooph\Plugin\EventsRecorder;
use AulaSoftwareLibre\DDD\TestsBundle\Service\SharedStorage;
use AulaSoftwareLibre\Gata\Application\Idea\Command\AcceptIdea;
use AulaSoftwareLibre\Gata\Application\Idea\Command\AddIdea;
use AulaSoftwareLibre\Gata\Application\Idea\Command\RedescribeIdea;
use AulaSoftwareLibre\Gata\Application\Idea\Command\RegisterIdeaAttendee;
use AulaSoftwareLibre\Gata\Application\Idea\Command\RejectIdea;
use AulaSoftwareLibre\Gata\Application\Idea\Command\RetitleIdea;
use AulaSoftwareLibre\Gata\Application\Idea\Command\UnregisterIdeaAttendee;
use AulaSoftwareLibre\Gata\Application\Idea\Repository\Ideas;
use AulaSoftwareLibre\Gata\Domain\Group\Model\GroupId;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaAttendeeWasRegistered;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaAttendeeWasUnregistered;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaWasAccepted;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaWasAdded;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaWasRedescribed;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaWasRejected;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaWasRetitled;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaDescription;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaTitle;
use Behat\Behat\Context\Context;
use Prooph\ServiceBus\CommandBus;
use Webmozart\Assert\Assert;

final class IdeaContext implements Context
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
    /**
     * @var Ideas
     */
    private $ideas;

    public function __construct(
        CommandBus $commandBus,
        EventsRecorder $eventsRecorder,
        SharedStorage $sharedStorage,
        Ideas $ideas
    ) {
        $this->commandBus = $commandBus;
        $this->eventsRecorder = $eventsRecorder;
        $this->sharedStorage = $sharedStorage;
        $this->ideas = $ideas;
    }

    /**
     * @When /^I add a new idea titled "([^"]*)" with any description to (this group)$/
     */
    public function iAddANewIdeaTitledWithAnyDescriptionToThisGroup(string $title, GroupId $groupId): void
    {
        $this->commandBus->dispatch(AddIdea::with(
            $this->ideas->nextIdentity(),
            $groupId,
            IdeaTitle::fromString($title),
            IdeaDescription::fromString('Description')
        ));
    }

    /**
     * @Then /^the idea "([^"]*)" should be available in (this group)$/
     */
    public function theIdeaShouldBeAvailableInThisGroup(string $title, GroupId $groupId): void
    {
        /** @var IdeaWasAdded $event */
        $event = $this->eventsRecorder->getLastMessage()->event();

        Assert::isInstanceOf($event, IdeaWasAdded::class, sprintf(
            'Event has to be of class %s, but %s given',
            IdeaWasAdded::class,
            get_class($event)
        ));

        Assert::true($event->groupId()->equals($groupId));
        Assert::true($event->title()->equals(IdeaTitle::fromString($title)));
    }

    /**
     * @When /^I retitle (it) to "([^"]*)"$/
     */
    public function iRetitleItTo(IdeaId $ideaId, string $title): void
    {
        $this->commandBus->dispatch(RetitleIdea::with(
            $ideaId,
            IdeaTitle::fromString($title)
        ));
    }

    /**
     * @Then /^(it) should be retitled to "([^"]*)"$/
     */
    public function itShouldBeRetitledTo(IdeaId $ideaId, string $title): void
    {
        /** @var IdeaWasRetitled $event */
        $event = $this->eventsRecorder->getLastMessage()->event();

        Assert::isInstanceOf($event, IdeaWasRetitled::class, sprintf(
            'Event has to be of class %s, but %s given',
            IdeaWasRetitled::class,
            get_class($event)
        ));

        Assert::true($event->ideaId()->equals($ideaId));
        Assert::true($event->title()->equals(IdeaTitle::fromString($title)));
    }

    /**
     * @When /^I accept (it)$/
     */
    public function iAcceptIt(IdeaId $ideaId): void
    {
        $this->commandBus->dispatch(AcceptIdea::with(
            $ideaId
        ));
    }

    /**
     * @When /^I reject (it)$/
     */
    public function iRejectIt(IdeaId $ideaId): void
    {
        $this->commandBus->dispatch(RejectIdea::with(
            $ideaId
        ));
    }

    /**
     * @Then /^(it) should be marked as accepted$/
     */
    public function itShouldBeMarkedAsAccepted(IdeaId $ideaId): void
    {
        /** @var IdeaWasAccepted $event */
        $event = $this->eventsRecorder->getLastMessage()->event();

        Assert::isInstanceOf($event, IdeaWasAccepted::class, sprintf(
            'Event has to be of class %s, but %s given',
            IdeaWasAccepted::class,
            get_class($event)
        ));

        Assert::true($event->ideaId()->equals($ideaId));
    }

    /**
     * @Then /^(it) should be marked as rejected$/
     */
    public function itShouldBeMarkedAsRejected(IdeaId $ideaId): void
    {
        /** @var IdeaWasRejected $event */
        $event = $this->eventsRecorder->getLastMessage()->event();

        Assert::isInstanceOf($event, IdeaWasRejected::class, sprintf(
            'Event has to be of class %s, but %s given',
            IdeaWasRejected::class,
            get_class($event)
        ));

        Assert::true($event->ideaId()->equals($ideaId));
    }

    /**
     * @When /^I redescribe (it) to "([^"]*)"$/
     */
    public function iRedescribeItTo(IdeaId $ideaId, string $description): void
    {
        $this->commandBus->dispatch(RedescribeIdea::with(
            $ideaId,
            IdeaDescription::fromString($description)
        ));
    }

    /**
     * @Then /^(it) should be redescribed to "([^"]*)"$/
     */
    public function itShouldBeRedescribedTo(IdeaId $ideaId, string $description): void
    {
        /** @var IdeaWasRedescribed $event */
        $event = $this->eventsRecorder->getLastMessage()->event();

        Assert::isInstanceOf($event, IdeaWasRedescribed::class, sprintf(
            'Event has to be of class %s, but %s given',
            IdeaWasRedescribed::class,
            get_class($event)
        ));

        Assert::true($event->ideaId()->equals($ideaId));
        Assert::true($event->description()->equals(IdeaDescription::fromString($description)));
    }

    /**
     * @When /^I register me as attendee in (this idea)$/
     */
    public function iRegisterMeAsAttendeeInThisIdea(IdeaId $ideaId): void
    {
        $myUserId = $this->sharedStorage->get('myUserId');

        $this->commandBus->dispatch(RegisterIdeaAttendee::with(
            $ideaId,
            $myUserId
        ));
    }

    /**
     * @Then /^I have to be registered as attendee in (this idea)$/
     */
    public function iHaveToBeRegisteredAsAttendeeInThisIdea(IdeaId $ideaId): void
    {
        /** @var IdeaAttendeeWasRegistered $event */
        $event = $this->eventsRecorder->getLastMessage()->event();

        Assert::isInstanceOf($event, IdeaAttendeeWasRegistered::class, sprintf(
            'Event has to be of class %s, but %s given',
            IdeaAttendeeWasRegistered::class,
            get_class($event)
        ));

        $myUserId = $this->sharedStorage->get('myUserId');

        Assert::true($event->ideaId()->equals($ideaId));
        Assert::true($event->userId()->equals($myUserId));
    }

    /**
     * @When /^I unregister me as attendee from (this idea)$/
     */
    public function iUnregisterMeAsAttendeeFromThisIdea(IdeaId $ideaId)
    {
        $myUserId = $this->sharedStorage->get('myUserId');

        $this->commandBus->dispatch(UnregisterIdeaAttendee::with(
            $ideaId,
            $myUserId
        ));
    }

    /**
     * @Then /^I have to be unregistered as attendee in (this idea)$/
     */
    public function iHaveToBeUnregisteredAsAttendeeInThisIdea(IdeaId $ideaId)
    {
        /** @var IdeaAttendeeWasUnregistered $event */
        $event = $this->eventsRecorder->getLastMessage()->event();

        Assert::isInstanceOf($event, IdeaAttendeeWasUnregistered::class, sprintf(
            'Event has to be of class %s, but %s given',
            IdeaAttendeeWasUnregistered::class,
            get_class($event)
        ));

        $myUserId = $this->sharedStorage->get('myUserId');

        Assert::true($event->ideaId()->equals($ideaId));
        Assert::true($event->userId()->equals($myUserId));
    }
}
