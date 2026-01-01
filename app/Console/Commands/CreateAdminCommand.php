<?php

namespace App\Console\Commands;

use App\Models\Administrator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'admin:create 
                            {username? : The admin username}
                            {email? : The admin email}
                            {password? : The admin password}
                            {--reset : Reset existing admin password}';

    /**
     * The console command description.
     */
    protected $description = 'Create a new administrator or reset existing admin password';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if ($this->option('reset')) {
            return $this->resetPassword();
        }

        return $this->createAdmin();
    }

    private function createAdmin(): int
    {
        $this->info('=== Create New Administrator ===');

        $username = $this->argument('username') ?: $this->ask('Username');
        $email = $this->argument('email') ?: $this->ask('Email');
        $password = $this->argument('password') ?: $this->secret('Password (min 6 characters)');
        
        $fullName = $this->ask('Full Name (optional)') ?: $username;
        
        $role = $this->choice(
            'Role',
            ['super_admin', 'admin', 'moderator', 'editor'],
            0
        );

        // Validate input
        $validator = Validator::make([
            'username' => $username,
            'email' => $email,
            'password' => $password,
        ], [
            'username' => 'required|string|max:50|unique:administrators,username',
            'email' => 'required|email|max:100|unique:administrators,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            $this->error('Validation failed:');
            foreach ($validator->errors()->all() as $error) {
                $this->error("  - {$error}");
            }
            return Command::FAILURE;
        }

        // Create admin
        $admin = Administrator::create([
            'username' => $username,
            'email' => $email,
            'password_hash' => Hash::make($password),
            'full_name' => $fullName,
            'role' => $role,
            'status' => 'active',
            'failed_login_attempts' => 0,
            'login_attempts' => 0,
        ]);

        $this->info('');
        $this->info('✓ Administrator created successfully!');
        $this->info('');
        $this->table(
            ['Field', 'Value'],
            [
                ['ID', $admin->id],
                ['Username', $admin->username],
                ['Email', $admin->email],
                ['Full Name', $admin->full_name],
                ['Role', $admin->role],
                ['Status', $admin->status],
                ['Password', '(hidden)'],
            ]
        );

        $this->info('');
        $this->info("Login at: " . route('admin.login'));
        $this->info("Username: {$username}");
        $this->info("Password: {$password}");

        return Command::SUCCESS;
    }

    private function resetPassword(): int
    {
        $this->info('=== Reset Administrator Password ===');

        $identifier = $this->ask('Enter username or email');

        $admin = Administrator::where('username', $identifier)
            ->orWhere('email', $identifier)
            ->first();

        if (!$admin) {
            $this->error('Administrator not found!');
            return Command::FAILURE;
        }

        $this->info("Found: {$admin->full_name} ({$admin->username})");

        $password = $this->secret('New password (min 6 characters)');
        $confirmPassword = $this->secret('Confirm password');

        if ($password !== $confirmPassword) {
            $this->error('Passwords do not match!');
            return Command::FAILURE;
        }

        if (strlen($password) < 6) {
            $this->error('Password must be at least 6 characters!');
            return Command::FAILURE;
        }

        // Update password and reset locks
        $admin->update([
            'password_hash' => Hash::make($password),
            'failed_login_attempts' => 0,
            'login_attempts' => 0,
            'locked_until' => null,
            'status' => 'active',
        ]);

        $this->info('');
        $this->info('✓ Password reset successfully!');
        $this->info('');
        $this->info("Login at: " . route('admin.login'));
        $this->info("Username: {$admin->username}");
        $this->info("Password: {$password}");

        return Command::SUCCESS;
    }
}
