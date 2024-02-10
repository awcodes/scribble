<?php

use Awcodes\Scribble\Tests\Fixtures\LivewireForm;
use Livewire\Livewire;

it('has editor field', function () {
    Livewire::test(LivewireForm::class)
        ->assertFormFieldExists('content');
});

