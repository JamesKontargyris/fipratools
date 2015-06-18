<?php namespace Leadofficelist\Type_categories;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class EditTypeCategoryCommandHandler implements CommandHandler {

    use DispatchableTrait;

    private $type_category;

    function __construct(Type_category $type_category) {

        $this->type_category = $type_category;

    }

    /**
     * Handle the command
     *
     * @param $command
     *
     * @return mixed
     */
    public function handle($command) {

        $this->type_category->edit($command);

        return $this->type_category;
    }
}