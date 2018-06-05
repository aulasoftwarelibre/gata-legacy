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

use App\Application\Idea\Command\AddIdea;
use App\Domain\Group\Model\GroupId;
use App\Domain\Idea\Model\IdeaDescription;
use App\Domain\Idea\Model\IdeaId;
use App\Domain\Idea\Model\IdeaTitle;
use Behat\Behat\Context\Context;
use Prooph\ServiceBus\CommandBus;
use Ramsey\Uuid\Uuid;
use Tests\Service\SharedStorage;

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

    public function __construct(CommandBus $commandBus, SharedStorage $sharedStorage)
    {
        $this->commandBus = $commandBus;
        $this->sharedStorage = $sharedStorage;
    }

    /**
     * @Given /^there is an idea titled "([^"]*)" with any description in any group$/
     */
    public function thereIsAnIdeaTitledWithAnyDescriptionInAnyGroup(string $title): void
    {
        $ideaId = new IdeaId(Uuid::uuid4()->toString());
        $groupId = new GroupId(Uuid::uuid4()->toString());

        $this->sharedStorage->set('ideaId', $ideaId);

        $this->commandBus->dispatch(AddIdea::create(
            $ideaId,
            $groupId,
            new IdeaTitle($title),
            new IdeaDescription('Description')
        ));
    }
}
