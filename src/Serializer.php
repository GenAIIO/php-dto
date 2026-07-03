<?php

namespace GenAI\Dto;

/**
 * Turns a value into a JSON-encodable form — objects to arrays, recursively —
 * which the caller then json_encode()s. The contract the web Dispatcher type-hints
 * for its REST result hook, so any implementation can plug in.
 *
 * MapSerializer is the built-in implementation (driven by the compiled #[Dto] map).
 *
 * Compatible with PHP 5.3.29.
 */
interface Serializer
{
    /**
     * @param mixed $value a DTO, an array, a scalar, or a nested mix
     * @return mixed JSON-encodable value (objects turned into arrays)
     */
    public function serialize($value);
}
