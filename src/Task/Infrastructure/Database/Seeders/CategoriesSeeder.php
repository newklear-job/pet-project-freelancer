<?php

namespace Freelance\Task\Infrastructure\Database\Seeders;

use Freelance\Task\Domain\Models\Category;
use Illuminate\Database\Seeder;

final class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $programming = Category::firstOrCreate(
            ['name' => 'programming'],
            [
                'parent_id' => null,
            ]
        );

        Category::firstOrCreate(
            ['name' => 'php'],
            [
                'parent_id' => $programming->id,
            ]
        );
        Category::firstOrCreate(
            ['name' => 'javascript'],
            [
                'parent_id' => $programming->id,
            ]
        );

        $design = Category::firstOrCreate(
            ['name' => 'design'],
            [
                'parent_id' => null,
            ]
        );

        Category::firstOrCreate(
            ['name' => '2d'],
            [
                'parent_id' => $design->id,
            ]
        );

        Category::firstOrCreate(
            ['name' => '3d'],
            [
                'parent_id' => $design->id,
            ]
        );
    }
}
