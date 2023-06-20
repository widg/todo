<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Todo;

class TodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Todo::create([
            'title' => 'Купить продукты',
            'description' => 'Молоко, яйца, хлеб',
            'is_completed' => false,
        ]);

        Todo::create([
            'title' => 'Погулять в парке',
            'description' => 'Сходить на прогулку и посмотреть на природу',
            'is_completed' => true,
        ]);
    }
}
