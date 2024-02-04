<?php

namespace Awcodes\Scribble\Tests\Database\Factories;

use Awcodes\Scribble\Utils\Faker;
use Awcodes\Scribble\Tests\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        $content = Faker::make()
            ->heading()
            ->paragraphs(withRandomLinks: true)
            ->heading(3)
            ->paragraphs(withRandomLinks: true);;

        return [
            'title' => $this->faker->sentence(),
            'html_content' => $content->asHTML(),
            'json_content' => $content->asJSON(),
        ];
    }
}
