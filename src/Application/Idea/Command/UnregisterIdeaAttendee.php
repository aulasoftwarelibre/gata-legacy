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

namespace App\Application\Idea\Command;

use App\Domain\Idea\Model\IdeaId;
use App\Domain\User\Model\UserId;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;

final class UnregisterIdeaAttendee extends Command
{
    use PayloadTrait;

    public static function create(IdeaId $ideaId, UserId $userId): self
    {
        return new self([
            'ideaId' => $ideaId->value(),
            'userId' => $userId->value(),
        ]);
    }

    public function ideaId(): IdeaId
    {
        return new IdeaId($this->payload()['ideaId']);
    }

    public function userId(): UserId
    {
        return new UserId($this->payload()['userId']);
    }
}
