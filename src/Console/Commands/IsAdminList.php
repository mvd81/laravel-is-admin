<?php

namespace Mvd81\LaravelIsAdmin\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class IsAdminList extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:isAdmin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List with all the admins for this project';

    /**
     * Create a new command instance.
     *
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        if (!Schema::hasColumn('users', 'is_admin')) {
            $this->error('Column is_admin does not exists in the user table. Did you run the migration for this package?');
            die;
        }

        $admins = User::where('is_admin', 1)->get();

        if (config()->has('is_admin.use_super_admin')) {
            $userOne = User::findOrFail(1);
            $this->line('Super admin: ' . $userOne->name . '(' . $userOne->id .') | ' . $userOne->email);

        }

        if (!count($admins)) {
            $this->line('There are no admin for this project');
        }
        else {
            foreach($admins as $admin) {
                $this->line($admin->name . '(' . $admin->id .') | ' . $admin->email);
            }
        }

    }
}
