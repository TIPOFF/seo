# SEO

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tipoff/seo.svg?style=flat-square)](https://packagist.org/packages/tipoff/seo)
![Tests](https://github.com/tipoff/seo/workflows/Tests/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/tipoff/seo.svg?style=flat-square)](https://packagist.org/packages/tipoff/seo)

This is where your description should go.

## Installation

You can install the package via composer:

```bash
composer require tipoff/seo
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Tipoff\Seo\SeoServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
];
```

## Models

We include the following models:

**List of Models**

- Company
- Company User
- Domain
- Keyword
- Place
- Place Details
- Place Hours
- Profile Link
- Ranking
- Result
- Search Volume
- Webpage

For each of these models, this package implements an [authorization policy](https://laravel.com/docs/8.x/authorization) that extends the roles and permissions approach of the [tipoff/authorization](https://github.com/tipoff/authorization) package. The policies for each model in this package are registered through the package and do not need to be registered manually.

The models also have [Laravel Nova resources](https://nova.laravel.com/docs/3.0/resources/) in this package and they are also registered through the package and do not need to be registered manually.


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Tipoff](https://github.com/tipoff)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
