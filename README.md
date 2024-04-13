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
@import '/vendor/awcodes/scribble/resources/css/editor.css';
@import '/vendor/awcodes/scribble/resources/css/entry.css';
```

Add the plugin's views to your `tailwind.config.js` file.

```js
content: [
    './vendor/awcodes/scribble/resources/**/*{.blade.php,.svelte}',
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
use Awcodes\Scribble\ScribbleEditor;

public function form(Form $form): Form
{
    return $form
        ->schema([
            ScribbleEditor::make('content')
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

## Global Configuration

In the `boot` method of a ServiceProvider you can set the default configuration for all instances of the editor with the `configureUsing` method.

```php
use Awcodes\Scribble\ScribbleEditor;
use Awcodes\Scribble\Pofiles\MinimalProfile;

ScribbleEditor::configureUsing(function (ScribbleEditor $scribble) {
    $scribble
        ->renderToolbar()
        ->profile(MinimalProfile::class)
});
```

## Editor Profiles

Manually, creating menu configurations for each instance of the editor can be cumbersome. To alleviate this, you can create a profile class that defines the tools for the bubble, suggestion, and toolbar menus. You can then apply the profile to the editor using the `profile` method.

```php
namespace App\ScribbleProfiles;

use Awcodes\Scribble\Facades\ScribbleFacade;
use Awcodes\Scribble\ScribbleProfile;

class Minimal extends ScribbleProfile
{
    public static function bubbleTools(): array
    {
        return ScribbleFacade::getTools([
            'paragraph',
            'bold',
            'italic',
            'link',
            'bullet-list',
            'ordered-list',
        ])->toArray();
    }

    public static function suggestionTools(): array
    {
        return [];
    }

    public static function toolbarTools(): array
    {
        return ScribbleFacade::getTools([
            'paragraph',
            'bold',
            'italic',
            'link',
            'bullet-list',
            'ordered-list',
        ])->toArray();
    }
}
```

```php
use App\ScribbleProfiles\Minimal;

Scribble::configureUsing('content')
    ->profile(Mimimal::class)
```

### Generating a Profile

You can scaffold out a new profile class using the `make:scribble-profile` command and following the prompts.

```bash
php artisan make:scribble-profile
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
    protected function setUp(): void
    {
        $this
            ->icon('scribble-bold')
            ->label('Bold')
            ->extension('bold')
            ->active(extension: 'bold')
            ->commands([
                $this->makeCommand(command: 'toggleBold'),
                // or
                ['command' => 'toggleBold', 'arguments' => null],
            ]);
    }
}
```

#### Static Blocks

Static Blocks are a tool type that can be used to insert a static blade view into the editor. These are useful for inserting placeholder content that can be rendered out to a different view in your HTML. For instance, a block that represents a list of FAQs that when rendered on the front-end will display a list of FAQs from the database.

`$editorView` is optional but can be useful in the case that you need to provide a custom editor view for the block. And a different rendering view for the output.

```php
use Awcodes\Scribble\ScribbleTool;
use Awcodes\Scribble\Enums\ToolType;

class FaqsList extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('heroicon-o-question-mark-circle')
            ->label('FAQs List')
            ->type(ToolType::StaticBlock)
            ->editorView('scribble-tools.faqs-list-editor')
            ->renderedView('scribble-tools.faqs-list');
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

##### Tool class

```php
use Awcodes\Scribble\ScribbleTool;
use Awcodes\Pounce\Enums\MaxWidth;
use Awcodes\Pounce\Enums\Alignment;
use Awcodes\Pounce\Enums\SlideDirection;
use Awcodes\Scribble\Enums\ToolType;

class Notice extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('heroicon-o-exclamation-triangle')
            ->label('Notice')
            ->type(ToolType::Block)
            ->optionsModal(NoticeForm::class)
            ->renderedView('scribble-tools.notice');
    }
}
```

##### Modal Form

```php
use Awcodes\Scribble\Livewire\ScribbleModal;
use Awcodes\Scribble\Profiles\MinimalProfile;
use Awcodes\Scribble\ScribbleEditor;
use Filament\Forms\Components\Radio;

class NoticeForm extends ScribbleModal
{
    public ?string $header = 'Notice';
    
    // this should match the identifier in the tool class
    public ?string $identifier = 'notice';

    public function mount(): void
    {
        $this->form->fill([
            'color' => $this->data['color'] ?? 'info',
            'body' => $this->data['body'] ?? null,
        ]);
    }

    public function getFormFields(): array
    {
        return [
            Radio::make('color')
                ->inline()
                ->inlineLabel(false)
                ->options([
                    'info' => 'Info',
                    'success' => 'Success',
                    'warning' => 'Warning',
                    'danger' => 'Danger',
                ]),
            ScribbleEditor::make('body')
                ->profile(MinimalProfile::class)
                ->columnSpanFull(),
        ];
    }
}
```

##### Blade View

```blade
<div
    @class([
      'border-l-4 p-4 flex items-center gap-3 not-prose',
      match($color) {
        'success' => 'bg-success-200 text-success-900 border-success-600',
        'danger' => 'bg-danger-200 text-danger-900 border-danger-600',
        'warning' => 'bg-warning-200 text-warning-900 border-warning-600',
        default => 'bg-info-200 text-info-900 border-info-600',
      }
    ])
>
    @php
        $icon = match($color) {
            'success' => 'heroicon-o-check-circle',
            'danger' => 'heroicon-o-exclamation-circle',
            'warning' => 'heroicon-o-exclamation-triangle',
            default => 'heroicon-o-information-circle',
        };
    @endphp

    @svg($icon, 'h-6 w-6')

    {!! scribble($body)->toHtml() !!}
</div>
```

#### Modals

Modals are a tool type that interact with the editor's content through a modal form and use Tiptap commands to insert content into the editor. The `Media` and `Grid` tools are examples of this.

##### Tool class

```php
use Awcodes\Scribble\ScribbleTool;
use Awcodes\Scribble\Enums\ToolType;
use App\Path\To\MediaForm;

class Media extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('heroicon-o-photograph')
            ->label('Media')
            ->type(ToolType::Modal)
            ->commands([
                $this->makeCommand(command: 'setMedia'),
            ])
            ->optionsModal(MediaForm::class);
    }
}
```

##### Modal Form

```php
use Awcodes\Scribble\Livewire\ScribbleModal;
use Awcodes\Scribble\Profiles\MinimalProfile;
use Awcodes\Scribble\ScribbleEditor;
use Filament\Forms\Components\Radio;

class MediaForm extends ScribbleModal
{
    public ?string $header = 'Media';

    // this should match the identifier in the tool class
    public ?string $identifier = 'media'; 

    public function mount(): void
    {
        $this->form->fill([
            //
        ]);
    }

    public function getFormFields(): array
    {
        return [
            //
        ];
    }
}
```

#### Events

You may also create tools that emit events when they are clicked. This can be useful for triggering actions in your application when a tool is clicked.

##### Tool class

```php
use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\ScribbleTool;

class OpenRandomModal extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('scribble-open')
            ->label('Open Random Modal')
            ->type(ToolType::Event)
            ->commands([
                $this->makeCommand(command: 'setDataFromEvent'),
            ])
            ->event(
                name: 'open-modal',
                data: [
                    'id' => 'random-modal',
                    'title' => 'Random Modal',
                ],
            );
    }
}
```

### Generating a Tool

You can scaffold out a new tool class using the `make:scribble-tool` command and following the prompts.

```bash
php artisan make:scribble-tool
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

Next you will need to load your js file in your layout or view before Filament's scripts. This can be done in a way you see fit for you application.

For example, with a Filament Panel you could do something like the following:

```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->renderHook(
            name: 'panels::head.end',
            hook: fn (): string => Blade::render('@vite("resources/js/scribble/extensions.js")')
        );
}
```

### PHP Parser

In order for the content to be able to be converted to HTML, you will need to provide a PHP parser for the extension. See the [Tiptap PHP](https://github.com/ueberdosis/tiptap-php) package for more information on how to create a parser for a Tiptap extension or using an included one in their package.

### Tool

Next you will need a make a tool for the extension.

```php
use Awcodes\Scribble\ScribbleTool;
use Tiptap\Marks\Highlight as TiptapHighlight;

class Highlight extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('icon-highlight')
            ->label('Highlight')
            ->commands([
                $this->makeCommand(command: 'toggleHighlight'),
            ])
            ->converterExtensions(new TiptapHighlight());
    }
}
```

Now you can register the tool and PHP parser with the plugin in a ServiceProvider's `register` method.

```php
use Awcodes\Scribble\ScribbleManager;
use App\ScribbleTools\Highlight;
use Tiptap\Marks\Highlight as TiptapHighlight;

public function register(): void
{
    app(ScribbleManager::class)
        ->registerTools([
            Highlight::make(),
        ]);
}
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

### MergeTags Replacement

If you are using Merge tags and outputting the content as HTML you can use the `mergeTagsMap` method to replace the merge tags with the appropriate values.

```blade
{!! 
    scribble($content)->mergeTagsMap([
        'brand_phone' => '1-800-555-1234',
        'brand_email' => 'webinquiries@titlemax.com',
    ])->toHtml() 
!!}
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
