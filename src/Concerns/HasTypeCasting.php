<?php
declare(strict_types=1);

namespace B2B\Eloquent\TypeCasting\Concerns;

use B2B\Eloquent\TypeCasting\Facades\TypeCasting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Support\Str;
use MyCLabs\Enum\Enum;

/**
 * Trait HasTypeCasting
 *
 * @package B2B\Eloquent\TypeCasting\Concerns
 * @mixin Model
 */
trait HasTypeCasting
{
    /**
     * Get enums.
     *
     * @return array
     */
    public function getEnums(): array
    {
        return $this->enums ?? [];
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasEnum(string $key): bool
    {
        return \array_key_exists($key, $this->getEnums());
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return Enum
     */
    public function asEnum(string $key, $value): Enum
    {
        $class = $this->getEnums()[$key];
        return new $class($value);
    }

    /**
     * Cast an attribute to a native PHP type.
     *
     * @param  string $key
     * @param  mixed  $value
     *
     * @return mixed
     */
    protected function castAttribute($key, $value)
    {
        if ($value === null) {
            return $value;
        }

        if ($this->hasEnum($key)) {
            return $this->asEnum($key, $value);
        }

        $type = $this->getCastType($key);
        switch ($type) {
            case 'int':
            case 'integer':
                return (int) $value;
            case 'real':
            case 'float':
            case 'double':
                return (float) $value;
            case 'string':
                return (string) $value;
            case 'bool':
            case 'boolean':
                return (bool) $value;
            case 'object':
                return $this->fromJson($value, true);
            case 'array':
            case 'json':
                return $this->fromJson($value);
            case 'collection':
                return new BaseCollection($this->fromJson($value));
            case 'date':
                return $this->asDate($value);
            case 'datetime':
                return $this->asDateTime($value);
            case 'timestamp':
                return $this->asTimestamp($value);
            default:
                return TypeCasting::resolve($type)->castAttribute($key, $value, $this);
        }
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string $key
     * @param  mixed  $value
     *
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        // First we will check for the presence of a mutator for the set operation
        // which simply lets the developers tweak the attribute as it is set on
        // the model, such as "json_encoding" an listing of data for storage.
        if ($this->hasSetMutator($key)) {
            $method = 'set' . Str::studly($key) . 'Attribute';

            return $this->{$method}($value);
        }
        // If an attribute is listed as a "date", we'll convert it from a DateTime
        // instance into a form proper for storage on the database tables using
        // the connection grammar's date format. We will auto set the values.
        if ($value && $this->isDateAttribute($key)) {
            $value = $this->fromDateTime($value);
        }

        if ($value !== null && $this->isJsonCastable($key)) {
            $value = $this->castAttributeAsJson($key, $value);
        } elseif ($this->hasEnum($key)) {
            $value = $value instanceof Enum ? $value->getValue() : $value;
        } elseif ($this->hasCast($key)) {
            $type = $this->getCasts()[$key];
            if (\in_array($type, TypeCasting::all(), true)) {
                $value = TypeCasting::resolve($type)->fromAttribute($key, $value, $this);
            }
        }

        // If this attribute contains a JSON ->, we'll set the proper value in the
        // attribute's underlying array. This takes care of properly nesting an
        // attribute in the array's value in the case of deeply nested items.
        if (Str::contains($key, '->')) {
            return $this->fillJsonAttribute($key, $value);
        }

        $this->attributes[$key] = $value;

        return $this;
    }
}
