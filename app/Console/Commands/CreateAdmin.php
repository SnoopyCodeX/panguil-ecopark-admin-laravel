<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a default admin account upon running';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating key for laravel...');
        $this->call('key:generate', ['--ansi']);
        $this->call('jwt:secret');

        $this->call('db:seed', []);

        $message1 = 'Default admin account has been successfully created!';
        $message2 = '<options=bold;bg=blue;fg=bright-white>   Account Details:   </>';
        $message3 = '<fg=magenta;options=bold>Email: <fg=bright-cyan;options=underscore>tatel@gmail.com<fg=yellow>';
        $message4 = '<fg=magenta;options=bold>Password: <fg=bright-cyan;options=underscore>test123<fg=yellow>';
        $message5 = '<fg=white;bg=red;options=bold>   NOTE: DON\'T SHARE THIS WITH ANYONE!   <fg=yellow>';

        $length1 = Str::length(strip_tags($message1)) + 12;
        $length2 = $length1 - Str::length(strip_tags($message2)) - 7;
        $length3 = $length1 - Str::length(strip_tags($message3)) - 7;
        $length4 = $length1 - Str::length(strip_tags($message4)) - 7;
        $length5 = $length1 - Str::length(strip_tags($message5)) - 7;

        $this->comment(str_repeat('*', $length1));
        $this->comment('*     ' . $message1 . '     *');
        $this->comment('*' . str_repeat(' ', $length1 - 2) . '*');
        $this->comment('*     ' . $message2 .  str_repeat(' ', $length2) . '*');
        $this->comment('*     ' . $message3 .  str_repeat(' ', $length3) . '*</>');
        $this->comment('*     ' . $message4 .  str_repeat(' ', $length4) . '*</>');
        $this->comment('*' . str_repeat(' ', $length1 - 2) . '*');
        $this->comment('*     ' . $message5 .  str_repeat(' ', $length5) . '*</>');
        $this->comment(str_repeat('*', $length1));
        $this->line('');
    }
}
