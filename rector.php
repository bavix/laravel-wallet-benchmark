<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\PropertyFetch\ExplicitMethodCallOverMagicGetSetRector;
use Rector\Config\RectorConfig;
use Rector\Core\Configuration\Option;
use Rector\Laravel\Set\LaravelSetList;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (RectorConfig $config): void {
    $config->paths([
        __DIR__ . '/migrations',
        __DIR__ . '/tests',
    ]);

    $config->skip([
        ExplicitMethodCallOverMagicGetSetRector::class,
    ]);

    // Define what rule sets will be applied
    $config->import(PHPUnitSetList::PHPUNIT_91);
    $config->import(LaravelSetList::LARAVEL_80);
    $config->import(SetList::CODE_QUALITY);
    $config->import(SetList::DEAD_CODE);
    $config->import(SetList::PHP_81);

    // get services (needed for register a single rule)
    $services = $config->services();

    // register a single rule
    $services->set(TypedPropertyRector::class);
};
