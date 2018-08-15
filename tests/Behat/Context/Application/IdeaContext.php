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
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaAccepted;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaAdded;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaAttendeeRegistered;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaAttendeeUnregistered;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaRedescribed;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaRejected;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaRetitled;
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
        $this->commandBus->dispatch(AddIdea::create(
            $this->ideas->nextIdentity(),
            $groupId,
            new IdeaTitle($title),
            new IdeaDescription('Description')
        ));
    }

    /**
     * @Then /^the idea "([^"]*)" should be available in (this group)$/
     */
    public function theIdeaShouldBeAvailableInThisGroup(string $title, GroupId $groupId): void
    {
        /** @var IdeaAdded $event */
        $event = $this->eventsRecorder->getLastMessage()->event();

        Assert::isInstanceOf($event, IdeaAdded::class, sprintf(
            'Event has to be of class %s, but %s given',
            IdeaAdded::class,
            get_class($event)
        ));

        Assert::true($event->groupId()->equals($groupId));
        Assert::true($event->title()->equals(new IdeaTitle($title)));
    }

    /**
     * @When /^I retitle (it) to "([^"]*)"$/
     */
    public function iRetitleItTo(IdeaId $ideaId, string $title): void
    {
        $this->commandBus->dispatch(RetitleIdea::create(
            $ideaId,
            new IdeaTitle($title)
        ));
    }

    /**
     * @Then /^(it) should be retitled to "([^"]*)"$/
     */
    public function itShouldBeRetitledTo(IdeaId $ideaId, string $title): void
    {
        /** @var IdeaRetitled $event */
        $event = $this->eventsRecorder->getLastMessage()->event();

        Assert::isInstanceOf($event, IdeaRetitled::class, sprintf(
            'Event has to be of class %s, but %s given',
            IdeaRetitled::class,
            get_class($event)
        ));

        Assert::true($event->ideaId()->equals($ideaId));
        Assert::true($event->title()->equals(new IdeaTitle($title)));
    }

    /**
     * @When /^I accept (it)$/
     */
    public function iAcceptIt(IdeaId $ideaId): void
    {
        $this->commandBus->dispatch(AcceptIdea::create(
            $ideaId
        ));
    }

    /**
     * @When /^I reject (it)$/
     */
    public function iRejectIt(IdeaId $ideaId): void
    {
        $this->commandBus->dispatch(RejectIdea::create(
            $ideaId
        ));
    }

    /**
     * @Then /^(it) should be marked as accepted$/
     */
    public function itShouldBeMarkedAsAccepted(IdeaId $ideaId): void
    {
        /** @var IdeaAccepted $event */
        $event = $this->eventsRecorder->getLastMessage()->event();

        Assert::isInstanceOf($event, IdeaAccepted::class, sprintf(
            'Event has to be of class %s, but %s given',
            IdeaAccepted::class,
            get_class($event)
        ));

        Assert::true($event->ideaId()->equals($ideaId));
    }

    /**
     * @Then /^(it) should be marked as rejected$/
     */
    public function itShouldBeMarkedAsRejected(IdeaId $ideaId): void
    {
        /** @var IdeaRejected $event */
        $event = $this->eventsRecorder->getLastMessage()->event();

        Assert::isInstanceOf($event, IdeaRejected::class, sprintf(
            'Event has to be of class %s, but %s given',
            IdeaRejected::class,
            get_class($event)
        ));

        Assert::true($event->ideaId()->equals($ideaId));
    }

    /**
     * @When /^I redescribe (it) to "([^"]*)"$/
     */
    public function iRedescribeItTo(IdeaId $ideaId, string $description): void
    {
        $this->commandBus->dispatch(RedescribeIdea::create(
            $ideaId,
            new IdeaDescription($description)
        ));
    }

    /**
     * @Then /^(it) should be redescribed to "([^"]*)"$/
     */
    public function itShouldBeRedescribedTo(IdeaId $ideaId, string $description): void
    {
        /** @var IdeaRedescribed $event */
        $event = $this->eventsRecorder->getLastMessage()->event();

        Assert::isInstanceOf($event, IdeaRedescribed::class, sprintf(
            'Event has to be of class %s, but %s given',
            IdeaRedescribed::class,
            get_class($event)
        ));

        Assert::true($event->ideaId()->equals($ideaId));
        Assert::true($event->description()->equals(new IdeaDescription($description)));
    }

    /**
     * @When /^I register me as attendee in (this idea)$/
     */
    public function iRegisterMeAsAttendeeInThisIdea(IdeaId $ideaId): void
    {
        $myUserId = $this->sharedStorage->get('myUserId');

        $this->commandBus->dispatch(RegisterIdeaAttendee::create(
            $ideaId,
            $myUserId
        ));
    }

    /**
     * @Then /^I have to be registered as attendee in (this idea)$/
     */
    public function iHaveToBeRegisteredAsAttendeeInThisIdea(IdeaId $ideaId): void
    {
        /** @var IdeaAttendeeRegistered $event */
        $event = $this->eventsRecorder->getLastMessage()->event();

        Assert::isInstanceOf($event, IdeaAttendeeRegistered::class, sprintf(
            'Event has to be of class %s, but %s given',
            IdeaAttendeeRegistered::class,
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

        $this->commandBus->dispatch(UnregisterIdeaAttendee::create(
            $ideaId,
            $myUserId
        ));
    }

    /**
     * @Then /^I have to be unregistered as attendee in (this idea)$/
     */
    public function iHaveToBeUnregisteredAsAttendeeInThisIdea(IdeaId $ideaId)
    {
        /** @var IdeaAttendeeUnregistered $event */
        $event = $this->eventsRecorder->getLastMessage()->event();

        Assert::isInstanceOf($event, IdeaAttendeeUnregistered::class, sprintf(
            'Event has to be of class %s, but %s given',
            IdeaAttendeeUnregistered::class,
            get_class($event)
        ));

        $myUserId = $this->sharedStorage->get('myUserId');

        Assert::true($event->ideaId()->equals($ideaId));
        Assert::true($event->userId()->equals($myUserId));
    }
}
