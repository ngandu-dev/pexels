<?php

declare(strict_types=1);

namespace Ngandu\Pexels\Data;

/**
 * class Video.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
final class Video extends Resource
{
    /**
     * @var string URL to a screenshot of the video.
     */
    public string $image;

    /**
     * @var int The duration of the video in seconds.
     */
    public int $duration;

    /**
     * @var User The videographer who shot the video.
     */
    public User $user;

    /**
     * @var VideoFile[] An array of different sized versions of the video.
     */
    public array $video_files;

    /**
     * @var VideoPicture[] An array of preview pictures of the video.
     */
    public array $video_pictures;

    public array $tags = [];

    public ?string $full_res = null;

    public function setUser(array $data): void
    {
        $this->user = User::fromArray($data);
    }

    public function setVideoFiles(array $files): void
    {
        $this->video_files = [];
        foreach ($files as $file) {
            $this->video_files[] = VideoFile::fromArray($file);
        }
    }

    public function setVideoPictures(array $pictures): void
    {
        $this->video_pictures = [];
        foreach ($pictures as $picture) {
            $this->video_pictures[] = VideoPicture::fromArray($picture);
        }
    }
}
