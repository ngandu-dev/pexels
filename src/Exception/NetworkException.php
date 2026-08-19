<?php

declare(strict_types=1);

namespace Ngandu\Pexels\Exception;

use Exception;
use Throwable;

/**
 * Class NetworkException.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 * @template T
 * @phpstan-template T
 */
class NetworkException extends Exception
{
    public function __construct(
        string $message,
        public ?int $status = null,
        public ?Throwable $previous = null
    ) {
        parent::__construct($message, previous: $this->previous);
    }

    public static function create(string $message, int $status, ?Throwable $previous = null): self
    {
        $message = $message === '' || $message === '0' ? 'No message was provided' : $message;
        return match (true) {
            $status === 401 || $status === 429 => new AccountException($message, $status, $previous),
            $status >= 400 && $status <= 499 => new ClientException($message, $status, $previous),
            $status >= 500 && $status <= 599 => new ServerException($message, $status, $previous),
            default => new self($message, $status, $previous)
        };
    }
}
