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

namespace App\Infrastructure\ReadModel;

interface SchemaManagerInterface
{
    public function init(): void;

    public function isInitialized(): bool;

    public function reset(): void;

    public function delete(): void;
}
