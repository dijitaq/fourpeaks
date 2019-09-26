<?php namespace Dooze\Listings\Models;

use Model;

/**
 * Model
 */
class Xmlfile extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'dooze_listings_xmlfiles';

    /**
     * Relationships
     
    public $hasOne = [
        'slug' => 'Dooze\Listings\Models\Listing',
    ];*/


    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
