<?php namespace Dooze\Listings\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Dooze\Listings\Models\Listing;

class Galleryimages extends FormWidgetBase
{
    /**
     * @var string A unique alias to identify this widget.
     */

    
    public function widgetDetails() {
        return [
            'name' => 'Gallery Images',
            'description' => 'Display gallery images',
        ];
    }

    public function render() {
        $this->prepareVars();

        return $this->makePartial('widget');
    }

    public function prepareVars() {
        //dump(Listing::find($this->model->id)->image_path);

        $this->vars['selectedValues'] = $this->getLoadValue();

        if (isset($this->model->id)) {
            $this->vars['image_path'] = Listing::find($this->model->id)->image_path;
        }
    }
}