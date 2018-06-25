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

namespace App\Infrastructure\ReadModel\Group\View;

final class GroupView
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $name;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function rename(string $name): void
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}
