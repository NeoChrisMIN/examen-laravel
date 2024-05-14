<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Entrada;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Storage::deleteDirectory('entrada');
        //Storage::makeDirectory('entrada'); //esto deberia crear una carpeta, pero no me esta funcionado, asi que al final la cree ha mano
        
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'password' => bcrypt('test'),
        ]);

        Categoria::factory(5)->create();
        Entrada::factory(30)->create();
    }
}
