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

namespace Tests\Behat\Context\Hook;

use Behat\Behat\Context\Context;

class DatabaseContext implements Context
{
    /**
     * @var array
     */
    private $inMemoryRepositories;

    public function __construct(array $inMemoryRepositories)
    {
        $this->inMemoryRepositories = $inMemoryRepositories;
    }

    /**
     * @AfterScenario
     */
    public function reset()
    {
        foreach ($this->inMemoryRepositories as $inMemoryRepository) {
            $inMemoryRepository->reset();
        }
    }
}
