<?php namespace Leadofficelist\Type_categories;

class Type_category extends \BaseModel
{
    protected $table = 'type_categories';
    public $timestamps = false;

    public function types()
    {
        return $this->hasMany( '\Leadofficelist\Types\Type', 'category_id' );
    }

    /**
     * Add a new type category
     *
     * @param $command
     *
     * @return $this|\Illuminate\Support\Collection|static
     */
    public function add($command)
    {
        $this->name = $command->name;
        $this->short_name = $command->short_name;
        $this->save();

        return $this;
    }

    /**
     * Add a new type category if a new one is passed in,
     * otherwise return the existing one.
     *
     * @param $command
     *
     * @return mixed
     */
    public function addWithType($command)
    {
        if($command->category == 'new')
        {
            $this->name = $command->new_category;
            $this->short_name = $command->new_category;
            $this->save();

            return $this->id;
        }
        else
        {
            return $command->category;
        }
    }

    public function edit( $type_category )
    {
        $update_type_category       = $this->find( $type_category->id );
        $update_type_category->name = $type_category->name;
        $update_type_category->short_name = $type_category->short_name;
        $update_type_category->save();

        return $update_type_category;
    }
}