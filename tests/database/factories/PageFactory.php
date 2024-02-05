<?php

namespace Awcodes\Scribble\Tests\Database\Factories;

use Awcodes\Scribble\Tests\Models\Page;
use Awcodes\Scribble\Utils\Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => Faker::make()->sink()->asJson(),
        ];
    }
}
