<?php
declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 *
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Создаем 10 тестовых пользователей
        User::factory()->count(10)->create();
    }
}
