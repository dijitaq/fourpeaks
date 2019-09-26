<?php namespace Dooze\Listings\FormWidgets;

use Backend\Classes\FormWidgetBase;

class Posterimage extends FormWidgetBase
{
    /**
     * @var string A unique alias to identify this widget.
     */

    
    public function widgetDetails() {
        return [
            'name' => 'Poster Image',
            'description' => 'Display listing poster image',
        ];
    }

    public function render() {
        $this->prepareVars();
        //dump($this->vars['basename']);

        return $this->makePartial('widget');
    }

    public function prepareVars() {
        $this->vars['selectedValues'] = $this->getLoadValue();
        $this->vars['basename'] = basename($this->vars['selectedValues']);
    }
}