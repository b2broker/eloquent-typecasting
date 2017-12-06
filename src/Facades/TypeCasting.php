<?php
declare(strict_types=1);

namespace B2B\Eloquent\TypeCasting\Facades;

use B2B\Eloquent\TypeCasting\Contracts;
use B2B\Eloquent\TypeCasting\Factory;
use Illuminate\Support\Facades\Facade;

/**
 * Class TypeCasting
 *
 * @package B2B\Eloquent\TypeCasting\Facades
 * @method static Contracts\TypeCastingInterface  resolve(string $name, ...$args)
 * @method static Factory extend(string $name, $class = null)
 * @method static string[] all()
 */
class TypeCasting extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'eloquent.typecasting';
    }
}
