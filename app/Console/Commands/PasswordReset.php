<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Config;


class PasswordReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:reset ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // seed admin
        User::updateOrCreate(
            ['email' => Config::get('admin.email')],
            [
                'username' => Config::get('admin.username'),
                'password' => 'admin',
                'email' => Config::get('admin.email'),
                'phone' => Config::get('admin.mobile'),
            ]
        );        
        return 0;
    }
}
