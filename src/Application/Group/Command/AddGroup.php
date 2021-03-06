<?php

// this file is auto-generated by prolic/fpp
// don't edit this file manually

declare(strict_types=1);

/*
 * This file is part of the `gata` project.
 *
 * (c) Aula de Software Libre de la UCO <aulasoftwarelibre@uco.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AulaSoftwareLibre\Gata\Application\Group\Command;

final class AddGroup extends \Prooph\Common\Messaging\Command
{
    use \Prooph\Common\Messaging\PayloadTrait;

    public const MESSAGE_NAME = 'AulaSoftwareLibre\Gata\Application\Group\Command\AddGroup';

    protected $messageName = self::MESSAGE_NAME;

    public function groupId(): \AulaSoftwareLibre\Gata\Domain\Group\Model\GroupId
    {
        return \AulaSoftwareLibre\Gata\Domain\Group\Model\GroupId::fromString($this->payload['groupId']);
    }

    public function name(): \AulaSoftwareLibre\Gata\Domain\Group\Model\GroupName
    {
        return \AulaSoftwareLibre\Gata\Domain\Group\Model\GroupName::fromString($this->payload['name']);
    }

    public static function with(\AulaSoftwareLibre\Gata\Domain\Group\Model\GroupId $groupId, \AulaSoftwareLibre\Gata\Domain\Group\Model\GroupName $name): AddGroup
    {
        return new self([
            'groupId' => $groupId->toString(),
            'name' => $name->toString(),
        ]);
    }

    protected function setPayload(array $payload): void
    {
        if (!isset($payload['groupId']) || !\is_string($payload['groupId'])) {
            throw new \InvalidArgumentException("Key 'groupId' is missing in payload or is not a string");
        }

        if (!isset($payload['name']) || !\is_string($payload['name'])) {
            throw new \InvalidArgumentException("Key 'name' is missing in payload or is not a string");
        }

        $this->payload = $payload;
    }
}
