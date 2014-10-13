<?php


class BaseModel extends Eloquent
{
	public function scopeRowsToView( $query, $number_of_rows )
	{
		return $query->take( $number_of_rows );
	}

	public function scopeRowsSortOrder( $query, $sort_on )
	{
		return $query->orderBy( $sort_on[0], $sort_on[1] );
	}

	public function scopeRowsHideShowDormant( $query, $dormant )
	{
		if($dormant == 'hide')
		{
			return $query->where( 'status', '!=', 0 );
		}

		return $query;
	}
} 