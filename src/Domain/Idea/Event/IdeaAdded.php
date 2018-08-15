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

namespace AulaSoftwareLibre\Gata\Domain\Idea\Event;

use AulaSoftwareLibre\Gata\Domain\Group\Model\GroupId;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaCapacity;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaDescription;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaStatus;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaTitle;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Prooph\EventSourcing\AggregateChanged;

final class IdeaAdded extends AggregateChanged
{
    public static function withData(
        IdeaId $ideaId,
        GroupId $groupId,
        IdeaTitle $ideaTitle,
        IdeaDescription $ideaDescription
    ): self {
        return self::occur($ideaId->value(), [
            'groupId' => $groupId->toString(),
            'title' => $ideaTitle->value(),
            'description' => $ideaDescription->value(),
        ]);
    }

    public function ideaId(): IdeaId
    {
        return new IdeaId($this->aggregateId());
    }

    public function groupId(): GroupId
    {
        return GroupId::fromString($this->payload()['groupId']);
    }

    public function title(): IdeaTitle
    {
        return new IdeaTitle($this->payload()['title']);
    }

    public function description(): IdeaDescription
    {
        return new IdeaDescription($this->payload()['description']);
    }

    public function status(): IdeaStatus
    {
        return IdeaStatus::PENDING();
    }

    public function capacity(): IdeaCapacity
    {
        return new IdeaCapacity();
    }

    public function attendees(): Collection
    {
        return new ArrayCollection();
    }
}
