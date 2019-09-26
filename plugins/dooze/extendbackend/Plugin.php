<?php namespace Dooze\Extendbackend;

use System\Classes\PluginBase;
use Event;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }

    public function boot()
    {
        // Extend all backend form usage
        Event::listen('backend.form.extendFields', function($widget) {

            // Only for the CMS Index controller
            if (!$widget->getController() instanceof \Cms\Controllers\Index) {
                return;
            }

            // Only for the Page model
            if (!$widget->model instanceof \Cms\Classes\Page) {
                return;
            }

            // Add custom fields...
            $widget->addTabFields([
                'viewBag[featured_image_desktop]' => [
                    'label'			=> 'Featured Image (desktop) *required',
                    'type'			=> 'mediafinder',
                    'imageWidth' 	=> '100',
                    'imageHeight' 	=> '100',
                    'tab'			=> 'cms::lang.editor.meta'
                ],
                'viewBag[featured_image_tablet]' => [
                    'label'         => 'Featured Image (tablet) *optional',
                    'type'          => 'mediafinder',
                    'imageWidth'    => '100',
                    'imageHeight'   => '100',
                    'tab'           => 'cms::lang.editor.meta'
                ],
                'viewBag[featured_image_mobile]' => [
                    'label'         => 'Featured Image (mobile) *optional',
                    'type'          => 'mediafinder',
                    'imageWidth'    => '100',
                    'imageHeight'   => '100',
                    'tab'           => 'cms::lang.editor.meta'
                ],
            ]);
        });
    }
}
