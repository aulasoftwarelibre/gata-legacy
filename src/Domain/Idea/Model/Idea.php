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

namespace App\Domain\Idea\Model;

use App\Domain\AggregateRoot;
use App\Domain\Comment\Model\Comment;
use App\Domain\Comment\Model\CommentId;
use App\Domain\Comment\Model\CommentText;
use App\Domain\Group\Model\GroupId;
use App\Domain\Idea\Event\IdeaAccepted;
use App\Domain\Idea\Event\IdeaAdded;
use App\Domain\Idea\Event\IdeaAttendeeRegistered;
use App\Domain\Idea\Event\IdeaAttendeeUnregistered;
use App\Domain\Idea\Event\IdeaCapacityLimited;
use App\Domain\Idea\Event\IdeaCapacityUnlimited;
use App\Domain\Idea\Event\IdeaRedescribed;
use App\Domain\Idea\Event\IdeaRejected;
use App\Domain\Idea\Event\IdeaTitleChanged;
use App\Domain\User\Model\UserId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Idea extends AggregateRoot
{
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

        $idea->recordThat(IdeaAdded::withData($ideaId, $groupId, $ideaTitle, $ideaDescription));

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
        $this->recordThat(IdeaAccepted::withData($this->ideaId()));
    }

    public function reject(): void
    {
        $this->recordThat(IdeaRejected::withData($this->ideaId()));
    }

    public function title(): IdeaTitle
    {
        return $this->title;
    }

    public function changeTitle(IdeaTitle $ideaTitle): void
    {
        if ($this->title()->equals($ideaTitle)) {
            return;
        }

        $this->recordThat(IdeaTitleChanged::withData($this->ideaId(), $ideaTitle));
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

        $this->recordThat(IdeaRedescribed::withData($this->ideaId(), $ideaDescription));
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
        $this->recordThat(IdeaAttendeeRegistered::withData($this->ideaId(), $userId));
    }

    public function unregisterAttendee(UserId $userId): void
    {
        $this->recordThat(IdeaAttendeeUnregistered::withData($this->ideaId(), $userId));
    }

    public function capacityUnlimited(): void
    {
        $this->recordThat(IdeaCapacityUnlimited::withData($this->ideaId()));
    }

    public function capacityLimited(int $limit): void
    {
        $this->recordThat(IdeaCapacityLimited::withData($this->ideaId(), $limit));
    }

    protected function aggregateId(): string
    {
        return $this->ideaId()->value();
    }

    protected function applyIdeaAdded(IdeaAdded $event): void
    {
        $this->ideaId = $event->ideaId();
        $this->groupId = $event->groupId();
        $this->status = $event->status();
        $this->title = $event->title();
        $this->description = $event->description();
        $this->capacity = $event->capacity();
        $this->attendees = $event->attendees();
    }

    protected function applyIdeaTitleChanged(IdeaTitleChanged $event): void
    {
        $this->title = $event->title();
    }

    protected function applyIdeaRedescribed(IdeaRedescribed $event): void
    {
        $this->description = $event->description();
    }

    protected function applyIdeaAccepted(IdeaAccepted $event): void
    {
        $this->status = $event->status();
    }

    protected function applyIdeaRejected(IdeaRejected $event): void
    {
        $this->status = $event->status();
    }

    protected function applyIdeaAttendeeRegistered(IdeaAttendeeRegistered $event): void
    {
        if ($this->isAttendeeRegistered($event->userId())) {
            return;
        }

        $this->capacity = $this->capacity()->increment();
        $this->attendees->add($event->userId());
    }

    protected function applyIdeaAttendeeUnregistered(IdeaAttendeeUnregistered $event): void
    {
        if (!$this->isAttendeeRegistered($event->userId())) {
            return;
        }

        $this->capacity = $this->capacity()->decrement();
        $this->attendees = $this->attendees->filter(function (UserId $attendeeId) use ($event) {
            return !$attendeeId->equals($event->userId());
        });
    }

    protected function applyIdeaCapacityUnlimited(IdeaCapacityUnlimited $event): void
    {
        $this->capacity = $this->capacity()->unlimited();
    }

    protected function applyIdeaCapacityLimited(IdeaCapacityLimited $event): void
    {
        $this->capacity = $this->capacity->limited($event->limit());
    }
}
