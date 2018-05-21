<?php

declare(strict_types=1);

namespace App\Domain\Comment\Exception;

use DomainException;

final class EmptyCommentTextException extends DomainException
{
}