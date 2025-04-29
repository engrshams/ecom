<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\SslCommerzSeeder;
class DatabaseSeeder extends Seeder{
    public function run(): void{
        // $this->call(AdminSeeder::class);
        // $this->call(SslCommerzSeeder::class);
        $this->call([
            SslCommerzSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
