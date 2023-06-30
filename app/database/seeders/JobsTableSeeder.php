<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Job;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Очищаем таблицу "jobs", чтобы избежать дублирования данных
        Job::truncate();

        // Заполняем таблицу "jobs" данными
        Job::create([
            'title' => 'Разработка веб-сайта',
            'description' => 'Требуется разработать веб-сайт с использованием HTML, CSS и JavaScript.',
            'price' => 1000.00,
        ]);

        Job::create([
            'title' => 'Написание статей',
            'description' => 'Ищем автора, который сможет писать качественные статьи на заданную тематику.',
            'price' => 500.00,
        ]);

        Job::create([
            'title' => 'Дизайн логотипа',
            'description' => 'Необходимо создать уникальный и привлекательный логотип для нашей компании.',
            'price' => 300.00,
        ]);
    }
}
