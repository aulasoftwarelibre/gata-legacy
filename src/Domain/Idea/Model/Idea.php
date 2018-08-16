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

namespace AulaSoftwareLibre\Gata\Domain\Idea\Model;

use AulaSoftwareLibre\Gata\Domain\ApplyMethodDispatcherTrait;
use AulaSoftwareLibre\Gata\Domain\Comment\Model\Comment;
use AulaSoftwareLibre\Gata\Domain\Comment\Model\CommentId;
use AulaSoftwareLibre\Gata\Domain\Comment\Model\CommentText;
use AulaSoftwareLibre\Gata\Domain\Group\Model\GroupId;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaAttendeeWasRegistered;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaAttendeeWasUnregistered;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaCapacityWasLimited;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaCapacityWasUnlimited;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaWasAccepted;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaWasAdded;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaWasRedescribed;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaWasRejected;
use AulaSoftwareLibre\Gata\Domain\Idea\Event\IdeaWasRetitled;
use AulaSoftwareLibre\Gata\Domain\User\Model\UserId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Prooph\EventSourcing\AggregateRoot;

class Idea extends AggregateRoot
{
    use ApplyMethodDispatcherTrait;

    /**
     * @var IdeaId
     */
    private $ideaId;

    /**
     * @var GroupId
     */
    private $groupId;

    /**
     * @var IdeaStatus
     */
    private $status;

    /**
     * @var IdeaTitle
     */
    private $title;

    /**
     * @var IdeaDescription
     */
    private $description;

    /**
     * @var IdeaCapacity
     */
    private $capacity;

    /**
     * @var Collection|ArrayCollection
     */
    private $attendees;

    public static function add(
        IdeaId $ideaId,
        GroupId $groupId,
        IdeaTitle $ideaTitle,
        IdeaDescription $ideaDescription
    ): self {
        $idea = new self();

        $idea->recordThat(IdeaWasAdded::with($ideaId, $groupId, $ideaTitle, $ideaDescription));

        return $idea;
    }

    public function __toString(): string
    {
        return $this->title()->value();
    }

    public function ideaId(): IdeaId
    {
        return $this->ideaId;
    }

    public function groupId(): GroupId
    {
        return $this->groupId;
    }

    public function status(): IdeaStatus
    {
        return $this->status;
    }

    public function accept(): void
    {
        $this->recordThat(IdeaWasAccepted::with($this->ideaId()));
    }

    public function reject(): void
    {
        $this->recordThat(IdeaWasRejected::with($this->ideaId()));
    }

    public function title(): IdeaTitle
    {
        return $this->title;
    }

    public function retitle(IdeaTitle $ideaTitle): void
    {
        if ($this->title()->equals($ideaTitle)) {
            return;
        }

        $this->recordThat(IdeaWasRetitled::with($this->ideaId(), $ideaTitle));
    }

    public function description(): IdeaDescription
    {
        return $this->description;
    }

    public function redescribe(IdeaDescription $ideaDescription): void
    {
        if ($this->description()->equals($ideaDescription)) {
            return;
        }

        $this->recordThat(IdeaWasRedescribed::with($this->ideaId(), $ideaDescription));
    }

    public function capacity(): IdeaCapacity
    {
        return $this->capacity;
    }

    public function addComment(CommentId $commentId, UserId $userId, CommentText $commentText): Comment
    {
        return Comment::add(
            $commentId,
            $this->ideaId(),
            $userId,
            $commentText
        );
    }

    public function isAttendeeRegistered(UserId $userId): bool
    {
        return $this->attendees->exists(function ($key, UserId $attendeeId) use ($userId) {
            return $attendeeId->equals($userId);
        });
    }

    public function registerAttendee(UserId $userId): void
    {
        $this->recordThat(IdeaAttendeeWasRegistered::with($this->ideaId(), $userId));
    }

    public function unregisterAttendee(UserId $userId): void
    {
        $this->recordThat(IdeaAttendeeWasUnregistered::with($this->ideaId(), $userId));
    }

    public function capacityUnlimited(): void
    {
        $this->recordThat(IdeaCapacityWasUnlimited::with($this->ideaId()));
    }

    public function capacityLimited(int $limit): void
    {
        $this->recordThat(IdeaCapacityWasLimited::with($this->ideaId(), $limit));
    }

    protected function aggregateId(): string
    {
        return $this->ideaId()->toString();
    }

    protected function applyIdeaWasAdded(IdeaWasAdded $event): void
    {
        $this->ideaId = $event->ideaId();
        $this->groupId = $event->groupId();
        $this->status = IdeaStatus::pending();
        $this->title = $event->title();
        $this->description = $event->description();
        $this->capacity = new IdeaCapacity();
        $this->attendees = new ArrayCollection();
    }

    protected function applyIdeaWasRetitled(IdeaWasRetitled $event): void
    {
        $this->title = $event->title();
    }

    protected function applyIdeaWasRedescribed(IdeaWasRedescribed $event): void
    {
        $this->description = $event->description();
    }

    protected function applyIdeaWasAccepted(IdeaWasAccepted $event): void
    {
        $this->status = IdeaStatus::accepted();
    }

    protected function applyIdeaWasRejected(IdeaWasRejected $event): void
    {
        $this->status = IdeaStatus::rejected();
    }

    protected function applyIdeaAttendeeWasRegistered(IdeaAttendeeWasRegistered $event): void
    {
        if ($this->isAttendeeRegistered($event->userId())) {
            return;
        }

        $this->capacity = $this->capacity()->increment();
        $this->attendees->add($event->userId());
    }

    protected function applyIdeaAttendeeWasUnregistered(IdeaAttendeeWasUnregistered $event): void
    {
        if (!$this->isAttendeeRegistered($event->userId())) {
            return;
        }

        $this->capacity = $this->capacity()->decrement();
        $this->attendees = $this->attendees->filter(function (UserId $attendeeId) use ($event) {
            return !$attendeeId->equals($event->userId());
        });
    }

    protected function applyIdeaCapacityWasUnlimited(IdeaCapacityWasUnlimited $event): void
    {
        $this->capacity = $this->capacity()->unlimited();
    }

    protected function applyIdeaCapacityWasLimited(IdeaCapacityWasLimited $event): void
    {
        $this->capacity = $this->capacity->limited($event->limit());
    }
}
