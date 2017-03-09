<?php namespace Leadofficelist\Products;

class Product extends \BaseModel {
	protected $fillable = [ 'name' ];
	public $timestamps = false;

	public static function getProductsForFormSelect( $blank_entry = false, $blank_message = 'Please select...', $prefix = "" ) {
		$products = [];
		//If $blank_entry == true, add a blank "Please select..." option
		if ( $blank_entry ) {
			$products[''] = $blank_message;
		}

		foreach (
			Product::orderBy( 'name', 'ASC' )->get( [ 'id', 'name' ] ) as $product
		) {
			$products[ $product->id ] = $prefix . $product->name;
		}


		if ( $blank_entry && count( $products ) == 1 ) {
			return false;
		} elseif ( ! $blank_entry && count( $products ) == 0 ) {
			return false;
		} else {
			return $products;
		}
	}

	public function add( $product ) {
		$this->name = $product->name;
		$this->save();

		return $this;
	}

	public function edit( $product ) {
		$update_product       = $this->find( $product->id );
		$update_product->name = $product->name;
		$update_product->save();

		return $update_product;
	}
}