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

namespace AulaSoftwareLibre\Gata\Application\Idea\Command;

use AulaSoftwareLibre\Gata\Application\Idea\Repository\Ideas;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\Idea;

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
