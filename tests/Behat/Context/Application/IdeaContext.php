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

use App\Application\Idea\Command\AcceptIdea;
use App\Application\Idea\Command\AddIdea;
use App\Application\Idea\Command\RetitleIdea;
use App\Domain\Group\Model\GroupId;
use App\Domain\Idea\Event\IdeaAccepted;
use App\Domain\Idea\Event\IdeaAdded;
use App\Domain\Idea\Event\IdeaRetitled;
use App\Domain\Idea\Model\IdeaDescription;
use App\Domain\Idea\Model\IdeaId;
use App\Domain\Idea\Model\IdeaTitle;
use Behat\Behat\Context\Context;
use Prooph\ServiceBus\CommandBus;
use Ramsey\Uuid\Uuid;
use Tests\Service\Prooph\Plugin\EventsRecorder;
use Tests\Service\SharedStorage;
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
     * @When /^I add a new idea titled "([^"]*)" with any description to (this group)$/
     */
    public function iAddANewIdeaTitledWithAnyDescriptionToThisGroup(string $title, GroupId $groupId): void
    {
        $this->commandBus->dispatch(AddIdea::create(
            new IdeaId(Uuid::uuid4()->toString()),
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
    public function iRetitleItTo(IdeaId $ideaId, string $title)
    {
        $this->commandBus->dispatch(RetitleIdea::create(
            $ideaId,
            new IdeaTitle($title)
        ));
    }

    /**
     * @Then /^(it) should be retitled to "([^"]*)"$/
     */
    public function itShouldBeRetitledTo(IdeaId $ideaId, string $title)
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
    public function iAcceptIt(IdeaId $ideaId)
    {
        $this->commandBus->dispatch(
            AcceptIdea::create(
                $ideaId
            )
        );
    }

    /**
     * @Then /^(it) should be marked as accepted$/
     */
    public function itShouldBeMarkedAsAccepted(IdeaId $ideaId)
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
}
