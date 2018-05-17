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

class Idea extends AggregateRoot
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
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    public static function add(IdeaId $ideaId, IdeaStatus $ideaStatus, string $title, string $description)
    {
        $comment = new self();

        $comment->recordThat(IdeaAdded::withData($ideaId, $ideaStatus, $title, $description));

        return $comment;
    }

    public function ideaId(): IdeaId
    {
        return $this->ideaId;
    }

    public function ideaStatus(): IdeaStatus
    {
        return $this->ideaStatus;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    protected function aggregateId(): string
    {
        return $this->ideaId->id();
    }

    protected function applyIdeaAdded(IdeaAdded $event): void
    {
        $this->ideaId = $event->ideaId();
        $this->ideaStatus = $event->ideaStatus();
        $this->title = $event->title();
        $this->description = $event->description();
    }
}
