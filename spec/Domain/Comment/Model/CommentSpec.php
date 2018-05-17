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

namespace spec\App\Domain\Comment\Model;

use App\Domain\Comment\Event\CommentAdded;
use App\Domain\Comment\Model\Comment;
use App\Domain\Comment\Model\CommentId;
use App\Domain\Idea\Model\IdeaId;
use App\Domain\User\Model\UserId;
use PhpSpec\ObjectBehavior;
use Tests\Service\Prooph\Spec\AggregateAsserter;

class CommentSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedThrough('add', [
            new CommentId('e8a68535-3e17-468f-acc3-8a3e0fa04a59'),
            new IdeaId('4ab37020-455c-45a3-8f7e-194bfb9fbc0b'),
            new UserId('0c586173-7676-4a2c-9220-edd223eb458e'),
            'Lorem ipsum',
        ]);
        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            CommentAdded::withData(
                new CommentId('e8a68535-3e17-468f-acc3-8a3e0fa04a59'),
                new IdeaId('4ab37020-455c-45a3-8f7e-194bfb9fbc0b'),
                new UserId('0c586173-7676-4a2c-9220-edd223eb458e'),
                'Lorem ipsum'
            )
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Comment::class);
    }

    public function it_has_an_id(): void
    {
        $this->id()->shouldBeLike(new CommentId('e8a68535-3e17-468f-acc3-8a3e0fa04a59'));
    }

    public function it_has_an_idea_id(): void
    {
        $this->ideaId()->shouldBeLike(new IdeaId('4ab37020-455c-45a3-8f7e-194bfb9fbc0b'));
    }

    public function it_has_an_user_id(): void
    {
        $this->userId()->shouldBeLike(new UserId('0c586173-7676-4a2c-9220-edd223eb458e'));
    }

    public function it_has_a_text(): void
    {
        $this->text()->shouldBeLike('Lorem ipsum');
    }
}
