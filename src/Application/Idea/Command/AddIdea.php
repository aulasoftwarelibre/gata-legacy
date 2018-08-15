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

use AulaSoftwareLibre\Gata\Domain\Group\Model\GroupId;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaDescription;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaTitle;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;

final class AddIdea extends Command
{
    use PayloadTrait;

    public static function create(
        IdeaId $ideaId,
        GroupId $groupId,
        IdeaTitle $ideaTitle,
        IdeaDescription $ideaDescription
    ) {
        return new self([
            'ideaId' => $ideaId->value(),
            'groupId' => $groupId->toString(),
            'title' => $ideaTitle->value(),
            'description' => $ideaDescription->value(),
        ]);
    }

    public function ideaId()
    {
        return new IdeaId($this->payload()['ideaId']);
    }

    public function groupId()
    {
        return GroupId::fromString($this->payload()['groupId']);
    }

    public function title()
    {
        return new IdeaTitle($this->payload()['title']);
    }

    public function description()
    {
        return new IdeaDescription($this->payload()['description']);
    }
}
