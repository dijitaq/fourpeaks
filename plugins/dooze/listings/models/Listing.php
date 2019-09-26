<?php namespace Dooze\Listings\Models;

use Model;
use Dooze\Listings\Models\Xmlfile;

/**
 * Model
 */
class Listing extends Model
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
    //public $table = 'dooze_listings_';
    public $table = 'dooze_listings_new';

    protected $jsonable = ['coordinate', 'facilities', 'events', 'gallery_images', 'agents'];
    
    protected $fillable = ['address', 'suburb', 'coordinate', 'slug', 'category_id', 'price', 'on_offer', 'facilities', 'events', 'description', 'gallery_images', 'poster_image', 'events', 'ctime', 'agents'];

    /**
     * @var array Validation rules
     */
    public $rules = [
        
    ];

    /**
     * @var category
     */
    public function scopeApplyBuy($query)
    {
        return $query->where('category_id', 'sale');
    }

    public function scopeApplyRent($query)
    {
        return $query->where('category_id', 'rental');
    }
}
