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
use AulaSoftwareLibre\Gata\Application\Group\Command\AddGroup;
use AulaSoftwareLibre\Gata\Application\Group\Repository\Groups;
use AulaSoftwareLibre\Gata\Domain\Group\Model\GroupName;
use Behat\Behat\Context\Context;
use Prooph\ServiceBus\CommandBus;

final class GroupContext implements Context
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
     * @var Groups
     */
    private $groups;

    public function __construct(
        CommandBus $commandBus,
        SharedStorage $sharedStorage,
        Groups $groups
    ) {
        $this->commandBus = $commandBus;
        $this->sharedStorage = $sharedStorage;
        $this->groups = $groups;
    }

    /**
     * @Given /^there is a group named "([^"]*)"$/
     */
    public function thereIsAGroupNamed(string $name): void
    {
        $groupId = $this->groups->nextIdentity();

        $this->sharedStorage->set('groupId', $groupId);

        $this->commandBus->dispatch(AddGroup::create(
            $groupId,
            new GroupName($name)
        ));
    }
}
