<?php

namespace App\Toggl;

use JsonException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class TogglClient
 *
 * @package App\Client
 */
abstract class AbstractClient
{
    /**
     * Should be overridden in all children classes
     */
    protected static string $endpointUri = "/api/v8";

    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $client;

    /**
     * AbstractClient constructor.
     *
     * @param HttpClientInterface $togglClient
     */
    public function __construct(HttpClientInterface $togglClient)
    {
        $this->client = $togglClient;

    }

    /**
     * @param array  $queryParameters
     * @param string $uri
     *
     * @return mixed
     * @throws TogglClientException
     */
    protected function get(array $queryParameters, string $uri = "")
    {
        return $this->request(
            'GET',
            sprintf(
                '%s?%s',
                $uri ?: static::$endpointUri,
                http_build_query($queryParameters)
            )
        );
    }

    /**
     * @throws TogglClientException
     */
    protected function post(array $data, string $uri = "")
    {
        return $this->request('POST', $uri, ['json' => $data]);
    }

    /**
     * @throws TogglClientException
     */
    protected function put(array $data, string $uri = "")
    {
        return $this->request('PUT', $uri, ['json' => $data]);
    }

    /**
     * @throws TogglClientException
     */
    protected function delete(string $uri = "")
    {
        return $this->request('DELETE', $uri);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $options
     *
     * @return mixed
     * @throws TogglClientException
     */
    protected function request(string $method, string $uri, array $options = [])
    {
        try {
            return json_decode(
                $this->client->request($method, $uri ?: static::$endpointUri, $options)->getContent(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException $e) {
            throw new TogglClientException('Invalid JSON', $e);
        } catch (ClientExceptionInterface $e) {
            throw new TogglClientException('Client error occurs', $e);
        } catch (RedirectionExceptionInterface $e) {
            throw new TogglClientException('Redirection error occurs', $e);
        } catch (ServerExceptionInterface $e) {
            throw new TogglClientException('Server error occurs', $e);
        } catch (TransportExceptionInterface $e) {
            throw new TogglClientException('Transport error occurs', $e);
        }
    }
}
