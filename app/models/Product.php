<?php

class Product extends \Eloquent {
	protected $fillable = ['name'];

	public static function getProductsForFormSelect( $blank_entry = false, $blank_message = 'Please select...', $prefix = "" )
	{
		$products = [ ];
		//Remove whitespace from $prefix and add a space on the end, so there is a space
		//between the prefix and the unit name
		$prefix = trim( $prefix ) . ' ';
		//If $blank_entry == true, add a blank "Please select..." option
		if ( $blank_entry )
		{
			$products[''] = $blank_message;
		}

		foreach (
			Product::orderBy( 'name', 'ASC' )->get( [
				'id',
				'name'
			] ) as $product
		)
		{
			$products[ $product->id ] = $prefix . $product->name;
		}



		if ( $blank_entry && count( $products ) == 1 )
		{
			return false;
		} elseif ( ! $blank_entry && count( $products ) == 0 )
		{
			return false;
		} else
		{
			return $products;
		}
	}
}