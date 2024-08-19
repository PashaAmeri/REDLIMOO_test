<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\ServicesServiceProvider::class,

    // custome service provider added to clean up controller methods
    App\Providers\ServicesServiceProvider::class,
];
