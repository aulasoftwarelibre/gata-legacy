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

use App\Application\Group\Command\AddGroup;
use App\Domain\Group\Model\GroupId;
use App\Domain\Group\Model\GroupName;
use Behat\Behat\Context\Context;
use Prooph\ServiceBus\CommandBus;
use Ramsey\Uuid\Uuid;
use Tests\Service\SharedStorage;

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

    public function __construct(CommandBus $commandBus, SharedStorage $sharedStorage)
    {
        $this->commandBus = $commandBus;
        $this->sharedStorage = $sharedStorage;
    }

    /**
     * @Given /^there is a group named "([^"]*)"$/
     */
    public function thereIsAGroupNamed(string $name): void
    {
        $groupId = new GroupId(Uuid::uuid4()->toString());

        $this->sharedStorage->set('groupId', $groupId);

        $this->commandBus->dispatch(AddGroup::create(
            $groupId,
            new GroupName($name)
        ));
    }
}
