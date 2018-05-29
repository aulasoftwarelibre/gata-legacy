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
use Prooph\EventSourcing\AggregateChanged;

final class IdeaAdded extends AggregateChanged
{
    public static function withData(IdeaId $ideaId, GroupId $groupId, IdeaTitle $ideaTitle, IdeaDescription $ideaDescription): self
    {
        return self::occur($ideaId->id(), [
            'groupId' => $groupId->id(),
            'title' => $ideaTitle->title(),
            'description' => $ideaDescription->description(),
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

    public function ideaTitle(): IdeaTitle
    {
        return new IdeaTitle($this->payload()['title']);
    }

    public function ideaDescription(): IdeaDescription
    {
        return new IdeaDescription($this->payload()['description']);
    }

    public function ideaStatus(): IdeaStatus
    {
        return IdeaStatus::PENDING();
    }

    public function ideaCapacity(): IdeaCapacity
    {
        return new IdeaCapacity();
    }
}
