<?php

namespace App\Toggl\EndPoints;

use App\Toggl\AbstractClient;
use App\Toggl\Contracts\TimeEntryInterface;
use App\Toggl\TogglClientException;
use DateTimeInterface;

/**
 * Class TimeEntry
 *
 * @package App\Toggl
 */
class TimeEntry extends AbstractClient implements TimeEntryInterface
{
    protected static string $endpointUri = '/api/v8/time_entries';

    /**
     * @param DateTimeInterface $from
     * @param DateTimeInterface $to
     *
     * @return array
     * @throws TogglClientException
     */
    public function list(DateTimeInterface $from, DateTimeInterface $to): array
    {
        return $this->get(['start_date' => $from->format('c'), 'end_date' => $to->format('c')]);
    }

    /**
     * @throws TogglClientException
     */
    public function start(string $description, array $tags = []): array
    {
        return $this->post(['description' => $description, 'tags' => $tags]);
    }

    /**
     * @throws TogglClientException
     */
    public function stop(int $id): array
    {
        return $this->put([], sprintf("%s/%s/stop", self::$endpointUri, $id));
    }

    /**
     * @throws TogglClientException
     */
    public function retrieve(int $id): array
    {
        return $this->get([], sprintf("%s/%s", self::$endpointUri, $id));
    }

    /**
     * @throws TogglClientException
     */
    public function remove(int $id): array
    {
        return $this->delete(sprintf("%s/%s", self::$endpointUri, $id));
    }

    /**
     * @throws TogglClientException
     */
    public function update(int $id, array $data): array
    {
        return $this->put($data, sprintf("%s/%s", self::$endpointUri, $id));
    }

    /**
     * @throws TogglClientException
     */
    public function getRunning(): array
    {
        return $this->get([], sprintf("%s/current", self::$endpointUri));
    }

    /**
     * @throws TogglClientException
     */
    public function bulkAddTags(array $ids, array $tags): array
    {
        return $this->put(['time_entry' => ['tags' => $tags], 'tag_action' => 'add'], sprintf('%s/%s', self::$endpointUri, implode(',', $ids)));
    }

    /**
     * @throws TogglClientException
     */
    public function bulkRemoveTags(array $ids, array $tags): array
    {
        return $this->put(['time_entry' => ['tags' => $tags], 'tag_action' => 'remove'], sprintf('%s/%s', self::$endpointUri, implode(',', $ids)));
    }
}
