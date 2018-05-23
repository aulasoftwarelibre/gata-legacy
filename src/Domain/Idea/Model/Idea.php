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
use App\Domain\Group\Model\GroupId;
use App\Domain\Idea\Event\IdeaAccepted;
use App\Domain\Idea\Event\IdeaAdded;
use App\Domain\Idea\Event\IdeaDescriptionChanged;
use App\Domain\Idea\Event\IdeaRejected;
use App\Domain\Idea\Event\IdeaTitleChanged;

final class Idea extends AggregateRoot
{
    /**
     * @var IdeaId
     */
    private $ideaId;
    /**
     * @var IdeaStatus
     */
    private $ideaStatus;
    /**
     * @var GroupId
     */
    private $groupId;
    /**
     * @var IdeaTitle
     */
    private $ideaTitle;
    /**
     * @var IdeaDescription
     */
    private $ideaDescription;

    public static function add(IdeaId $ideaId, GroupId $groupId, IdeaTitle $ideaTitle, IdeaDescription $ideaDescription)
    {
        $idea = new self();

        $idea->recordThat(IdeaAdded::withData($ideaId, $groupId, $ideaTitle, $ideaDescription));

        return $idea;
    }

    public function __toString()
    {
        return $this->title()->title();
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
        return $this->ideaStatus;
    }

    public function title(): IdeaTitle
    {
        return $this->ideaTitle;
    }

    public function changeTitle(IdeaTitle $title): void
    {
        $this->recordThat(IdeaTitleChanged::withData($this->ideaId(), $title));
    }

    public function description(): IdeaDescription
    {
        return $this->ideaDescription;
    }

    public function changeDescription(IdeaDescription $description): void
    {
        $this->recordThat(IdeaDescriptionChanged::withData($this->ideaId(), $description));
    }

    public function accept(): void
    {
        $this->recordThat(IdeaAccepted::withData($this->ideaId()));
    }

    public function reject(): void
    {
        $this->recordThat(IdeaRejected::withData($this->ideaId()));
    }

    protected function aggregateId(): string
    {
        return $this->ideaId()->id();
    }

    protected function applyIdeaAdded(IdeaAdded $event): void
    {
        $this->ideaId = $event->ideaId();
        $this->groupId = $event->groupId();
        $this->ideaStatus = $event->ideaStatus();
        $this->ideaTitle = $event->ideaTitle();
        $this->ideaDescription = $event->ideaDescription();
    }

    protected function applyIdeaTitleChanged(IdeaTitleChanged $event): void
    {
        $this->ideaTitle = $event->title();
    }

    protected function applyIdeaDescriptionChanged(IdeaDescriptionChanged $event): void
    {
        $this->ideaDescription = $event->description();
    }

    protected function applyIdeaAccepted(IdeaAccepted $event): void
    {
        $this->ideaStatus = $event->ideaStatus();
    }

    protected function applyIdeaRejected(IdeaRejected $event): void
    {
        $this->ideaStatus = $event->ideaStatus();
    }
}
