<?php

use Awcodes\Scribble\Tests\Models\Page;
use Awcodes\Scribble\Tests\Resources\PageResource\Pages\CreatePage;
use Awcodes\Scribble\Tests\Resources\PageResource\Pages\EditPage;
use Livewire\Livewire;

it('creates record', function () {
    $page = Page::factory()->make();

    Livewire::test(CreatePage::class)
        ->assertFormFieldExists('content')
        ->fillForm([
            'title' => $page->title,
            'content' => $page->content,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Page::class, [
        'title' => $page->title,
    ]);

    $storedPage = Page::query()->where('title', $page->title)->first();

    expect($storedPage)
        ->content->toBe($page->content);
});

it('updates record', function () {
    $page = Page::factory()->create();
    $newData = Page::factory()->make();

    Livewire::test(EditPage::class, [
        'record' => $page->getRouteKey(),
    ])
        ->assertFormFieldExists('content')
        ->fillForm([
            'title' => $newData->title,
            'content' => $newData->content,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Page::class, [
        'title' => $newData->title,
    ]);

    $storedPage = Page::query()->where('id', $page->id)->first();

    expect($storedPage)
        ->content->toBe($newData->content);
});

it('can create null record', function () {
    $page = Page::factory()->make();

    Livewire::test(CreatePage::class)
        ->assertFormFieldExists('content')
        ->fillForm([
            'title' => $page->title,
            'content' => null,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Page::class, [
        'title' => $page->title,
    ]);

    $storedPage = Page::query()->where('title', $page->title)->first();

    expect($storedPage)
        ->content->toBeNull();
});
