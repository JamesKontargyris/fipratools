<?php namespace Leadofficelist\Products;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Location;
use Product;

class EditProductCommandHandler implements CommandHandler {

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

		$this->product->edit($command);

		return $this->product;
	}
}