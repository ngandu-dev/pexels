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
use PHPUnit\Framework\TestCase;
use ReflectionClass;
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
        $pexels = $this->getPexels(fn ($method, $url, $options): MockResponse => $this->getResponse('search_videos.json'));

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
        $pexels = $this->getPexels(fn ($method, $url, $options): MockResponse => $this->getResponse('video.json'));

        $videos = $pexels->video(33);

        $this->assertInstanceOf(Video::class, $videos);
    }

    public function testPopularVideos(): void
    {
        $pexels = $this->getPexels(fn ($method, $url, $options): MockResponse => $this->getResponse('popular_videos.json'));

        $videos = $pexels->popularVideos();

        $this->assertInstanceOf(Videos::class, $videos);
        $this->assertContainsOnlyInstancesOf(Video::class, $videos->videos);
    }

    public function curatedPhotos(): void
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

    private function getPexels(callable|MockResponse $mock): Client
    {
        $pexels = new Client('your_token');
        $this->setValue($pexels, 'http', new MockHttpClient($mock));

        /** @var Client $pexels */
        return $pexels;
    }

    private function getResponse(string $file): MockResponse
    {
        return new MockResponse((string) file_get_contents(__DIR__ . ('/responses/' . $file)));
    }

    private function setValue(object &$object, string $propertyName, mixed $value): void
    {
        $reflectionClass = new ReflectionClass($object);

        if ($reflectionClass->getProperty($propertyName)->isReadOnly()) {
            $mutable = $reflectionClass->newInstanceWithoutConstructor();

            foreach ($reflectionClass->getProperties() as $property) {
                if ($property->isInitialized($object) && $property->name != $propertyName) {
                    $reflectionClass->getProperty($property->name)->setValue($mutable, $property->getValue($object));
                }
            }

            $object = $mutable;
        }

        $reflectionClass->getProperty($propertyName)->setValue($object, $value);
    }
}
