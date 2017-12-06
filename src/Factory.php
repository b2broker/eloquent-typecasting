<?php
declare(strict_types=1);

namespace B2B\Eloquent\TypeCasting;

use B2B\Eloquent\TypeCasting\Contracts\TypeCastingInterface;
use B2B\Factory\BaseFactory;
use B2B\Factory\Exceptions\ProviderNotFoundException;

/**
 * Class Factory
 *
 * @package B2B\Eloquent\TypeCasting
 */
class Factory extends BaseFactory
{
    protected $baseInterface = TypeCastingInterface::class;

    /**
     * @param string $name
     * @param array  ...$args
     *
     * @return TypeCastingInterface
     */
    public function resolve(string $name, ...$args): TypeCastingInterface
    {
        try {
            return parent::resolve($name, ...$args);
        } catch (ProviderNotFoundException $exception) {
            return new SimpleTypeCasting();
        }
    }
}
