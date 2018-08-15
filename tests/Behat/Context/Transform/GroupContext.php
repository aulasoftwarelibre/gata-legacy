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

namespace Tests\Behat\Context\Transform;

use App\Domain\Group\Model\GroupId;
use AulaSoftwareLibre\DDD\TestsBundle\Service\SharedStorage;
use Behat\Behat\Context\Context;

final class GroupContext implements Context
{
    /**
     * @var SharedStorage
     */
    private $sharedStorage;

    public function __construct(SharedStorage $sharedStorage)
    {
        $this->sharedStorage = $sharedStorage;
    }

    /**
     * @Transform
     */
    public function getGroupFromSharedStorage(): GroupId
    {
        return $this->sharedStorage->get('groupId');
    }
}
