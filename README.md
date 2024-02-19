# Scribble

[![Latest Version on Packagist](https://img.shields.io/packagist/v/awcodes/scribble.svg?style=flat-square)](https://packagist.org/packages/awcodes/scribble)
[![Total Downloads](https://img.shields.io/packagist/dt/awcodes/scribble.svg?style=flat-square)](https://packagist.org/packages/awcodes/scribble)

<img src="https://res.cloudinary.com/aw-codes/image/upload/w_1200,f_auto,q_auto/plugins/scribble/awcodes-scribble.jpg" alt="table repeater opengraph image" width="1200" height="auto" class="filament-hidden" style="width: 100%;" />

A Rich Text Editor plugin for Filament Forms.

## Installation

Install the package via composer

```bash
composer require awcodes/scribble
```

> [!IMPORTANT]
> If you have not set up a custom theme and are using a Panel follow the instructions in the [Filament Docs](https://filamentphp.com/docs/3.x/panels/themes#creating-a-custom-theme) first. The following applies to both the Panels Package and the standalone Forms package.

Import the plugin's stylesheet (if not already included) into your theme's css file.

```css
@import '../../../../vendor/awcodes/scribble/resources/css/plugin.css';
```

Add the plugin's views to your `tailwind.config.js` file.

```js
content: [
    './vendor/awcodes/scribble/resources/**/*.blade.php',
    './vendor/awcodes/pounce/resources/views/**/*.blade.php',
]
```

Rebuild your custom theme.

```sh
npm run build
```

## Preparing your model

Scribble stores its content as JSON data in a single column on your model. So, it is vital that you cast the column to an array in your model.

```php
protected $casts = [
    'content' => 'array',
];
```

It is also recommended to make the column a`longText` type in your migration. However, this is not required and if you know you will not need a large amount of data you can use a `text` or `mediumText` type as well. Just be aware that the content can grow rather quickly.

```php 
$table->longText('content')->nullable();
```

## Usage

@TODO Write actual docs.

Simple usage example for now:

```php
<?php

namespace App\Filament\Resources;

use Awcodes\Scribble\Scribble;
use Filament\Forms\Form;
use Filament\Resources\Resource;

class PageResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Scribble::make('content'),
        ]);
    }
}

```

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
