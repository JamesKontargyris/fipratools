<?php namespace Leadofficelist\Network_types;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class AddNetworkTypeCommandHandler implements CommandHandler {

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

        $this->network_type->add($command);

        return $this->network_type;
        //$this->dispatchEventsFor($this->unit);
    }
}