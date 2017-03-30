<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateUsers extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'users:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update users based on a CSV file. File used should be in the root directory, defaults to users.csv (or a filename passed as --file=filename.csv) and should be in the order: display name, first name, last name, email, role, password.';

    /**
     * Create a new command instance.
     *
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
    public function fire()
    {
    	$filename = $this->argument('file');
		if($handle = @fopen($filename, 'r')) {
			$this->info('Updating users, please wait...');

			$roles_id = ['Administrator' => 1, 'Head of Unit' => 2, 'Fipriot' => 3, 'Special Adviser' => 4, 'Fipriot (International)' => 6];
			while(($data = fgetcsv($handle)) !== FALSE) {
				if($found_user = Leadofficelist\Users\User::where('email', '=', $data[3])->get()->first()) {
					$current_user = Leadofficelist\Users\User::find($found_user->id);
					$current_user->first_name = trim($data[1]);
					$current_user->last_name = trim($data[2]);
					$current_user->save();
					$current_user->detachRoles([1, 2, 3, 4, 5]);
					$current_user->attachRole($roles_id[$data[4]]);
					$this->info(trim($data[0]) . ' updated.');
				} else {
					$user = new Leadofficelist\Users\User;
					$user->first_name = trim($data[1]);
					$user->last_name = trim($data[2]);
					$user->email = trim($data[3]);
					$user->password = trim($data[5]);
					$user->save();
					$user->roles()->attach($roles_id[$data[4]]);
					$this->info(trim($data[0]) . ' added.');
				}
			}

			$this->info('All done.');
		} else {
			$this->info('Error: could not find and/or could not open ' . $filename . '.');
		}

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
        	['file', InputArgument::OPTIONAL, 'CSV file to use', 'users.csv']
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

}
