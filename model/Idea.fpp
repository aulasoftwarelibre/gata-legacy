namespace AulaSoftwareLibre\Gata\Domain\Idea\Model {
    data IdeaId = IdeaId deriving (Uuid);
    data IdeaTitle = String deriving (ToString, FromString, Equals);
    data IdeaDescription = String deriving (ToString, FromString, Equals);
    data IdeaStatus = Pending | Accepted | Rejected deriving (Enum);
}

namespace AulaSoftwareLibre\Gata\Domain\Idea\Event {
    data IdeaAttendeeWasRegistered = IdeaAttendeeWasRegistered {
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId $ideaId,
        \AulaSoftwareLibre\Gata\Domain\User\Model\UserId $userId,
    } deriving (AggregateChanged);

    data IdeaAttendeeWasUnregistered = IdeaAttendeeWasUnregistered {
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId $ideaId,
        \AulaSoftwareLibre\Gata\Domain\User\Model\UserId $userId,
    } deriving (AggregateChanged);

    data IdeaCapacityWasLimited = IdeaCapacityWasLimited {
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId $ideaId,
        int $limit
    } deriving (AggregateChanged);

    data IdeaCapacityWasUnLimited = IdeaCapacityWasUnlimited {
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId $ideaId
    } deriving (AggregateChanged);

    data IdeaWasAccepted = IdeaWasAccepted {
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId $ideaId
    } deriving (AggregateChanged);

    data IdeaWasAdded = IdeaWasAdded {
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId $ideaId,
        \AulaSoftwareLibre\Gata\Domain\Group\Model\GroupId $groupId,
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaTitle $title,
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaDescription $description
    } deriving (AggregateChanged);

    data IdeaWasRedescribed = IdeaWasRedescribed {
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId $ideaId,
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaDescription $description
    } deriving (AggregateChanged);

    data IdeaWasRejected = IdeaWasRejected {
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId $ideaId
    } deriving (AggregateChanged);

    data IdeaWasRetitled = IdeaWasRetitled {
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId $ideaId,
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaTitle $title
    } deriving (AggregateChanged);
}

namespace AulaSoftwareLibre\Gata\Application\Idea\Command {
    data AcceptIdea = AcceptIdea {
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId $ideaId,
    } deriving (Command);

    data AddIdea = AddIdea {
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId $ideaId,
        \AulaSoftwareLibre\Gata\Domain\Group\Model\GroupId $groupId,
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaTitle $title,
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaDescription $description
    } deriving (Command);

    data RedescribeIdea = RedescribeIdea {
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId $ideaId,
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaDescription $description
    } deriving (Command);

    data RegisterIdeaAttendee = RegisterIdeaAttendee {
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId $ideaId,
        \AulaSoftwareLibre\Gata\Domain\User\Model\UserId $userId,
    } deriving (Command);

    data RejectIdea = RejectIdea {
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId $ideaId,
    } deriving (Command);

    data RetitleIdea = RetitleIdea {
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId $ideaId,
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaTitle $title,
    } deriving (Command);

    data UnregisterIdeaAttendee = UnregisterIdeaAttendee {
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId $ideaId,
        \AulaSoftwareLibre\Gata\Domain\User\Model\UserId $userId,
    } deriving (Command);
}
