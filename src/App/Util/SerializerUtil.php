<?php

declare(strict_types=1);

namespace App\Util;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Serializer
 */
class SerializerUtil
{
    public static function buildSerializer()
    {
        $encoder = [new JsonEncoder()];
        $normalizer = [new ObjectNormalizer()];
        return new Serializer($normalizer, $encoder);
    }
}
