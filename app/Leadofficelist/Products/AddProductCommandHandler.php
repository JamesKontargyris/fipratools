<?php namespace Leadofficelist\Products;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Leadofficelist\Sector_categories\Sector_category;
use Location;
use Product;

class AddProductCommandHandler implements CommandHandler {

	use DispatchableTrait;

	private $product;

	function __construct(Product $product) {

		$this->product = $product;
	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 *
	 * @return mixed
	 */
	public function handle($command) {

		$this->product->add($command);

		return $this->product;
	}
}