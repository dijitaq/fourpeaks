<?php namespace Dooze\Galleries\Models;

use Model;

/**
 * Model
 */
class Gallery extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dooze_galleries_';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

     /**
     * Relations
     */
    public $attachMany = [
        'images' => 'System\Models\File',
    ];
}
