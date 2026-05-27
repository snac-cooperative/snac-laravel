<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;

class AddUser extends Command
{
    protected $signature = 'user:add';

    protected $description = 'Add a new user with a role';

    public function handle()
    {
        $firstName = $this->ask('Enter the user\'s first name');
        $lastName = $this->ask('Enter the user\'s last name');
        $email = $this->ask('Enter the user\'s email');

        // Fetch available roles
        $roles = Role::all()->pluck('label')->toArray();
        $role = $this->choice('Select a role for the user', $roles);

        // Create the user
        $user = User::create([
            'first' => $firstName,
            'last' => $lastName,
            'fullname' => "{$firstName} {$lastName}",
            'email' => $email,
            'username' => $email,
        ]);

        // Assign the role to the user
        $user->assignRole($role); // Ensure you have a method to assign roles

        $this->info("User {$firstName} {$lastName} with role {$role} has been created successfully.");
    }
}
