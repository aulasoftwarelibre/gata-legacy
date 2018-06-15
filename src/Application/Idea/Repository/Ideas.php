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

namespace App\Application\Idea\Repository;

use App\Domain\Idea\Model\Idea;
use App\Domain\Idea\Model\IdeaId;

interface Ideas
{
    public function save(Idea $idea): void;

    public function get(IdeaId $ideaId): ?Idea;

    public function nextIdentity(): IdeaId;
}
