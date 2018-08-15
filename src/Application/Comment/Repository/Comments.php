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

namespace AulaSoftwareLibre\Gata\Application\Comment\Repository;

use AulaSoftwareLibre\Gata\Domain\Comment\Model\Comment;
use AulaSoftwareLibre\Gata\Domain\Comment\Model\CommentId;

interface Comments
{
    public function save(Comment $comment): void;

    public function get(CommentId $commentId): ?Comment;

    public function nextIdentity(): CommentId;
}
