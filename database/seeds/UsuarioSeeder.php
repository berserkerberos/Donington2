<?php

use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([
            'nombre' => "admin",
            'nombre_completo' => "administrador de proyecto",
            'mail' => Str::random(10).'@gmail.com',
            'tipo' => '1',
            'password' => 'admin',
            //'password' => Hash::make('admin'),
        ]);
    }
}
