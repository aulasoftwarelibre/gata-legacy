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

namespace AulaSoftwareLibre\Gata\Infrastructure\ReadModel\Repository;

use AulaSoftwareLibre\Gata\Infrastructure\ReadModel\View\GroupView;

interface GroupViews
{
    public function add(GroupView $groupView): void;

    public function ofId(string $groupId): GroupView;

    public function rename(string $groupId, string $newName): void;
}
