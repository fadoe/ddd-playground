<?php
declare(strict_types=1);

namespace Leos\Domain\Common\ValueObject;

use Leos\Domain\Common\Exception\InvalidUUIDException;
use Ramsey\Uuid\Uuid;

/**
 * Class AggregateRootId
 *
 * Its the unique identifier and will be auto-generated if not value is set.
 *
 * @package Leos\Domain\Common\ValueObject
 */
abstract class AggregateRootId
{
    /**
     * @var string
     */
    protected $uuid;

    /**
     * AggregateRootId constructor.
     *
     * @param null|string $id
     */
    public function __construct(string $id = null)
    {
        try {

            $this->uuid = Uuid::fromString($id ?: Uuid::uuid4())->toString();

        } catch (\InvalidArgumentException $e) {

            throw new InvalidUUIDException();
        }
    }

    /**
     * @param AggregateRootId $aggregateRootId
     * @return bool
     */
    public function equals(AggregateRootId $aggregateRootId)
    {
        return $this->uuid === $aggregateRootId->__toString();
    }

    /**
     * @return string
     */
    public function bytes(): string
    {
        return Uuid::fromString($this->uuid)->getBytes();
    }

    /**
     * @param string $bytes
     * @return AggregateRootId
     */
    public static function fromBytes(string $bytes): self
    {
        return new static(Uuid::fromBytes($bytes)->toString());
    }

    /**
     * @param string $uid
     * @return string
     */
    public static function toBytes(string $uid): string
    {
        return (new static($uid))->bytes();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->uuid;
    }
}
