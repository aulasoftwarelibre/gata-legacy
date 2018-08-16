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

namespace spec\AulaSoftwareLibre\Gata\Domain\Comment\Model;

use AulaSoftwareLibre\DDD\TestsBundle\Service\Prooph\Spec\AggregateAsserter;
use AulaSoftwareLibre\Gata\Domain\Comment\Event\CommentAdded;
use AulaSoftwareLibre\Gata\Domain\Comment\Model\CommentId;
use AulaSoftwareLibre\Gata\Domain\Comment\Model\CommentText;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId;
use AulaSoftwareLibre\Gata\Domain\User\Model\UserId;
use PhpSpec\ObjectBehavior;
use Prooph\EventSourcing\AggregateRoot;

final class CommentSpec extends ObjectBehavior
{
    const COMMENT_ID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';
    const IDEA_ID = '4ab37020-455c-45a3-8f7e-194bfb9fbc0b';
    const USER_ID = '0c586173-7676-4a2c-9220-edd223eb458e';

    public function let(): void
    {
        $this->beConstructedThrough('add', [
            new CommentId(self::COMMENT_ID),
            IdeaId::fromString(self::IDEA_ID),
            UserId::fromString(self::USER_ID),
            new CommentText('Text'),
        ]);

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            CommentAdded::withData(
                new CommentId(self::COMMENT_ID),
                IdeaId::fromString(self::IDEA_ID),
                UserId::fromString(self::USER_ID),
                new CommentText('Text')
            )
        );
    }

    public function it_is_an_aggregate(): void
    {
        $this->shouldHaveType(AggregateRoot::class);
    }

    public function it_can_be_a_string(): void
    {
        $this->__toString()->shouldBe('Text');
    }

    public function it_has_a_comment_id(): void
    {
        $this->commentId()->shouldBeLike(new CommentId(self::COMMENT_ID));
    }

    public function it_has_an_idea_id(): void
    {
        $this->ideaId()->shouldBeLike(IdeaId::fromString(self::IDEA_ID));
    }

    public function it_has_an_user_id(): void
    {
        $this->userId()->shouldBeLike(UserId::fromString(self::USER_ID));
    }

    public function it_has_a_text(): void
    {
        $this->text()->shouldBeLike(new CommentText('Text'));
    }
}
