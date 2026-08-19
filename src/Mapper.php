<?php

declare(strict_types=1);

namespace Ngandu\Pexels;

use ReflectionClass;

/**
 * class Mapper.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
abstract class Mapper
{
    public static function toObject(object $object, array $data): object
    {
        foreach ($data as $k => $v) {
            $object->{$k} = $v;
        }

        return $object;
    }

    /**
     * @param array<string, mixed> $array
     */
    public static function toArray(array $array, object $data): array
    {
        $reflection = new ReflectionClass($data);
        foreach ($reflection->getProperties() as $property) {
            $array[$property->getName()] = $property->getValue($data);
        }

        return $array;
    }
}
