<?php

namespace GenAI\Dto;

/**
 * The built-in Serializer: turns #[Dto] objects into arrays using the compiled
 * getter map (dto.php), so a private-property DTO serializes to JSON correctly.
 * Recurses, so a DTO, an array of DTOs, or a nested mix all work. Scalars, plain
 * arrays and unmapped objects pass through unchanged.
 *
 *   $s = new MapSerializer();
 *   $s->loadMap(__DIR__ . '/cache/dto.php');
 *   json_encode($s->serialize($user));   // {"id":1,"name":"Alice"}
 *
 * Reflection-free: the getter names come from the build-time map, invoked as
 * variable method calls. Compatible with PHP 5.3.29.
 */
class MapSerializer implements Serializer
{
    /** @var array class => (field => getter method) */
    private $map = array();

    /**
     * Set the compiled #[Dto] map (class => field => getter). Called by
     * Cache\Dto::loadInto($serializer).
     *
     * @param array $map
     * @return MapSerializer $this, for chaining.
     */
    public function setMap(array $map)
    {
        $this->map = $map;

        return $this;
    }

    public function serialize($value)
    {
        if (is_object($value)) {
            $class = get_class($value);
            if (isset($this->map[$class])) {
                $out = array();
                foreach ($this->map[$class] as $field => $getter) {
                    $out[$field] = $this->serialize($value->$getter());
                }
                return $out;
            }

            return $value; // unmapped object -> left to json_encode (public props)
        }

        if (is_array($value)) {
            $out = array();
            foreach ($value as $key => $item) {
                $out[$key] = $this->serialize($item);
            }
            return $out;
        }

        return $value; // scalar / null
    }
}
