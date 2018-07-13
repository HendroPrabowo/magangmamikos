<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class ResetCreditCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:credit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "This command is to reset all user's credit";

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
     * @return mixed
     */
    public function handle()
    {
        $users = User::where([
            'role' => 2,
        ])->get();

        foreach ($users as $user){
            if($this->is_premium($user)){
                $user->credit = 40;
                $user->save();
            }
            else{
                $user->credit = 20;
                $user->save();
            }
        }

        $this->info("All User's credit reset");
    }

    public function is_premium(User $user){
        if($user->is_premium == 0)
            return false;
        else return true;
    }
}
