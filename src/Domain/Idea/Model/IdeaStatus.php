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

namespace App\Domain\Idea\Model;

use App\Domain\Idea\Exception\InvalidIdeaStatusException;

class IdeaStatus
{
    const ACCEPTED = 'accepted';
    const PENDING = 'pending';
    const REJECTED = 'rejected';

    /**
     * @var string
     */
    private $status;

    public function __construct(string $status)
    {
        if (!in_array($status, [
            self::ACCEPTED,
            self::PENDING,
            self::REJECTED,
        ], true)) {
            throw new InvalidIdeaStatusException();
        }

        $this->status = $status;
    }

    public function __toString(): string
    {
        return $this->status();
    }

    public function status(): string
    {
        return $this->status;
    }

    public function equals(self $status): bool
    {
        return $this->status() === $status->status();
    }
}
