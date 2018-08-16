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

namespace Tests\Behat\Context\Setup;

use AulaSoftwareLibre\DDD\TestsBundle\Service\SharedStorage;
use AulaSoftwareLibre\Gata\Application\Idea\Command\AddIdea;
use AulaSoftwareLibre\Gata\Application\Idea\Command\RegisterIdeaAttendee;
use AulaSoftwareLibre\Gata\Application\Idea\Repository\Ideas;
use AulaSoftwareLibre\Gata\Domain\Group\Model\GroupId;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaDescription;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaTitle;
use Behat\Behat\Context\Context;
use Prooph\ServiceBus\CommandBus;

final class IdeaContext implements Context
{
    /**
     * @var CommandBus
     */
    private $commandBus;

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
        SharedStorage $sharedStorage,
        Ideas $ideas
    ) {
        $this->commandBus = $commandBus;
        $this->sharedStorage = $sharedStorage;
        $this->ideas = $ideas;
    }

    /**
     * @Given /^there is an idea titled "([^"]*)" in (this group)$/
     */
    public function thereIsAnIdeaTitledInThisGroup(string $title, GroupId $groupId): void
    {
        $ideaId = $this->ideas->nextIdentity();

        $this->sharedStorage->set('ideaId', $ideaId);

        $this->commandBus->dispatch(AddIdea::with(
            $ideaId,
            $groupId,
            IdeaTitle::fromString($title),
            IdeaDescription::fromString('Description')
        ));
    }

    /**
     * @Given /^I am registered as attendee in (this idea)$/
     */
    public function iAmRegisteredAsAttendeeInThisIdea(IdeaId $ideaId): void
    {
        $myUserId = $this->sharedStorage->get('myUserId');

        $this->commandBus->dispatch(RegisterIdeaAttendee::with(
            $ideaId,
            $myUserId
        ));
    }
}
