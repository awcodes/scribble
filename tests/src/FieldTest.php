<?php

use Awcodes\Scribble\Tests\Fixtures\LivewireForm;
use Awcodes\Scribble\Tests\Models\Page;
use Livewire\Livewire;

it('has editor field', function () {
    Livewire::test(LivewireForm::class)
        ->assertFormFieldExists('content');
});

it('creates record', function () {
    $page = Page::factory()->make();

    Livewire::test(LivewireForm::class)
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

    $storedPage = Page::query()->first();

    expect($storedPage)
        ->content->toBe($page->content);
});

it('updates record', function () {
    $page = Page::factory()->create();
    $newData = Page::factory()->make();

    Livewire::test(LivewireForm::class, [
        'record' => $page,
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

    $storedPage = Page::query()->first();

    expect($storedPage)
        ->content->toBe($newData->content);
});

it('can create null record', function () {
    $page = Page::factory()->make();

    Livewire::test(LivewireForm::class)
        ->assertFormFieldExists('content')
        ->fillForm([
            'title' => $page->title,
            'content' => null,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $storedPage = Page::query()->first();

    expect($storedPage)
        ->content->toBeNull();
});
