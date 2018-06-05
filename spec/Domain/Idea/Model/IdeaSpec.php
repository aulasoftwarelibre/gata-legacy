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

namespace spec\App\Domain\Idea\Model;

use App\Domain\AggregateRoot;
use App\Domain\Comment\Event\CommentAdded;
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
use App\Domain\Idea\Model\IdeaCapacity;
use App\Domain\Idea\Model\IdeaDescription;
use App\Domain\Idea\Model\IdeaId;
use App\Domain\Idea\Model\IdeaStatus;
use App\Domain\Idea\Model\IdeaTitle;
use App\Domain\User\Model\UserId;
use PhpSpec\ObjectBehavior;
use Tests\Service\Prooph\Spec\AggregateAsserter;

final class IdeaSpec extends ObjectBehavior
{
    const IDEA_ID = 'e8a68535-3e17-468f-acc3-8a3e0fa04a59';
    const GROUP_ID = '4ab37020-455c-45a3-8f7e-194bfb9fbc0b';
    const COMMENT_ID = '0c586173-7676-4a2c-9220-edd223eb458e';
    const USER_ID = '805d3cef-5408-48bc-98c4-dcd04d496eb1';

    const CAPACITY_LIMIT = 10;

    public function let(): void
    {
        $this->beConstructedThrough('add', [
            new IdeaId(self::IDEA_ID),
            new GroupId(self::GROUP_ID),
            new IdeaTitle('Title'),
            new IdeaDescription('Description'),
        ]);

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            IdeaAdded::withData(
                new IdeaId(self::IDEA_ID),
                new GroupId(self::GROUP_ID),
                new IdeaTitle('Title'),
                new IdeaDescription('Description')
            )
        );
    }

    public function it_is_an_aggregate(): void
    {
        $this->shouldHaveType(AggregateRoot::class);
    }

    public function it_can_be_a_string(): void
    {
        $this->__toString()->shouldBe('Title');
    }

    public function it_has_an_idea_id(): void
    {
        $this->ideaId()->shouldBeLike(new IdeaId(self::IDEA_ID));
    }

    public function it_has_a_group_id(): void
    {
        $this->groupId()->shouldBeLike(new GroupId(self::GROUP_ID));
    }

    public function it_is_pending_by_default(): void
    {
        $this->status()->shouldBeLike(IdeaStatus::PENDING());
    }

    public function it_has_a_capacity(): void
    {
        $this->capacity()->shouldBeLike(new IdeaCapacity());
    }

    public function it_has_a_title(): void
    {
        $this->title()->shouldBeLike(new IdeaTitle('Title'));
    }

    public function it_can_change_its_title(): void
    {
        $this->changeTitle(new IdeaTitle('Other title'));

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            IdeaTitleChanged::withData(
                new IdeaId(self::IDEA_ID),
                new IdeaTitle('Other title')
            )
        );

        $this->title()->shouldBeLike(new IdeaTitle('Other title'));
    }

    public function it_not_change_its_title_when_it_is_the_same(): void
    {
        $this->changeTitle(new IdeaTitle('Title'));

        (new AggregateAsserter())->assertAggregateHasNotProducedEvent(
            $this->getWrappedObject(),
            IdeaTitleChanged::withData(
                new IdeaId(self::IDEA_ID),
                new IdeaTitle('Title')
            )
        );
    }

    public function it_has_an_description(): void
    {
        $this->description()->shouldBeLike(new IdeaDescription('Description'));
    }

    public function it_can_change_its_description(): void
    {
        $this->redescribe(new IdeaDescription('Other description'));

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            IdeaRedescribed::withData(
                new IdeaId(self::IDEA_ID),
                new IdeaDescription('Other description')
            )
        );

        $this->description()->shouldBeLike(new IdeaDescription('Other description'));
    }

    public function it_not_change_its_description_when_it_is_the_same(): void
    {
        $this->redescribe(new IdeaDescription('Description'));

        (new AggregateAsserter())->assertAggregateHasNotProducedEvent(
            $this->getWrappedObject(),
            IdeaRedescribed::withData(
                new IdeaId(self::IDEA_ID),
                new IdeaDescription('Description')
            )
        );
    }

    public function it_can_be_accepted(): void
    {
        $this->accept();

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            IdeaAccepted::withData(
                new IdeaId(self::IDEA_ID)
            )
        );

        $this->status()->shouldBeLike(IdeaStatus::ACCEPTED());
    }

    public function it_can_be_rejected(): void
    {
        $this->reject();

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            IdeaRejected::withData(
                new IdeaId(self::IDEA_ID)
            )
        );

        $this->status()->shouldBeLike(IdeaStatus::REJECTED());
    }

    public function it_can_add_comments(): void
    {
        $comment = $this->addComment(
            new CommentId(self::COMMENT_ID),
            new UserId(self::USER_ID),
            new CommentText('Text')
        );

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $comment->getWrappedObject(),
            CommentAdded::withData(
                new CommentId(self::COMMENT_ID),
                new IdeaId(self::IDEA_ID),
                new UserId(self::USER_ID),
                new CommentText('Text')
            )
        );
    }

    public function it_can_check_if_attendee_is_registered()
    {
        $this->registerAttendee(
            new UserId(self::USER_ID)
        );

        $this->isAttendeeRegistered(new UserId(self::USER_ID))->shouldBe(true);
    }

    public function it_can_register_attendees(): void
    {
        $capacity = $this->capacity()->getWrappedObject();

        $this->registerAttendee(
            new UserId(self::USER_ID)
        );

        $this->capacity()->count()->shouldBe($capacity->count() + 1);
        $this->isAttendeeRegistered(new UserId(self::USER_ID))->shouldBe(true);

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            IdeaAttendeeRegistered::withData(
                new IdeaId(self::IDEA_ID),
                new UserId(self::USER_ID)
            )
        );
    }

    public function it_can_not_register_attendees_twice(): void
    {
        $capacity = $this->capacity()->getWrappedObject();

        $this->registerAttendee(
            new UserId(self::USER_ID)
        );
        $this->registerAttendee(
            new UserId(self::USER_ID)
        );

        $this->capacity()->count()->shouldBe($capacity->count() + 1);
    }

    public function it_can_unregister_attendees(): void
    {
        $capacity = $this->capacity()->getWrappedObject();

        $this->registerAttendee(
            new UserId(self::USER_ID)
        );

        $this->unregisterAttendee(
            new UserId(self::USER_ID)
        );
        $this->capacity()->count()->shouldBe($capacity->count());
        $this->isAttendeeRegistered(new UserId(self::USER_ID))->shouldBe(false);

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            IdeaAttendeeUnregistered::withData(
                new IdeaId(self::IDEA_ID),
                new UserId(self::USER_ID)
            )
        );
    }

    public function it_can_not_unregister_attendees_does_not_exists(): void
    {
        $capacity = $this->capacity()->getWrappedObject();

        $this->unregisterAttendee(
            new UserId(self::USER_ID)
        );

        $this->capacity()->count()->shouldBe($capacity->count());
    }

    public function its_capacity_can_be_unlimited(): void
    {
        $this->capacityUnlimited();

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            IdeaCapacityUnlimited::withData(
                new IdeaId(self::IDEA_ID)
            )
        );
    }

    public function its_capacity_can_be_limited(): void
    {
        $this->capacityLimited(self::CAPACITY_LIMIT);

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            IdeaCapacityLimited::withData(
                new IdeaId(self::IDEA_ID),
                self::CAPACITY_LIMIT
            )
        );
    }
}
