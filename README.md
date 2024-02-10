# Scribble

[![Latest Version on Packagist](https://img.shields.io/packagist/v/awcodes/scribble.svg?style=flat-square)](https://packagist.org/packages/awcodes/scribble)
[![Total Downloads](https://img.shields.io/packagist/dt/awcodes/scribble.svg?style=flat-square)](https://packagist.org/packages/awcodes/scribble)

## Installation

Install the package via composer

```bash
composer require awcodes/scribble
```

In an effort to align with Filament's theming methodology you will need to use a custom theme to use this plugin.

<x-filament-theme-info />

Import the plugin's stylesheet and tippy.js stylesheet (if not already included) into your theme's css file.

```css
@import '../../../../vendor/awcodes/scribble/resources/css/plugin.css';
```

Add the plugin's views to your `tailwind.config.js` file.

```js
content: [
    './vendor/awcodes/scribble/resources/**/*.blade.php',
]
```

Rebuild your custom theme.

```sh
npm run build
```

## Usage

@TODO Write actual docs.

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

- [Adam Weston](https://github.com/awcodes)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
