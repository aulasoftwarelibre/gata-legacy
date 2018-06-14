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

namespace App\Infrastructure\ReadModel\Group\Projection;

use App\Application\Group\Exception\GroupNotFoundException;
use App\Domain\Group\Event\GroupRenamed;
use App\Infrastructure\ReadModel\Group\Repository\GroupViews;
use App\Infrastructure\ReadModel\Group\View\GroupView;

final class GroupRenamedProjection
{
    /**
     * @var GroupViews
     */
    private $groupViews;

    public function __construct(GroupViews $groupViews)
    {
        $this->groupViews = $groupViews;
    }

    public function __invoke(GroupRenamed $groupRenamed)
    {
        $groupId = $groupRenamed->groupId();

        $groupView = $this->groupViews->get($groupId);
        if (!$groupView instanceof GroupView) {
            throw new GroupNotFoundException();
        }

        $name = $groupRenamed->name()->value();
        $groupView->rename($name);

        $this->groupViews->save();
    }
}
