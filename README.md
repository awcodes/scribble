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

### Publishing the config

```bash
php artisan vendor:publish --tag="scribble-config"
```

### Publishing the translations

```bash
php artisan vendor:publish --tag="scribble-translations"
```

> [!IMPORTANT]
> If you have not set up a custom theme and are using a Panel follow the instructions in the [Filament Docs](https://filamentphp.com/docs/3.x/panels/themes#creating-a-custom-theme) first. The following applies to both the Panels Package and the standalone Forms package.

Import the plugin's stylesheet (if not already included) into your theme's css file.

```css
@import '../../../../vendor/awcodes/scribble/resources/css/index.css';
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

Scribble stores its content as JSON data in a single column on your model. So, it is vital that you cast the column to an array or json object in your model.

```php
protected $casts = [
    'content' => 'array', // or 'json'
];
```

It is also recommended to make the column a`longText` type in your migration. However, this is not required and if you know you will not need a large amount of data you can use a `text` or `mediumText` type as well. Just be aware that the content can grow rather quickly.

```php 
$table->longText('content')->nullable();
```

## Usage

### Form Component
```php
use Awcodes\Scribble\Scribble;

public function form(Form $form): Form
{
    return $form
        ->schema([
            Scribble::make('content')
        ])
}
```

### Infolist Entry
```php
use Awcodes\Scribble\ScribbleEntry;

public function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->schema([
            ScribbleEntry::make('content')
        ]);
}
```

## Customizing the Bubble Menu

You may customize the bubble menu by providing an array of tools to the `bubbleTools` method. The `withDefaults` option can be used to disable the default tools that are provided to the bubble menu by the plugin.

You can disable the bubble menu by passing and empty array and setting `withDefaults` to `false`.

```php
Scribble::make('content')
    ->bubbleTools([
        \Awcodes\Scribble\Tools\Bold::class,
        \Awcodes\Scribble\Tools\Italic::class,
        \App\ScribbleTools\CustomTool::class,
    ], withDefaults: false)
```

## Customizing the Suggestion Menu (Slash Commands)

You may customize the suggestion menu by providing an array of tools to the `suggestionTools` method. The `withDefaults` option can be used to disable the default tools that are provided to the suggestion menu by the plugin.

You can disable the suggestion menu by passing and empty array and setting `withDefaults` to `false`.

```php
Scribble::make('content')
    ->suggestionTools([
        \Awcodes\Scribble\Tools\Grid::class,
        \Awcodes\Scribble\Tools\Media::class,
        \App\ScribbleTools\CustomTool::class,
    ], withDefaults: false)
```

## Customizing the Toolbar

By default, Scribble will not render a toolbar. You can enable the toolbar by calling the `renderToolbar` method.

You may customize the toolbar by providing an array of tools to the `toolbarTools` method. The `withDefaults` option can be used to disable the default tools that are provided to the toolbar by the plugin.

```php
Scribble::make('content')
    ->renderToolbar()
    ->toolbarTools([
        \Awcodes\Scribble\Tools\Bold::class,
        \Awcodes\Scribble\Tools\Italic::class,
        \App\ScribbleTools\CustomTool::class,
    ], withDefaults: false)
```

## Global Configuration

In the `boot` method of a ServiceProvider you can set the default configuration for all instances of the editor with the `configureUsing` method.

```php
Scribble::configureUsing('content')
    ->renderToolbar()
    ->toolbarTools([
        \Awcodes\Scribble\Tools\Bold::class,
        \Awcodes\Scribble\Tools\Italic::class,
        \App\ScribbleTools\CustomTool::class,
    ], withDefaults: false)
    ->bubbleTools([
        \Awcodes\Scribble\Tools\Bold::class,
        \Awcodes\Scribble\Tools\Italic::class,
        \App\ScribbleTools\CustomTool::class,
    ], withDefaults: false)
    ->suggestionTools([
        \Awcodes\Scribble\Tools\Grid::class,
        \Awcodes\Scribble\Tools\Media::class,
    ], withDefaults: false)
```

## Editor Profiles

Manually, creating menu configurations for each instance of the editor can be cumbersome. To alleviate this, you can create a profile class that defines the tools for the bubble, suggestion, and toolbar menus. You can then apply the profile to the editor using the `profile` method.

Using the `withDefaults` argument is not necessary when using a profile as the profile will override the default tools.

```php
namespace App\ScribbleProfiles;

use Awcodes\Scribble\Tools;
use Awcodes\Scribble\ScribbleProfile;

class Minimal extends ScribbleProfile
{
    public static function bubbleTools(): array
    {
        return [
            Tools\Bold::class,
            Tools\Italic::class,
            Tools\Link::class,
            Tools\AlignStart::class,
            Tools\AlignCenter::class,
            Tools\AlignEnd::class,
        ];
    }

    public static function suggestionTools(): array
    {
        return [];
    }

    public static function toolbarTools(): array
    {
        return [];
    }
}
```

```php
use App\ScribbleProfiles\Minimal;

Scribble::configureUsing('content')
    ->profile(Mimimal::class)
```

## Custom Editor Styles

Should you need to provide styles to the editor for custom blocks or tools, you can use the `customStyles` method to provide a path to a CSS file.

```php
Scribble::make('content')
    ->customStyles('path/to/custom.css')
```

## Extending the Editor

### Custom Tools

#### Commands

Command tools are used to insert content into the editor using Tiptap commands. The `Bold` and `Italic` tools are examples of this. This is also the default tool type.

```php
use Awcodes\Scribble\ScribbleTool;

class Bold extends ScribbleTool
{
    public function getType(): ToolType
    {
        return ToolType::Command;
    }
    
    public function getCommands(): ?array
    {
        return [
            ['command' => 'toggleBold', 'arguments' => null],
        ];
    }
}
```

#### Static Blocks

Static Blocks are a tool type that can be used to insert a static blade view into the editor. These are useful for inserting placeholder content that can be rendered out to a different view in your HTML. For instance, a block that represents a list of FAQs that when rendered on the front-end will display a list of FAQs from the database.

`$editorView` is optional but can be useful in the case that you need to provide a custom editor view for the block. And a different rendering view for the output.

```php
use Awcodes\Scribble\ScribbleTool;

class CustomStaticBlock extends ScribbleTool
{
    protected ?string $view = 'scribble.static-block';
    
    protected ?string $editorView = 'scribble.static-block-editor';
    
    public function getType(): ToolType
    {
        return ToolType::StaticBlock;
    }
}
```

```blade
{{-- scribble.static-block-editor --}}
<div class="p-4 bg-gray-800 rounded-lg">
    <p>This is a placeholder. FAQ list will be rendered on output.</p>
</div>

{{-- scribble.static-block --}}
<div class="p-4 bg-gray-800 rounded-lg">
    @foreach ($faqs as $faq)
        <div class="mb-4">
            <h3 class="text-lg font-bold">{{ $faq->question }}</h3>
            <p>{{ $faq->answer }}</p>
        </div>
    @endforeach
</div>
```

#### Blocks

Blocks are a tool type that interact with the editor's content through a modal form and a blade view. They can be used to insert custom content into the editor.

`$editorView` is optional but can be useful in the case that you need to provide a custom editor view for the block. And a different rendering view for the output.

*See the [Pounce plugin docs](https://github.com/awcodes/pounce) for more information on the `Alignment`, `MaxWidth`, and `SlideDirection`.*

```php
use Awcodes\Scribble\ScribbleTool;
use Awcodes\Pounce\Enums\MaxWidth;
use Awcodes\Pounce\Enums\Alignment;
use Awcodes\Pounce\Enums\SlideDirection;

class CustomBlock extends ScribbleTool
{
    protected ?string $view = 'scribble.custom-block';
    
    // protected ?string $editorView = 'scribble.custom-block-editor';
    
    public ?string $name;
    
    public ?string $email;
    
    public function getType(): ToolType
    {
        return ToolType::Block;
    }
    
    public static function getAlignment() : Alignment
    {
        return Alignment::MiddleCenter
    }
    
    public static function getMaxWidth(): MaxWidth
    {
        return MaxWidth::Large;
    }
    
    public static function getSlideDirection() : SlideDirection
    {
        return SlideDirection::Right;
    }

    public function mount(): void
    {
        $this->form->fill([
            'name' => $this->name,
            'email' => $this->email,
        ]);
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Forms\Components\TextInput::make('name'),
                Forms\Components\TextInput::make('email'),
            ]);
    }
}
```

```blade
{{-- scribble.custom-block --}}

<div class="flex items-center gap-6 p-4 rounded-lg">
    <p>Name: {{ $name }}</p>
    <p>Email: {{ $email }}</p>
</div>
```

#### Modals

Modals are a tool type that interact with the editor's content through a modal form and use Tiptap commands to insert content into the editor. The `Media` and `Grid` tools are examples of this.

*See the [Pounce plugin docs](https://github.com/awcodes/pounce) for more information on the `Alignment`, `MaxWidth`, and `SlideDirection`.*

```php
use Awcodes\Scribble\ScribbleTool;

class ModalBlock extends ScribbleTool
{
    public ?string $name;
    
    public ?string $email;
    
    public function getType(): ToolType
    {
        return ToolType::Modal;
    }
    
    public function getCommands(): ?array
    {
        return [
            ['command' => 'insertModal', 'arguments' => null],
        ];
    }
        
    public static function getAlignment() : Alignment
    {
        return Alignment::MiddleCenter
    }
    
    public static function getMaxWidth(): MaxWidth
    {
        return MaxWidth::Large;
    }
    
    public static function getSlideDirection() : SlideDirection
    {
        return SlideDirection::Right;
    }

    public function mount(): void
    {
        $this->form->fill([
            'name' => $this->name,
            'email' => $this->email,
        ]);
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Forms\Components\TextInput::make('name'),
                Forms\Components\TextInput::make('email'),
            ]);
    }
}
```

### Generating Custom Tools

In order to help you get started with creating custom tools, you can use the `make:scribble-tool` command to generate a new tool class.

Tools and views will be generated to the paths defined in the `generator` configuration in the `scribble.php` config file.

After generating the tool, you will need to register it in the `tools` array in the `scribble.php` config file for global registration to the plugin.

```bash
php artisan make:scribble-tool CustomTool
```

### Registering Custom Tools

```php
// config/scribble.php
'generator' => [
    'namespace' => 'App\\ScribbleTools',
    'views' => 'scribble-tools',
],
'tools' => [
    \App\ScribbleTools\HeroBlock::class,
    \App\ScribbleTools\BatmanBlock::class,
    \App\ScribbleTools\FormBlock::class,
    \App\ScribbleTools\StaticBlock::class,
    \App\ScribbleTools\Highlight::class
],
```

## Custom Tiptap Extensions

You can also provide custom Tiptap extensions or other Tiptap native extensions to the editor. This can be useful for adding custom marks, nodes, or other extensions to the editor.

### Javascript

```js
import {Highlight} from "@tiptap/extension-highlight";
import MyCustomExtension from "./MyCustomExtension";

window.scribbleExtensions = [
    Highlight,
    MyCustomExtension,
];
```

### PHP Parser

In order for the content to be able to be converted to HTML, you will need to provide a PHP parser for the extension. See the [Tiptap PHP](https://github.com/ueberdosis/tiptap-php) package for more information on how to create a parser for a Tiptap extension or using an included one in their package.

```php
// config/scribble.php
'tiptap_php_extensions' => [
    Tiptap\Marks\Highlight::class,
    MyCustomPHPExtension::class,
],
```

### Tool

Next you will need a make a tool for the extension and register it in the `tools` array in the `scribble.php` config file for global registration to the plugin.

```php
use Awcodes\Scribble\ScribbleTool;

class Highlight extends ScribbleTool
{
    public function getType(): ToolType
    {
        return ToolType::Command;
    }
    
    public function getCommands(): ?array
    {
        return [
            ['command' => 'toggleHighlight', 'arguments' => null],
        ];
    }
}
```

```php
// config/scribble.php
'tools' => [
    ...
    \App\ScribbleTools\Highlight::class,
],
```

## Converting output

### With the Converter Utility class

```php
use Awcodes\Scribble\Utils\Converter;

Converter::from($content)->toHtml();
Converter::from($content)->toJson();
Converter::from($content)->toText();
Converter::from($content)->toMarkdown();
Converter::from($content)->toTOC(); // Table of Contents
```

### With the helper function

```blade
{!! scribble($content)->toHtml() !!}
{!! scribble($content)->toJson() !!}
{!! scribble($content)->toText() !!}
{!! scribble($content)->toMarkdown() !!}
{!! scribble($content)->toTOC() !!}
````

### Table of Contents

```php
use Awcodes\Scribble\Utils\Converter;

// HTML output with headings linked and wrapped in anchor tags
Converter::from($content)
    ->toHtml(
        toc: true,
        maxDepth: 3,
        wrapHeadings: true
    );

// Structured list of heading links
Converter::from($content)->toTOC();
```

## Faker Utility

```php
use Awcodes\Scribble\Utils\Faker;

Faker::make()
    ->heading(int | string | null $level = 2)
    ->emptyParagraph()
    ->paragraphs(int $count = 1, bool $withRandomLinks = false)
    ->unorderedList(int $count = 1)
    ->orderedList(int $count = 1)
    ->image(?int $width = 640, ?int $height = 480)
    ->link()
    ->details(bool $open = false)
    ->code(?string $className = null)
    ->blockquote()
    ->hr()
    ->br()
    ->grid(array $cols = [1, 1, 1])
    ->toJson();
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
