namespace AulaSoftwareLibre\Gata\Domain\Comment\Model {
    data CommentId = CommentId deriving (Uuid);
    data CommentText = String deriving (FromString, ToString, Equals);
}

namespace AulaSoftwareLibre\Gata\Domain\Comment\Event {
    data CommentWasAdded = CommentWasAdded {
        \AulaSoftwareLibre\Gata\Domain\Comment\Model\CommentId $commentId,
        \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId $ideaId,
        \AulaSoftwareLibre\Gata\Domain\User\Model\UserId $userId,
        \AulaSoftwareLibre\Gata\Domain\Comment\Model\CommentText $text,
    } deriving (AggregateChanged);
}

namespace AulaSoftwareLibre\Gata\Application\Comment\Command {
    data AddComment = AddComment {
         \AulaSoftwareLibre\Gata\Domain\Comment\Model\CommentId $commentId,
         \AulaSoftwareLibre\Gata\Domain\Idea\Model\IdeaId $ideaId,
         \AulaSoftwareLibre\Gata\Domain\User\Model\UserId $userId,
         \AulaSoftwareLibre\Gata\Domain\Comment\Model\CommentText $text,
    } deriving (Command);
}
