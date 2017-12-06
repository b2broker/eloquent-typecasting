<?php
declare(strict_types=1);

namespace B2B\Eloquent\TypeCasting;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

/**
 * Class ServiceProvider
 *
 * @package B2B\Eloquent\TypeCasting
 */
class ServiceProvider extends IlluminateServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('eloquent.typecasting', function ($app) {
            return new Factory($app);
        });
    }
}
