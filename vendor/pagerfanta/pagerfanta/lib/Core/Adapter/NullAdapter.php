<?php declare(strict_types=1);

namespace Pagerfanta\Adapter;

/**
 * Adapter which generates a null item list based on a number of results.
 *
 * @implements AdapterInterface<null>
 */
class NullAdapter implements AdapterInterface
{
    /**
     * @param int<0, max> $nbResults
     */
    public function __construct(
        private readonly int $nbResults = 0,
    ) {}

    /**
     * @return int<0, max>
     */
    public function getNbResults(): int
    {
        return $this->nbResults;
    }

    /**
     * The following methods are derived from code of the Zend Framework
     * Code subject to the new BSD license (http://framework.zend.com/license/new-bsd).
     *
     * Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
     *
     * @param int<0, max> $offset
     * @param int<0, max> $length
     *
     * @return iterable<array-key, null>
     */
    public function getSlice(int $offset, int $length): iterable
    {
        if ($offset >= $this->nbResults) {
            return [];
        }

        return $this->createNullArray($this->calculateNullArrayLength($offset, $length));
    }

    /**
     * @param int<0, max> $offset
     * @param int<0, max> $length
     *
     * @return int<0, max>
     */
    private function calculateNullArrayLength(int $offset, int $length): int
    {
        $remainCount = $this->remainCount($offset);

        if ($length > $remainCount) {
            return $remainCount;
        }

        return $length;
    }

    /**
     * @param int<0, max> $offset
     *
     * @return int<0, max>
     */
    private function remainCount(int $offset): int
    {
        return max(0, $this->nbResults - $offset);
    }

    /**
     * @param int<0, max> $length
     *
     * @return array<int, null>
     */
    private function createNullArray(int $length): array
    {
        return array_fill(0, $length, null);
    }
}
