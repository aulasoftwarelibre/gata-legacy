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

namespace App\Application\Idea\Command;

use App\Application\Idea\Repository\Ideas;

final class RetitleIdeaHandler
{
    /**
     * @var Ideas
     */
    private $ideas;

    public function __construct(Ideas $ideas)
    {
        $this->ideas = $ideas;
    }

    public function __invoke(RetitleIdea $retitleIdea): void
    {
        $idea = $this->ideas->get($retitleIdea->ideaId());

        $idea->retitle($retitleIdea->title());

        $this->ideas->save($idea);
    }
}
