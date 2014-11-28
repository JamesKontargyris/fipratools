<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class NotifyStatusCheck extends Command
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'notify:statuscheck';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send an email to all heads of unit asking them to do a client status check.';

	/**
	 * Create a new command instance.
	 *
	 * @return \NotifyStatusCheck
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
		$users     = User::orderBy('last_name')->get();
		$data      = [ ];
		$count     = 0;
		$emails    = [ ];
		$usernames = [ ];

		//Send emails to Head of Unit users
		foreach ( $users as $user )
		{
			if ( $user->hasRole( 'Head of Unit' ) )
			{
				$data['first_name'] = $user->first_name;
				$data['last_name']  = $user->last_name;
				$data['full_name']  = $user->first_name . ' ' . $user->last_name;
				$data['email']      = $user->email;

				Mail::queue('emails.status_check.status_check_reminder', $data, function($message) use ($data)
				{
					$message->to($data['email'], $data['full_name'])->subject('Fipra Lead Office List - Client Status Check');
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
					//$data['email']      = $user->email;
					$data['count']     = $count;
					$data['usernames'] = $usernames;

					Mail::queue( 'emails.status_check.status_check_summary', $data, function ( $message ) use ( $data )
					{
						$message->to( $data['email'], $data['full_name'] )->subject( 'Fipra Lead Office List - Client Status Check Summary' );
					} );
				}
			}

			$this->info( 'Client status check email notification sent to ' . $count . ' Head of Unit users: ' . implode( ', ', $usernames ) . '.' );
		} else
		{
			$this->info( 'Client status check email notification sent to 0 Head of Unit users.' );
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array();
	}

}
