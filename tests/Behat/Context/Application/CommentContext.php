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

namespace Tests\Behat\Context\Application;

use App\Application\Comment\Command\AddComment;
use App\Application\Comment\Repository\Comments;
use App\Domain\Comment\Event\CommentAdded;
use App\Domain\Comment\Model\CommentText;
use App\Domain\Idea\Model\Idea;
use App\Domain\Idea\Model\IdeaId;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Prooph\ServiceBus\CommandBus;
use Tests\Service\Prooph\Plugin\EventsRecorder;
use Tests\Service\SharedStorage;
use Webmozart\Assert\Assert;

class CommentContext implements Context
{
    /**
     * @var CommandBus
     */
    private $commandBus;
    /**
     * @var EventsRecorder
     */
    private $eventsRecorder;
    /**
     * @var SharedStorage
     */
    private $sharedStorage;
    /**
     * @var Comments
     */
    private $comments;

    public function __construct(
        CommandBus $commandBus,
        EventsRecorder $eventsRecorder,
        SharedStorage $sharedStorage,
        Comments $comments
    ) {
        $this->commandBus = $commandBus;
        $this->eventsRecorder = $eventsRecorder;
        $this->sharedStorage = $sharedStorage;
        $this->comments = $comments;
    }

    /**
     * @When /^I add the next comment$/
     */
    public function iAddTheNextComment(PyStringNode $string)
    {
        $ideaId = $this->sharedStorage->get('ideaId');
        $userId = $this->sharedStorage->get('myUserId');

        $this->commandBus->dispatch(AddComment::create(
            $this->comments->nextIdentity(),
            $ideaId,
            $userId,
            new CommentText($string->getRaw())
        ));
    }

    /**
     * @Then /^the comment should be available in (this idea)$/
     */
    public function theCommentShouldBeAvailableInThisIdea(IdeaId $ideaId)
    {
        /** @var CommentAdded $event */
        $event = $this->eventsRecorder->getLastMessage()->event();

        Assert::isInstanceOf($event, CommentAdded::class, sprintf(
            'Event has to be of class %s, but %s given',
            CommentAdded::class,
            \get_class($event)
        ));
        Assert::true($event->ideaId()->equals($ideaId));
    }
}
