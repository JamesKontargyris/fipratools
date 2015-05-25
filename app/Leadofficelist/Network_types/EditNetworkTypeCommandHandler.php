<?php namespace Leadofficelist\Network_types;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class EditNetworkTypeCommandHandler implements CommandHandler {

    use DispatchableTrait;

    private $network_type;

    function __construct(Network_type $network_type) {

        $this->network_type = $network_type;

    }

    /**
     * Handle the command
     *
     * @param $command
     *
     * @return mixed
     */
    public function handle($command) {

        $this->network_type->edit($command);

        return $this->network_type;
    }
}