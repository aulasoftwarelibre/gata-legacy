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

namespace App\Domain\Idea\Event;

use App\Domain\Group\Model\GroupId;
use App\Domain\Idea\Model\IdeaCapacity;
use App\Domain\Idea\Model\IdeaDescription;
use App\Domain\Idea\Model\IdeaId;
use App\Domain\Idea\Model\IdeaStatus;
use App\Domain\Idea\Model\IdeaTitle;
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
        return self::occur($ideaId->id(), [
            'groupId' => $groupId->value(),
            'title' => $ideaTitle->title(),
            'description' => $ideaDescription->value(),
        ]);
    }

    public function ideaId(): IdeaId
    {
        return new IdeaId($this->aggregateId());
    }

    public function groupId(): GroupId
    {
        return new GroupId($this->payload()['groupId']);
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
