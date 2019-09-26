<?php namespace Dooze\Listings;

use Log;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerFormWidgets() {
        return [
            'Dooze\Listings\FormWidgets\Xmlfiles' => [
                'label' => 'XML Files',
                'code' => 'xmlfile'
            ],

            'Dooze\Listings\FormWidgets\Galleryimages' => [
                'label' => 'Gallery images',
                'code' => 'gallery_images'
            ],

            'Dooze\Listings\FormWidgets\Posterimage' => [
                'label' => 'Listing poster image',
                'code' => 'poster_image'
            ],
        ];
    }

    public function registerSettings()
    {
    }
    
    public function registerSchedule($schedule) {
	    $schedule->call(
		    'Dooze\Listings\Http\Controllers\JobController@update'
		    
	    )->hourly();
    }
}
