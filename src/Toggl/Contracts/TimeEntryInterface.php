<?php

namespace App\Toggl\Contracts;

use App\Toggl\TogglClientException;
use DateTimeInterface;

/**
 * Interface TimeEntryInterface
 *
 * @package App\Toggl\Contracts
 */
interface TimeEntryInterface
{

    /**
     * @param DateTimeInterface $from
     * @param DateTimeInterface $to
     *
     * @return array
     * @throws TogglClientException
     */
    public function list(DateTimeInterface $from, DateTimeInterface $to): array;
    public function start(string $description, array $tags = []): array;
    public function stop(int $id): array;
    public function retrieve(int $id): array;
    public function remove(int $id): array;
    public function update(int $id, array $data): array;
    public function getRunning(): array;
    public function bulkAddTags(array $ids, array $tags): array;
    public function bulkRemoveTags(array $ids, array $tags): array;
}
