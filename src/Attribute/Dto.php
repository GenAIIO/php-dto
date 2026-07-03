<?php

namespace GenAI\Dto\Attribute;

/**
 * Marks a value object whose public getters should be serialized to JSON. The
 * DtoProcessor reflects the getters at build time and compiles a field => getter
 * map (dto.php); the Serializer uses that map to turn the DTO into an array — no
 * runtime reflection, and the DTO keeps its private properties (plain json_encode
 * of one would yield {}, and JsonSerializable is PHP 5.4+).
 *
 * Just a marker — NOT a bean — so it extends nothing.
 *
 * Build-time only (PHP 8); a comment on the PHP 5.3 runtime.
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class Dto
{
}
