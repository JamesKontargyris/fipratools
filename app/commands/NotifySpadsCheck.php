<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class NotifySpadsCheck extends Command
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'notify:spadscheck';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send an email to all Special Advisers asking them to do a client status check.';

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
		$users     = User::all();
		$data      = [ ];
		$count     = 0;
		$emails    = [ ];
		$usernames = [ ];

		//Send emails to Special Adviser users
		foreach ( $users as $user )
		{
			if ( $user->hasRole( 'Special Adviser' ) )
			{
				$data['first_name'] = $user->first_name;
				$data['last_name']  = $user->last_name;
				$data['full_name']  = $user->first_name . ' ' . $user->last_name;
				$data['email']      = $user->email;

				Mail::queue('emails.status_check.specialadviser_status_check_reminder', $data, function($message) use ($data)
				{
					$message->to($data['email'], $data['full_name'])->subject('Fipra Lead Office List');
				});

				$count ++;
				$emails[]    = $data['email'];
				$usernames[] = $data['full_name'];
			}

		}

		//Send email summary to Administrators, if at least 1 user was contacted
		if ( $count > 0 )
		{
			foreach ( $users as $user )
			{
				if ( $user->hasRole( 'Administrator' ) )
				{
					$data['first_name'] = $user->first_name;
					$data['last_name']  = $user->last_name;
					$data['full_name']  = $user->first_name . ' ' . $user->last_name;
					$data['email']      = $user->email;
					$data['count']     = $count;
					$data['usernames'] = $usernames;
                    $data['user_type'] = 'Special Adviser';

//					Mail::queue( 'emails.status_check.status_check_summary', $data, function ( $message ) use ( $data )
//					{
//						$message->to( $data['email'], $data['full_name'] )->subject( 'Fipra Lead Office List - Email Notification Summary' );
//					} );
				}
			}

			$this->info( 'Email notification sent to ' . $count . ' Special Adviser user(s): ' . implode( ', ', $usernames ) . '.' );
		} else
		{
			$this->info( 'Email notification sent to 0 Special Adviser users.' );
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [];
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
