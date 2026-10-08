<?php

declare(strict_types=1);

namespace Ngandu\Pexels;

use Ngandu\Pexels\Data\Collection;
use Ngandu\Pexels\Data\CollectionMedia;
use Ngandu\Pexels\Data\Collections;
use Ngandu\Pexels\Data\Photo;
use Ngandu\Pexels\Data\Photos;
use Ngandu\Pexels\Data\Video;
use Ngandu\Pexels\Data\Videos;
use Ngandu\Pexels\Exception\NetworkException;
use Ngandu\Pexels\Parameter\CollectionParameters;
use Ngandu\Pexels\Parameter\PaginationParameters;
use Ngandu\Pexels\Parameter\PopularVideosParameters;
use Ngandu\Pexels\Parameter\SearchParameters;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Retry\GenericRetryStrategy;
use Symfony\Component\HttpClient\RetryableHttpClient;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface as HttpClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * class Client.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
final readonly class Client
{
    private HttpClientInterface $http;

    private Serializer $serializer;

    public function __construct(string $token, ?string $proxy = null, ?HttpClientInterface $http = null)
    {
        $this->serializer = new Serializer(normalizers: [new ObjectNormalizer()]);
        $this->http = $http ?? new RetryableHttpClient(
            client: HttpClient::createForBaseUri(
                baseUri: 'https://api.pexels.com',
                defaultOptions: [
                    'headers' => [
                        'Authorization' => $token,
                    ],
                    'proxy' => $proxy,
                ]
            ),
            strategy: new GenericRetryStrategy(delayMs: 500),
            maxRetries: 3
        );
    }

    /**
     * This endpoint enables you to search Pexels for any topic that you would like.
     * For example your query could be something broad like Nature, Tigers, People.
     * Or it could be something specific like Group of people working.
     *
     * @throws NetworkException
     */
    public function searchPhotos(string $query, SearchParameters $parameters = new SearchParameters()): Photos
    {
        /** @var Photos $mapped */
        $mapped = $this->getMappedData(Photos::class, $this->request('/v1/search', [
            'query' => $query,
            ...$parameters->toArray(),
        ]));

        return $mapped;
    }

    /**
     * This endpoint enables you to search Pexels for any topic that you would like.
     * For example your query could be something broad like Nature, Tigers, People.
     * Or it could be something specific like Group of people working.
     *
     * @throws NetworkException
     */
    public function searchVideos(string $query, SearchParameters $parameters = new SearchParameters()): Videos
    {
        /** @var Videos $mapped */
        $mapped = $this->getMappedData(Videos::class, $this->request('/v1/videos/search', [
            'query' => $query,
            ...$parameters->toArray(),
        ]));

        return $mapped;
    }

    /**
     * This endpoint enables you to receive real-time photos curated by the Pexels team.
     * We add at least one new photo per hour to our curated list
     * so that you always get a changing selection of trending photos.
     *
     * @throws NetworkException
     */
    public function curatedPhotos(PaginationParameters $parameters = new PaginationParameters()): Photos
    {
        /** @var Photos $mapped */
        $mapped = $this->getMappedData(Photos::class, $this->request('/v1/curated', $parameters->toArray()));

        return $mapped;
    }

    /**
     * This endpoint enables you to receive the current popular Pexels videos.
     *
     * @throws NetworkException
     */
    public function popularVideos(PopularVideosParameters $parameters = new PopularVideosParameters()): Videos
    {
        /** @var Videos $mapped */
        $mapped = $this->getMappedData(Videos::class, $this->request('/v1/videos/popular', $parameters->toArray()));

        return $mapped;
    }

    /**
     * Retrieve a specific Photo from its id.
     * @param int $id The id of the photo you are requesting.
     * @throws NetworkException
     */
    public function photo(int $id): Photo
    {
        /** @var Photo $photo */
        $photo = $this->serializer->denormalize($this->request('/v1/photos/' . $id), Photo::class);

        return $photo;
    }

    /**
     * Retrieve a specific Video from its id.
     * @param int $id The id of the video you are requesting.
     * @throws NetworkException
     */
    public function video(int $id): Video
    {
        /** @var Video $video */
        $video = $this->serializer->denormalize($this->request('/v1/videos/videos/' . $id), Video::class);

        return $video;
    }

    /**
     * This endpoint returns all featured collections on Pexels.
     * @throws NetworkException
     */
    public function featuredCollections(PaginationParameters $parameters = new PaginationParameters()): Collections
    {
        /** @var Collections $mapped */
        $mapped = $this->getMappedData(
            Collections::class,
            $this->request('/v1/collections/featured', $parameters->toArray())
        );

        return $mapped;
    }

    /**
     * This endpoint returns all of your collections.
     * @throws NetworkException
     */
    public function collections(PaginationParameters $parameters = new PaginationParameters()): Collections
    {
        /** @var Collections $mapped */
        $mapped = $this->getMappedData(Collections::class, $this->request('/v1/collections', $parameters->toArray()));

        return $mapped;
    }

    /**
     * This endpoint returns all the media (photos and videos) within a single collection.
     * You can filter to only receive photos or videos using the type parameter.
     *
     * @throws NetworkException
     */
    public function collection(string $id, CollectionParameters $parameters = new CollectionParameters()): CollectionMedia
    {
        /** @var CollectionMedia $mapped */
        $mapped = $this->getMappedData(
            CollectionMedia::class,
            $this->request('/v1/collections/' . $id, $parameters->toArray())
        );

        return $mapped;
    }

    /**
     * @throws NetworkException
     */
    private function createExceptionFromResponse(HttpClientExceptionInterface $exception): never
    {
        if ($exception instanceof HttpExceptionInterface) {
            $response = $exception->getResponse();
            throw NetworkException::create(
                message: $response->getContent(false),
                status: $response->getStatusCode(),
                previous: $exception
            );
        }

        throw new NetworkException($exception->getMessage(), previous: $exception);
    }

    /**
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     * @throws NetworkException
     */
    private function request(string $path, array $query = []): array
    {
        try {
            return $this->http->request('GET', $path, [
                'query' => $query,
            ])->toArray();
        } catch (HttpClientExceptionInterface $httpClientException) {
            $this->createExceptionFromResponse($httpClientException);
        }
    }

    /**
     * @throws ExceptionInterface
     * @param array<string, mixed> $data
     */
    private function getMappedData(string $type, array $data): Photos|Videos|Collections|CollectionMedia
    {
        /** @var Photos|Videos|Collections|CollectionMedia $mapped */
        $mapped = $this->serializer->denormalize($data, $type);

        match (true) {
            $mapped instanceof Photos => $mapped->photos = array_map(
                fn (mixed $m): mixed => $this->serializer->denormalize($m, type: Photo::class),
                $this->getArrayData($data, 'photos')
            ),
            $mapped instanceof Videos => $mapped->videos = array_map(
                fn (mixed $m): mixed => $this->serializer->denormalize($m, type: Video::class),
                $this->getArrayData($data, 'videos')
            ),
            $mapped instanceof Collections => $mapped->collections = array_map(
                fn (mixed $m): mixed => $this->serializer->denormalize($m, type: Collection::class),
                $this->getArrayData($data, 'collections')
            ),
            $mapped instanceof CollectionMedia => $mapped->media = array_map(
                fn (mixed $m): mixed => $this->serializer->denormalize(
                    data: is_array($m) ? $m : [],
                    type: is_array($m) && \in_array($m['type'] ?? null, ['Photo', 'photo'], true) ? Photo::class : Video::class
                ),
                $this->getArrayData($data, 'media')
            )
        };

        return $mapped;
    }

    /**
     * @param array<string, mixed> $data
     * @return array<int, mixed>
     */
    private function getArrayData(array $data, string $key): array
    {
        $value = $data[$key] ?? [];

        if (! is_array($value)) {
            return [];
        }

        return array_values($value);
    }
}
