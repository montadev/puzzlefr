<?php declare(strict_types=1);

namespace Pagerfanta;

use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Exception\InvalidArgumentException;
use Pagerfanta\Exception\LessThan1CurrentPageException;
use Pagerfanta\Exception\LessThan1MaxPagesException;
use Pagerfanta\Exception\LessThan1MaxPerPageException;
use Pagerfanta\Exception\LogicException;
use Pagerfanta\Exception\OutOfBoundsException;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;

/**
 * @template T
 *
 * @implements PagerfantaInterface<T>
 */
class Pagerfanta implements PagerfantaInterface, \JsonSerializable
{
    private bool $allowOutOfRangePages = false;
    private bool $normalizeOutOfRangePages = false;

    /**
     * @var positive-int
     */
    private int $maxPerPage = 10;

    /**
     * @var positive-int
     */
    private int $currentPage = 1;

    /**
     * @var int<0, max>|null
     */
    private ?int $nbResults = null;

    /**
     * @var positive-int|null
     */
    private ?int $maxNbPages = null;

    /**
     * @var iterable<array-key, T>|null
     */
    private ?iterable $currentPageResults = null;

    /**
     * @param AdapterInterface<T> $adapter
     */
    public function __construct(
        private readonly AdapterInterface $adapter,
    ) {}

    /**
     * @param AdapterInterface<T> $adapter
     *
     * @psalm-param AdapterInterface<mixed> $adapter
     *
     * @return self<T>
     */
    public static function createForCurrentPageWithMaxPerPage(AdapterInterface $adapter, int $currentPage, int $maxPerPage): self
    {
        $pagerfanta = new self($adapter);
        $pagerfanta->setMaxPerPage($maxPerPage);
        $pagerfanta->setCurrentPage($currentPage);

        return $pagerfanta;
    }

    /**
     * @return AdapterInterface<T>
     */
    public function getAdapter(): AdapterInterface
    {
        return $this->adapter;
    }

    /**
     * @return $this
     *
     * @phpstan-self-out self<T>
     */
    public function setAllowOutOfRangePages(bool $allowOutOfRangePages): PagerfantaInterface
    {
        $this->allowOutOfRangePages = $allowOutOfRangePages;

        return $this;
    }

    public function getAllowOutOfRangePages(): bool
    {
        return $this->allowOutOfRangePages;
    }

    /**
     * @return $this
     *
     * @phpstan-self-out self<T>
     */
    public function setNormalizeOutOfRangePages(bool $normalizeOutOfRangePages): PagerfantaInterface
    {
        $this->normalizeOutOfRangePages = $normalizeOutOfRangePages;

        return $this;
    }

    public function getNormalizeOutOfRangePages(): bool
    {
        return $this->normalizeOutOfRangePages;
    }

    /**
     * @return $this
     *
     * @phpstan-self-out self<T>
     *
     * @throws LessThan1MaxPerPageException if the page is less than 1
     */
    public function setMaxPerPage(int $maxPerPage): PagerfantaInterface
    {
        $this->filterMaxPerPage($maxPerPage);

        \assert($maxPerPage > 0);

        $this->maxPerPage = $maxPerPage;

        $this->resetForMaxPerPageChange();
        $this->filterOutOfRangeCurrentPage($this->currentPage);

        return $this;
    }

    private function filterMaxPerPage(int $maxPerPage): void
    {
        $this->checkMaxPerPage($maxPerPage);
    }

    /**
     * @throws LessThan1MaxPerPageException if the page is less than 1
     */
    private function checkMaxPerPage(int $maxPerPage): void
    {
        if ($maxPerPage < 1) {
            throw new LessThan1MaxPerPageException();
        }
    }

    private function resetForMaxPerPageChange(): void
    {
        $this->currentPageResults = null;
    }

    /**
     * @return positive-int
     */
    public function getMaxPerPage(): int
    {
        return $this->maxPerPage;
    }

    /**
     * @return $this
     *
     * @phpstan-self-out self<T>
     *
     * @throws LessThan1CurrentPageException  if the current page is less than 1
     * @throws OutOfRangeCurrentPageException if It is not allowed out of range pages and they are not normalized
     */
    public function setCurrentPage(int $currentPage): PagerfantaInterface
    {
        $this->currentPage = $this->filterCurrentPage($currentPage);
        $this->resetForCurrentPageChange();

        return $this;
    }

    /**
     * @return positive-int
     */
    private function filterCurrentPage(int $currentPage): int
    {
        $this->checkCurrentPage($currentPage);

        \assert($currentPage > 0);

        return $this->filterOutOfRangeCurrentPage($currentPage);
    }

    /**
     * @throws LessThan1CurrentPageException if the current page is less than 1
     */
    private function checkCurrentPage(int $currentPage): void
    {
        if ($currentPage < 1) {
            throw new LessThan1CurrentPageException();
        }
    }

    /**
     * @param positive-int $currentPage
     *
     * @return positive-int
     */
    private function filterOutOfRangeCurrentPage(int $currentPage): int
    {
        if ($this->notAllowedCurrentPageOutOfRange($currentPage)) {
            return $this->normalizeOutOfRangeCurrentPage($currentPage);
        }

        return $currentPage;
    }

    private function notAllowedCurrentPageOutOfRange(int $currentPage): bool
    {
        return !$this->getAllowOutOfRangePages() && $this->currentPageOutOfRange($currentPage);
    }

    private function currentPageOutOfRange(int $currentPage): bool
    {
        return $currentPage > 1 && $currentPage > $this->getNbPages();
    }

    /**
     * @return positive-int
     *
     * @throws OutOfRangeCurrentPageException if the page should not be normalized
     */
    private function normalizeOutOfRangeCurrentPage(int $currentPage): int
    {
        if ($this->getNormalizeOutOfRangePages()) {
            return $this->getNbPages();
        }

        throw new OutOfRangeCurrentPageException(\sprintf('Page "%d" does not exist. The currentPage must be inferior to "%d"', $currentPage, $this->getNbPages()));
    }

    private function resetForCurrentPageChange(): void
    {
        $this->currentPageResults = null;
    }

    /**
     * @return positive-int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return iterable<array-key, T>
     */
    public function getCurrentPageResults(): iterable
    {
        return $this->currentPageResults ??= $this->getCurrentPageResultsFromAdapter();
    }

    /**
     * @return iterable<array-key, T>
     */
    private function getCurrentPageResultsFromAdapter(): iterable
    {
        $offset = $this->calculateOffsetForCurrentPageResults();
        $length = $this->getMaxPerPage();

        return $this->getAdapter()->getSlice($offset, $length);
    }

    /**
     * @return int<0, max>
     */
    private function calculateOffsetForCurrentPageResults(): int
    {
        return ($this->getCurrentPage() - 1) * $this->getMaxPerPage();
    }

    /**
     * @return int<0, max>
     */
    public function getCurrentPageOffsetStart(): int
    {
        return 0 !== $this->getNbResults() ? $this->calculateOffsetForCurrentPageResults() + 1 : 0;
    }

    /**
     * @return int<0, max>
     */
    public function getCurrentPageOffsetEnd(): int
    {
        return $this->hasNextPage() ? $this->getCurrentPage() * $this->getMaxPerPage() : $this->getNbResults();
    }

    /**
     * @return int<0, max>
     */
    public function getNbResults(): int
    {
        return $this->nbResults ??= $this->getAdapter()->getNbResults();
    }

    /**
     * @return positive-int
     */
    public function getNbPages(): int
    {
        $nbPages = $this->calculateNbPages();

        if (0 === $nbPages) {
            return $this->minimumNbPages();
        }

        if (null !== $this->maxNbPages && $this->maxNbPages < $nbPages) {
            return $this->maxNbPages;
        }

        return $nbPages;
    }

    /**
     * @return int<0, max>
     */
    private function calculateNbPages(): int
    {
        return (int) ceil($this->getNbResults() / $this->getMaxPerPage());
    }

    /**
     * @return positive-int
     */
    private function minimumNbPages(): int
    {
        return 1;
    }

    /**
     * @return $this
     *
     * @phpstan-self-out self<T>
     *
     * @throws LessThan1MaxPagesException if the max number of pages is less than 1
     */
    public function setMaxNbPages(int $maxNbPages): PagerfantaInterface
    {
        if ($maxNbPages < 1) {
            throw new LessThan1MaxPagesException();
        }

        $this->maxNbPages = $maxNbPages;

        return $this;
    }

    /**
     * @return $this
     *
     * @phpstan-self-out self<T>
     */
    public function resetMaxNbPages(): PagerfantaInterface
    {
        $this->maxNbPages = null;

        return $this;
    }

    public function haveToPaginate(): bool
    {
        return $this->getNbResults() > $this->maxPerPage;
    }

    public function hasPreviousPage(): bool
    {
        return $this->currentPage > 1;
    }

    /**
     * @return positive-int
     *
     * @throws LogicException if there is no previous page
     */
    public function getPreviousPage(): int
    {
        if (!$this->hasPreviousPage()) {
            throw new LogicException('There is no previous page.');
        }

        \assert($this->currentPage > 1);

        return $this->currentPage - 1;
    }

    public function hasNextPage(): bool
    {
        return $this->currentPage < $this->getNbPages();
    }

    /**
     * @return positive-int
     *
     * @throws LogicException if there is no next page
     */
    public function getNextPage(): int
    {
        if (!$this->hasNextPage()) {
            throw new LogicException('There is no next page.');
        }

        return $this->currentPage + 1;
    }

    /**
     * @return int<0, max>
     */
    public function count(): int
    {
        return $this->getNbResults();
    }

    /**
     * @return \Traversable<array-key, T>
     *
     * @throws InvalidArgumentException if an iterator cannot be created from the adapter slice
     */
    public function getIterator(): \Traversable
    {
        $results = $this->getCurrentPageResults();

        if ($results instanceof \Iterator) {
            return $results;
        }

        if ($results instanceof \IteratorAggregate) {
            return $results->getIterator();
        }

        if (\is_array($results)) {
            return new \ArrayIterator($results);
        }

        throw new InvalidArgumentException(\sprintf('Cannot create iterator with page results of type "%s".', get_debug_type($results)));
    }

    /**
     * @return T[]
     */
    public function jsonSerialize(): array
    {
        $results = $this->getCurrentPageResults();

        if ($results instanceof \Traversable) {
            return iterator_to_array($results);
        }

        return $results;
    }

    /**
     * Get page number of the item at specified position (1-based index).
     *
     * @param positive-int $position
     *
     * @return positive-int
     *
     * @throws OutOfBoundsException if the item is outside the result set
     */
    public function getPageNumberForItemAtPosition(int $position): int
    {
        if ($this->getNbResults() < $position) {
            throw new OutOfBoundsException(\sprintf('Item requested at position %d, but there are only %d items.', $position, $this->getNbResults()));
        }

        return (int) ceil($position / $this->getMaxPerPage());
    }

    /**
     * Generates an iterator to automatically iterate over all pages in a result set.
     *
     * @return \Generator<int, T, mixed, void>
     */
    public function autoPagingIterator(): \Generator
    {
        while (true) {
            foreach ($this->getCurrentPageResults() as $item) {
                yield $item;
            }

            if (!$this->hasNextPage()) {
                break;
            }

            $this->setCurrentPage($this->getNextPage());
        }
    }
}
