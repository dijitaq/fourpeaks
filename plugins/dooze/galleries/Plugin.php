<?php namespace Dooze\Galleries;

use System\Classes\PluginBase;
use Event;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    	return [
        
            'Dooze\Galleries\Components\GalleryComponent' => 'gallerycomponent'
        
        ];
    }

    public function registerSettings()
    {
    }
}
