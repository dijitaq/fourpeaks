<?php namespace Dooze\Contact;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
        
            'Dooze\Contact\Components\ContactForm' => 'contactform'
        
        ];
    }

    public function registerSettings()
    {
    }
}
