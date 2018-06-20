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

use App\Domain\ApplyMethodDispatcherTrait;
use App\Domain\Group\Event\GroupAdded;
use App\Domain\Group\Event\GroupRenamed;
use App\Infrastructure\ReadModel\AbstractReadModel;
use App\Infrastructure\ReadModel\Group\Repository\GroupViews;
use App\Infrastructure\ReadModel\Group\View\GroupView;
use App\Infrastructure\ReadModel\SchemaManagerInterface;

class GroupReadModel extends AbstractReadModel
{
    use ApplyMethodDispatcherTrait;

    /**
     * @var GroupViews|SchemaManagerInterface
     */
    private $groupViews;

    public function __construct(GroupViews $groupViews)
    {
        $this->groupViews = $groupViews;

        parent::__construct($groupViews);
    }

    public function applyGroupAdded(GroupAdded $groupAdded): void
    {
        $groupView = new GroupView(
            $groupAdded->groupId()->value(),
            $groupAdded->name()->value()
        );

        $this->groupViews->add($groupView);
    }

    public function applyGroupRenamed(GroupRenamed $groupRenamed): void
    {
        $this->groupViews->rename(
            $groupRenamed->groupId()->value(),
            $groupRenamed->name()->value()
        );
    }
}
