<?php

/*
 * This file is part of the `gata` project.
 *
 * (c) Aula de Software Libre de la UCO <aulasoftwarelibre@uco.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\Idea\Command;

use App\Application\Idea\Repository\Ideas;
use App\Domain\Idea\Model\Idea;

final class AddIdeaHandler
{
    /**
     * @var Ideas
     */
    private $ideas;

    public function __construct(Ideas $ideas)
    {
        $this->ideas = $ideas;
    }

    public function __invoke(AddIdea $addIdea): void
    {
        $idea = Idea::add(
            $addIdea->ideaId(),
            $addIdea->groupId(),
            $addIdea->title(),
            $addIdea->description()
        );

        $this->ideas->save($idea);
    }
}
