<?php namespace Dooze\Listings\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Dooze\Listings\Models\Listing;
use Dooze\Listings\Models\Xmlfile;

class Xmlfiles extends FormWidgetBase
{
    /**
     * @var string A unique alias to identify this widget.
     */

    
    public function widgetDetails() {
        return [
            'name' => 'XML Files',
            'description' => 'Reads XML files from Rex',
        ];
    }

    public function render() {
        $this->prepareVars();
       // dump($this->vars['listings']);

        return $this->makePartial('widget');
    }

    public function prepareVars() {
        $files = glob(storage_path('app') . '\media\*.xml');
        $updated_file = '';

        if (isset($this->model->id)) {
            $this->vars['selectedValues'] = $this->getLoadValue();

            $this->vars['display_list'] = false;

            $rex_id = $this->vars['selectedValues'][0]['rex_id'];
            $current_mod_time = (int)$this->vars['selectedValues'][1]['mod_time'];

            $updated = [];
            $listings = [];
            $listings_s = [];
            $temp = [];
            
            foreach ($files as $file) {
                if (strpos($file, $rex_id) !== false) {
                    $xml = simplexml_load_file($file) or die("Error: Cannot create object");

                    $dateArr = explode("-", $xml->residential['modTime'] . "");

                    $timeArr = explode(":", $dateArr[3] . "");
                    
                    $time = mktime($timeArr[0], $timeArr[1], $timeArr[2], $dateArr[1], $dateArr[2], $dateArr[0]);
                    
                    $listing = [
                        'file' => $file,
                        'mod_time' => $time,
                        'mod_date' => $xml->residential['modTime'] . "",
                    ];
                    //dump($listing);
                    array_push($listings, $listing);
                }
            }
            
            $updated = array_reverse(array_sort($listings, function ($value) {
                return $value['mod_time'];
            }));

            $updated_mod_time = (int)$updated[0]['mod_time'];

            if ($updated_mod_time > $current_mod_time) {
                $this->vars['new_file'] = basename($updated[0]['file']);
                $this->vars['new_time'] = $updated[0]['mod_time'];
                $this->vars['new_date'] = $updated[0]['mod_date'];
            }

        } else {
            $this->vars['display_list'] = true;

            $this->vars['listings'] = [];
            $listings = [];
            $listings_s = [];
            $temp = [];
            $listings_t = [];
            
            foreach ($files as $file) {
                $xml = simplexml_load_file($file) or die("Error: Cannot create object");

                $dateArr = explode("-", $xml->residential['modTime'] . "");

                $timeArr = explode(":", $dateArr[3] . "");
                
                $time = mktime($timeArr[0], $timeArr[1], $timeArr[2], $dateArr[1], $dateArr[2], $dateArr[0]);
                
                $listing = [
                    'time' => $time,
                    'rex_id' => $xml->residential->uniqueID,
                    'mod_date' => $xml->residential['modTime'] . "",
                    'file' => basename($file),
                    'suburb' => $xml->residential->address->suburb,
                    'address' => $xml->residential->address->streetNumber . ' ' . $xml->residential->address->street,
                ];
                //print_r($listing);
                array_push($listings, $listing);
            }
            
            $listings_s = array_reverse(array_sort($listings, function ($value) {
                return $value['time'];
            }));

            $temp = array_unique(array_column($listings_s, 'address'));

            $this->vars['listings'] = array_intersect_key($listings_s, $temp);
        }
    }
}