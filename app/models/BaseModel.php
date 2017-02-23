<?php


use Leadofficelist\Sectors\Sector;

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

    public function scopeRowsHideShowActive( $query, $active )
    {
        if($active == 'hide')
        {
            return $query->where( 'status', '!=', 1 );
        }

        return $query;
    }

	public function scopeRowsListFilter( $query, $filters = [] )
	{
		if(array_key_exists('sector_category_id', $filters))
		{
			// A sector category filter has been triggered or exists already, so this is the Lead Office List filter set
			// Store the sector category
			$sector_category = $filters['sector_category_id'];
			// Remove the sector category filter from this local copy of $filters, so it isn't included in the query
			unset($filters['sector_category_id']);
			// Find all sectors assigned to this sector category
			$sectors = Sector::where('category_id', '=', $sector_category)->get();
			// Use the $sectors array to set orWhere clauses and return the query with the rest of the filters applied too
			return $query->where(function($q) use ($sectors)
			{
				foreach($sectors as $sector) $q->orWhere('sector_id', '=', $sector->id);
			})->where($filters);

		}
		// Otherwise, return the query with the filters applied as normal
		return $query->where( $filters );

	}
} 