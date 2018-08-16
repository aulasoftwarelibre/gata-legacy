namespace AulaSoftwareLibre\Gata\Domain\Group\Model {
    data GroupId = GroupId deriving (Uuid);
    data GroupName = String deriving (ToString, FromString, Equals);
}

namespace AulaSoftwareLibre\Gata\Domain\Group\Event {
    data GroupWasAdded = GroupWasAdded {
        \AulaSoftwareLibre\Gata\Domain\Group\Model\GroupId $groupId,
        \AulaSoftwareLibre\Gata\Domain\Group\Model\GroupName $name,
    } deriving (AggregateChanged);

    data GroupWasRenamed = GroupWasRenamed {
         \AulaSoftwareLibre\Gata\Domain\Group\Model\GroupId $groupId,
         \AulaSoftwareLibre\Gata\Domain\Group\Model\GroupName $name,
    } deriving (AggregateChanged);
}

namespace AulaSoftwareLibre\Gata\Application\Group\Command {
    data AddGroup = AddGroup {
        \AulaSoftwareLibre\Gata\Domain\Group\Model\GroupId $groupId,
        \AulaSoftwareLibre\Gata\Domain\Group\Model\GroupName $name,
    } deriving (Command);

    data RenameGroup = RenameGroup {
         \AulaSoftwareLibre\Gata\Domain\Group\Model\GroupId $groupId,
         \AulaSoftwareLibre\Gata\Domain\Group\Model\GroupName $name,
    } deriving (Command);
}
