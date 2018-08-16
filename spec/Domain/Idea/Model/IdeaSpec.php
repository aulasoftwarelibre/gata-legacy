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

namespace spec\AulaSoftwareLibre\Gata\Domain\Idea\Model;

use AulaSoftwareLibre\DDD\TestsBundle\Service\Prooph\Spec\AggregateAsserter;
use AulaSoftwareLibre\Gata\Domain\Comment\Event\CommentAdded;
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
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaCapacity;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaDescription;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaStatus;
use AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaTitle;
use AulaSoftwareLibre\Gata\Domain\User\Model\UserId;
use PhpSpec\ObjectBehavior;
use Prooph\EventSourcing\AggregateRoot;

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
            IdeaId::fromString(self::IDEA_ID),
            GroupId::fromString(self::GROUP_ID),
            IdeaTitle::fromString('Title'),
            IdeaDescription::fromString('Description'),
        ]);

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            IdeaWasAdded::with(
                IdeaId::fromString(self::IDEA_ID),
                GroupId::fromString(self::GROUP_ID),
                IdeaTitle::fromString('Title'),
                IdeaDescription::fromString('Description')
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
        $this->ideaId()->shouldBeLike(IdeaId::fromString(self::IDEA_ID));
    }

    public function it_has_a_group_id(): void
    {
        $this->groupId()->shouldBeLike(GroupId::fromString(self::GROUP_ID));
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
        $this->title()->shouldBeLike(IdeaTitle::fromString('Title'));
    }

    public function it_can_change_its_title(): void
    {
        $this->retitle(IdeaTitle::fromString('Other title'));

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            IdeaWasRetitled::with(
                IdeaId::fromString(self::IDEA_ID),
                IdeaTitle::fromString('Other title')
            )
        );

        $this->title()->shouldBeLike(IdeaTitle::fromString('Other title'));
    }

    public function it_not_change_its_title_when_it_is_the_same(): void
    {
        $this->retitle(IdeaTitle::fromString('Title'));

        (new AggregateAsserter())->assertAggregateHasNotProducedEvent(
            $this->getWrappedObject(),
            IdeaWasRetitled::with(
                IdeaId::fromString(self::IDEA_ID),
                IdeaTitle::fromString('Title')
            )
        );
    }

    public function it_has_an_description(): void
    {
        $this->description()->shouldBeLike(IdeaDescription::fromString('Description'));
    }

    public function it_can_change_its_description(): void
    {
        $this->redescribe(IdeaDescription::fromString('Other description'));

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            IdeaWasRedescribed::with(
                IdeaId::fromString(self::IDEA_ID),
                IdeaDescription::fromString('Other description')
            )
        );

        $this->description()->shouldBeLike(IdeaDescription::fromString('Other description'));
    }

    public function it_not_change_its_description_when_it_is_the_same(): void
    {
        $this->redescribe(IdeaDescription::fromString('Description'));

        (new AggregateAsserter())->assertAggregateHasNotProducedEvent(
            $this->getWrappedObject(),
            IdeaWasRedescribed::with(
                IdeaId::fromString(self::IDEA_ID),
                IdeaDescription::fromString('Description')
            )
        );
    }

    public function it_can_be_accepted(): void
    {
        $this->accept();

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            IdeaWasAccepted::with(
                IdeaId::fromString(self::IDEA_ID)
            )
        );

        $this->status()->shouldBeLike(IdeaStatus::ACCEPTED());
    }

    public function it_can_be_rejected(): void
    {
        $this->reject();

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            IdeaWasRejected::with(
                IdeaId::fromString(self::IDEA_ID)
            )
        );

        $this->status()->shouldBeLike(IdeaStatus::REJECTED());
    }

    public function it_can_add_comments(): void
    {
        $comment = $this->addComment(
            new CommentId(self::COMMENT_ID),
            UserId::fromString(self::USER_ID),
            new CommentText('Text')
        );

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $comment->getWrappedObject(),
            CommentAdded::withData(
                new CommentId(self::COMMENT_ID),
                IdeaId::fromString(self::IDEA_ID),
                UserId::fromString(self::USER_ID),
                new CommentText('Text')
            )
        );
    }

    public function it_can_check_if_attendee_is_registered()
    {
        $this->registerAttendee(
            UserId::fromString(self::USER_ID)
        );

        $this->isAttendeeRegistered(UserId::fromString(self::USER_ID))->shouldBe(true);
    }

    public function it_can_register_attendees(): void
    {
        $capacity = $this->capacity()->getWrappedObject();

        $this->registerAttendee(
            UserId::fromString(self::USER_ID)
        );

        $this->capacity()->count()->shouldBe($capacity->count() + 1);
        $this->isAttendeeRegistered(UserId::fromString(self::USER_ID))->shouldBe(true);

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            IdeaAttendeeWasRegistered::with(
                IdeaId::fromString(self::IDEA_ID),
                UserId::fromString(self::USER_ID)
            )
        );
    }

    public function it_can_not_register_attendees_twice(): void
    {
        $capacity = $this->capacity()->getWrappedObject();

        $this->registerAttendee(
            UserId::fromString(self::USER_ID)
        );
        $this->registerAttendee(
            UserId::fromString(self::USER_ID)
        );

        $this->capacity()->count()->shouldBe($capacity->count() + 1);
    }

    public function it_can_unregister_attendees(): void
    {
        $capacity = $this->capacity()->getWrappedObject();

        $this->registerAttendee(
            UserId::fromString(self::USER_ID)
        );

        $this->unregisterAttendee(
            UserId::fromString(self::USER_ID)
        );
        $this->capacity()->count()->shouldBe($capacity->count());
        $this->isAttendeeRegistered(UserId::fromString(self::USER_ID))->shouldBe(false);

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            IdeaAttendeeWasUnregistered::with(
                IdeaId::fromString(self::IDEA_ID),
                UserId::fromString(self::USER_ID)
            )
        );
    }

    public function it_can_not_unregister_attendees_does_not_exists(): void
    {
        $capacity = $this->capacity()->getWrappedObject();

        $this->unregisterAttendee(
            UserId::fromString(self::USER_ID)
        );

        $this->capacity()->count()->shouldBe($capacity->count());
    }

    public function its_capacity_can_be_unlimited(): void
    {
        $this->capacityUnlimited();

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            IdeaCapacityWasUnlimited::with(
                IdeaId::fromString(self::IDEA_ID)
            )
        );
    }

    public function its_capacity_can_be_limited(): void
    {
        $this->capacityLimited(self::CAPACITY_LIMIT);

        (new AggregateAsserter())->assertAggregateHasProducedEvent(
            $this->getWrappedObject(),
            IdeaCapacityWasLimited::with(
                IdeaId::fromString(self::IDEA_ID),
                self::CAPACITY_LIMIT
            )
        );
    }
}
