<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan role admin ada dengan guard 'web'
        $adminRole = Role::findOrCreate('admin', 'web');

        // Ambil user id=2
        $user = User::find(2);

        if (! $user) {
            $this->command->warn('User dengan ID 2 tidak ditemukan. Seeder dilewati.');
            return;
        }

        // Assign / sync role admin (idempotent)
        $user->syncRoles(['admin']);

        $this->command->info("User {$user->id} ({$user->email}) sekarang role: " . $user->getRoleNames()->implode(', '));
    }
}
