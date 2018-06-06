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

use App\Domain\Group\Event\GroupAdded;
use App\Infrastructure\ReadModel\Group\Repository\GroupViews;
use App\Infrastructure\ReadModel\Group\View\GroupView;

final class GroupAddedProjection
{
    /**
     * @var GroupViews
     */
    private $groupViews;

    public function __construct(GroupViews $groupViews)
    {
        $this->groupViews = $groupViews;
    }

    public function __invoke(GroupAdded $groupAdded)
    {
        $this->groupViews->add(new GroupView(
           $groupAdded->groupId()->value(),
           $groupAdded->name()->value()
        ));
    }
}
