<?php
declare(strict_types=1);

namespace B2B\Eloquent\TypeCasting;

use B2B\Eloquent\TypeCasting\Contracts\TypeCastingInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SimpleTypeCasting
 *
 * @package B2B\Eloquent\TypeCasting
 */
class SimpleTypeCasting implements TypeCastingInterface
{
    /**
     * @param string $key
     * @param mixed  $value
     * @param Model  $model
     *
     * @return mixed
     */
    public function castAttribute(string $key, $value, Model $model)
    {
        return $value;
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @param Model  $model
     *
     * @return mixed
     */
    public function fromAttribute(string $key, $value, Model $model)
    {
        return $value;
    }
}
