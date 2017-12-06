<?php
declare(strict_types=1);

namespace B2B\Eloquent\TypeCasting\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface TypeCasting
 *
 * @package B2B\Eloquent\TypeCasting\Contracts
 */
interface TypeCastingInterface
{
    /**
     * @param string $key
     * @param mixed  $value
     * @param Model  $model
     *
     * @return mixed
     */
    public function castAttribute(string $key, $value, Model $model);

    /**
     * @param string $key
     * @param mixed  $value
     * @param Model  $model
     *
     * @return mixed
     */
    public function fromAttribute(string $key, $value, Model $model);
}
