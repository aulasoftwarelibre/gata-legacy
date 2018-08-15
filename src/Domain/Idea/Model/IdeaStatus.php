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

namespace AulaSoftwareLibre\Gata\Domain\Idea\Model;

use AulaSoftwareLibre\Gata\Domain\Enum;

/**
 * @method static IdeaStatus ACCEPTED()
 * @method static IdeaStatus PENDING()
 * @method static IdeaStatus REJECTED()
 */
final class IdeaStatus extends Enum
{
    const ACCEPTED = 'accepted';
    const PENDING = 'pending';
    const REJECTED = 'rejected';
}
