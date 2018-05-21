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
use App\Domain\Idea\Event\IdeaAdded;

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
     * @var IdeaTitle
     */
    private $ideaTitle;

    /**
     * @var IdeaDescription
     */
    private $ideaDescription;

    public static function add(IdeaId $ideaId, IdeaTitle $ideaTitle, IdeaDescription $ideaDescription)
    {
        $comment = new self();

        $comment->recordThat(IdeaAdded::withData($ideaId, $ideaTitle, $ideaDescription));

        return $comment;
    }

    public function __toString()
    {
        return $this->ideaTitle()->title();
    }

    public function ideaId(): IdeaId
    {
        return $this->ideaId;
    }

    public function ideaStatus(): IdeaStatus
    {
        return $this->ideaStatus;
    }

    public function ideaTitle(): IdeaTitle
    {
        return $this->ideaTitle;
    }

    public function ideaDescription(): IdeaDescription
    {
        return $this->ideaDescription;
    }

    protected function aggregateId(): string
    {
        return $this->ideaId()->id();
    }

    protected function applyIdeaAdded(IdeaAdded $event): void
    {
        $this->ideaId = $event->ideaId();
        $this->ideaStatus = IdeaStatus::PENDING();
        $this->ideaTitle = $event->ideaTitle();
        $this->ideaDescription = $event->ideaDescription();
    }
}
