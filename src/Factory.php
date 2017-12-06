<?php
declare(strict_types=1);

namespace B2B\Eloquent\TypeCasting;

use B2B\Eloquent\TypeCasting\Contracts\TypeCastingInterface;
use B2B\Factory\BaseFactory;

/**
 * Class Factory
 *
 * @package B2B\Eloquent\TypeCasting
 */
class Factory extends BaseFactory
{
    protected $baseInterface = TypeCastingInterface::class;
}
