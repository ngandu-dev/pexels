<?php

declare(strict_types=1);

namespace Ngandu\Pexels\Tests;

use Ngandu\Pexels\Client;
use Ngandu\Pexels\Data\Collection;
use Ngandu\Pexels\Data\CollectionMedia;
use Ngandu\Pexels\Data\Collections;
use Ngandu\Pexels\Data\Photo;
use Ngandu\Pexels\Data\Photos;
use Ngandu\Pexels\Data\Video;
use Ngandu\Pexels\Data\Videos;
use Ngandu\Pexels\Exception\AccountException;
use Ngandu\Pexels\Exception\ServerException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

/**
 * Class ClientTest.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
final class ClientTest extends TestCase
{
    public function testSearchPhotos(): void
    {
        $pexels = $this->getPexels(fn ($method, $url, $options): MockResponse => $this->getResponse('search_photos.json'));

        $photos = $pexels->searchPhotos('westie dog');

        $this->assertInstanceOf(Photos::class, $photos);
        $this->assertContainsOnlyInstancesOf(Photo::class, $photos->photos);
    }

    public function testSearchVideos(): void
    {
        $pexels = $this->getPexels(function ($method, string $url, $options): MockResponse {
            $this->assertStringEndsWith('/v1/videos/search?query=westie%20dog&locale=en-US&page=1&per_page=15', $url);
            return $this->getResponse('search_videos.json');
        });

        $videos = $pexels->searchVideos('westie dog');

        $this->assertInstanceOf(Videos::class, $videos);
        $this->assertContainsOnlyInstancesOf(Video::class, $videos->videos);
    }

    public function testPhoto(): void
    {
        $pexels = $this->getPexels(fn ($method, $url, $options): MockResponse => $this->getResponse('photo.json'));

        $photos = $pexels->photo(33);

        $this->assertInstanceOf(Photo::class, $photos);
    }

    public function testVideo(): void
    {
        $pexels = $this->getPexels(function ($method, string $url, $options): MockResponse {
            $this->assertStringEndsWith('/v1/videos/videos/33', $url);
            return $this->getResponse('video.json');
        });

        $videos = $pexels->video(33);

        $this->assertInstanceOf(Video::class, $videos);
    }

    public function testPopularVideos(): void
    {
        $pexels = $this->getPexels(function ($method, string $url, $options): MockResponse {
            $this->assertStringEndsWith('/v1/videos/popular?page=1&per_page=15', $url);
            return $this->getResponse('popular_videos.json');
        });

        $videos = $pexels->popularVideos();

        $this->assertInstanceOf(Videos::class, $videos);
        $this->assertContainsOnlyInstancesOf(Video::class, $videos->videos);
    }

    public function testCuratedPhotos(): void
    {
        $pexels = $this->getPexels(fn ($method, $url, $options): MockResponse => $this->getResponse('curated_photos.json'));

        $photos = $pexels->curatedPhotos();

        $this->assertInstanceOf(Photos::class, $photos);
        $this->assertContainsOnlyInstancesOf(Photo::class, $photos->photos);
    }

    public function testFeaturedCollections(): void
    {
        $pexels = $this->getPexels(fn ($method, $url, $options): MockResponse => $this->getResponse('featured_collections.json'));

        $collections = $pexels->featuredCollections();

        $this->assertInstanceOf(Collections::class, $collections);
        $this->assertContainsOnlyInstancesOf(Collection::class, $collections->collections);
    }

    public function testCollections(): void
    {
        $pexels = $this->getPexels(fn ($method, $url, $options): MockResponse => $this->getResponse('my_collection.json'));

        $collections = $pexels->collections();

        $this->assertInstanceOf(Collections::class, $collections);
        $this->assertContainsOnlyInstancesOf(Collection::class, $collections->collections);
    }

    public function testCollection(): void
    {
        $pexels = $this->getPexels(fn ($method, $url, $options): MockResponse => $this->getResponse('collection_media.json'));

        $collections = $pexels->collection('33');

        $this->assertInstanceOf(CollectionMedia::class, $collections);

        /** @var Photo|Video $media */
        foreach ($collections->media as $media) {
            if ($media->type === 'photo') {
                $this->assertInstanceOf(Photo::class, $media);
            }

            if ($media->type === 'video') {
                $this->assertInstanceOf(Video::class, $media);
            }
        }
    }

    public function testAccountErrorPreservesClassificationStatusAndCause(): void
    {
        $pexels = $this->getPexels(new MockResponse('{"error":"Unauthorized"}', [
            'http_code' => 401,
        ]));

        try {
            $pexels->photo(33);
            $this->fail('Expected an account exception.');
        } catch (AccountException $accountException) {
            $this->assertSame(401, $accountException->status);
            $this->assertSame('{"error":"Unauthorized"}', $accountException->getMessage());
            $this->assertNotNull($accountException->getPrevious());
        }
    }

    public function testServerErrorPreservesClassificationAndStatus(): void
    {
        $pexels = $this->getPexels(new MockResponse('Unavailable', [
            'http_code' => 503,
        ]));

        try {
            $pexels->photo(33);
            $this->fail('Expected a server exception.');
        } catch (ServerException $serverException) {
            $this->assertSame(503, $serverException->status);
            $this->assertSame('Unavailable', $serverException->getMessage());
        }
    }

    private function getPexels(callable|MockResponse $mock): Client
    {
        return new Client('your_token', http: new MockHttpClient($mock));
    }

    private function getResponse(string $file): MockResponse
    {
        return new MockResponse((string) file_get_contents(__DIR__ . ('/responses/' . $file)));
    }
}
