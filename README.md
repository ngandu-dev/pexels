# Pexels PHP

[![Latest Stable Version](https://poser.pugx.org/ngandu-dev/pexels/version)](https://packagist.org/packages/ngandu-dev/pexels)
[![Total Downloads](https://poser.pugx.org/ngandu-dev/pexels/downloads)](https://packagist.org/packages/ngandu-dev/pexels)
[![Quality](https://github.com/ngandu-dev/pexels/actions/workflows/quality.yml/badge.svg)](https://github.com/ngandu-dev/pexels/actions/workflows/quality.yml)
[![Tests](https://github.com/ngandu-dev/pexels/actions/workflows/test.yml/badge.svg)](https://github.com/ngandu-dev/pexels/actions/workflows/test.yml)
[![License](https://poser.pugx.org/ngandu-dev/pexels/license)](https://packagist.org/packages/ngandu-dev/pexels)

The Pexels API enables programmatic access to the full Pexels content library, including photos, videos. All content is available free of charge, and you are welcome to use Pexels content for anything you'd like, as long as it is within our Guidelines.

## Features

- Photo and video search
- Curated and popular media
- Featured and personal collections
- Typed pagination and response objects

## Requirements

- PHP 8.4 or later
- Composer 2
- A Pexels API key

## Guidelines

Whenever you are doing an API request make sure to show a prominent link to Pexels. You can use a text link (e.g. "Photos provided by Pexels") or a link with our logo.

Always credit our photographers when possible (e.g. "Photo by John Doe on Pexels" with a link to the photo page on Pexels).

You may not copy or replicate core functionality of Pexels (including making Pexels content available as a wallpaper app).

Do not abuse the API. By default, the API is rate-limited to 200 requests per hour and 20,000 requests per month. You may contact us to request a higher limit, but please include examples, or be prepared to give a demo, that clearly shows your use of the API with attribution. If you meet our API terms, you can get unlimited requests for free.

Abuse of the Pexels API, including but not limited to attempting to work around the rate limit, will lead to termination of your API access.

## Authorization
Authorization is required for the Pexels API. Anyone with a Pexels account can [request an API key](https://www.pexels.com/api/new/), which you will receive instantly.

## Installation
```bash
composer require ngandu-dev/pexels
```

## Usage
Create an instance of the Pexels API Client by passing in your API token as parameter.

```php
// ...
use Ngandu\Pexels\Client;
// ...

$pexels = new Client(token: 'xxxxxxxxxxxxxxxxxxxxxxxxxxxx');
```

### Search for photos
This endpoint enables you to search Pexels for any topic that you would like. For example your query could be something broad like Nature, Tigers, People. Or it could be something specific like Group of people working.

```php
$photos = $pexels->searchPhotos('Tigers');

// landscape photos only
$photos = $pexels->searchPhotos('Tigers', new SearchParameters(orientation: 'landscape', page: 2))
```

### Curated photos
This endpoint enables you to receive real-time photos curated by the Pexels team.

We add at least one new photo per hour to our curated list so that you always get a changing selection of trending photos.

```php
$photos = $pexels->curatedPhotos();

// paginated
$photos = $pexels->curatedPhotos(new PaginationParameters(page: 2, per_page: 60));
```

### Get a photo
Retrieve a specific Photo from its id.

```php
$photo = $pexels->photo(id: 11762029);
```

### Search for videos
This endpoint enables you to search Pexels for any topic that you would like. For example your query could be something broad like Nature, Tigers, People. Or it could be something specific like Group of people working.

```php
$videos = $pexels->searchVideos('Tigers');

// landscape videos only
$videos = $pexels->searchVideos('Tigers', new SearchParameters(orientation: 'landscape', page: 2))
```

### Popular Videos
This endpoint enables you to receive the current popular Pexels videos.

```php
$videos = $pexels->popularVideos();

// 30 secondes popular videos
$videos =  $pexels->popularVideos(new PopularVideosParameters(min_duration: 30, max_duration: 30));
```

### Get a video
Retrieve a specific Video from its id.

```php
$video = $pexels->video(id: 12593410);
```

### Featured Collections
This endpoint returns all featured collections on Pexels.

```php
$collections = $pexels->featuredCollections();

// paginated
$collections = $pexels->featuredCollection(new PaginationParameters(per_page: 80);
```

### My Collections
This endpoint returns all of your collections.

```php
$collections = $pexels->collections();
```

### Collection media
This endpoint returns all the media (photos and videos) within a single collection. You can filter to only receive photos or videos using the type parameter.

```php
$collection = $pexels->collection(id: 'someid');

// videos only
$collection = $pexels->collection(id: 'someid', new CollectionParameters(type: 'Videos'));
```

## Pagination
Most Pexels API requests return multiple records at once. All of these endpoints are paginated, and can return a maximum of 80 requests at one time. Each paginated request accepts the same parameters and returns the same pagination data in the response.

Note: The prev_page and next_page response attributes will only be returned if there is a corresponding page.


## Development

```bash
composer install
composer format
composer quality
```

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md) before opening an issue or pull request.

## Security

Report vulnerabilities privately as described in [SECURITY.md](SECURITY.md).

## License

Released under the [MIT License](LICENSE).

## Contributors

<a href="https://github.com/ngandu-dev/pexels/graphs/contributors" title="Show all contributors">
  <img src="https://contrib.rocks/image?repo=ngandu-dev/pexels" alt="Contributors" />
</a>
