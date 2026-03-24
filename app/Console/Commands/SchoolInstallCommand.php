<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SchoolInstallCommand extends Command
{
    protected $signature = 'school:install';
    protected $description = 'Install migrations, seed the database, and set up the initial school and admin.';

    public function handle(): void
    {
        $this->info('Starting School Management System Installation...');

        if ($this->confirm('This will wipe your database and run migrations. Continue?', true)) {
            $this->info('Running migrations...');
            Artisan::call('migrate:fresh', [], $this->getOutput());
            
            $this->info('Seeding database with default data...');
            Artisan::call('db:seed', [], $this->getOutput());

            $schoolName = $this->ask('Enter school name', 'Global Excellence High');
            $adminEmail = $this->ask('Enter admin email', 'admin@school.com');
            $adminPassword = $this->secret('Enter admin password');
            $licenseKey = $this->ask('Enter license key', 'SCH-' . strtoupper(bin2hex(random_bytes(4))));

            // Update the seeded school or create a new one
            $school = School::first();
            if ($school) {
                $school->update([
                    'name' => $schoolName,
                    'email' => $adminEmail,
                    'license_key' => $licenseKey,
                ]);
            }

            // Update the admin user or create a new one
            $admin = User::where('email', 'admin@school.com')->first();
            if ($admin) {
                $admin->update([
                    'email' => $adminEmail,
                    'password' => Hash::make($adminPassword),
                ]);
            }

            $this->success_summary($schoolName, $adminEmail, $licenseKey);
        }
    }

    private function success_summary($schoolName, $adminEmail, $licenseKey): void
    {
        $this->newLine();
        $this->info('-----------------------------------------');
        $this->info('  INSTALLATION SUCCESSFUL!');
        $this->info('-----------------------------------------');
        $this->line("School: {$schoolName}");
        $this->line("Admin:  {$adminEmail}");
        $this->line("License: {$licenseKey}");
        $this->info('-----------------------------------------');
        $this->info('You can now log in at /admin');
    }
}
