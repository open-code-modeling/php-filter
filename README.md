# PHP Filter

Common PHP filters for code generation.

## Installation

```bash
$ composer require open-code-modeling/php-filter --dev
```

If you want to use the `FilterFactory` to get complete preconfigured filters install also [`laminas/laminas-filter`](https://github.com/laminas/laminas-filter).

```bash
$ composer require laminas/laminas-filter
```

## Usage

```php
<?php

use OpenCodeModeling\Filter;

$filter = Filter\FilterFactory::classNameFilter();
($filter)(' Add Building '); // AddBuilding

$filter = Filter\FilterFactory::methodNameFilter();
($filter)(' Add Building '); // addBuilding

$filter = Filter\FilterFactory::propertyNameFilter();
($filter)(' Add Building '); // addBuilding

$filter = Filter\FilterFactory::constantNameFilter();
($filter)(' Add Building '); // ADD_BUILDING

$filter = Filter\FilterFactory::constantValueFilter();
($filter)(' Add Building '); // add_building

$filter = Filter\FilterFactory::namespaceToDirectoryFilter();
($filter)('My\\App\\Service'); // My/App/Service

$filter = Filter\FilterFactory::directoryToNamespaceFilter();
($filter)('My/App/Service'); // My\\App\\Service
```
