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

namespace AulaSoftwareLibre\Gata\Infrastructure\ReadModel\Group\Projection;

use AulaSoftwareLibre\Gata\Domain\ApplyMethodDispatcherTrait;
use AulaSoftwareLibre\Gata\Domain\Group\Event\GroupAdded;
use AulaSoftwareLibre\Gata\Domain\Group\Event\GroupRenamed;
use AulaSoftwareLibre\Gata\Infrastructure\ReadModel\AbstractReadModel;
use AulaSoftwareLibre\Gata\Infrastructure\ReadModel\Group\Repository\GroupViews;
use AulaSoftwareLibre\Gata\Infrastructure\ReadModel\Group\View\GroupView;
use AulaSoftwareLibre\Gata\Infrastructure\ReadModel\SchemaManagerInterface;

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
