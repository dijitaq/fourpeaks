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
        $this->vars['display_list'] = true;
        $this->vars['xmlfiles'] = [];
        
        $xmlfiles = [];
        $xmlfiles_s = [];
        $xmlfiles_t = [];
        $temp = [];
        $updated = [];

        if (isset($this->model->id)) {
            $this->vars['display_list'] = false;

            $this->vars['selectedValues'] = $this->getLoadValue();

            $rex_id = $this->vars['selectedValues'][0]['rex_id'];
            $current_mod_time = (int)$this->vars['selectedValues'][1]['mod_time'];

        } else {
            $this->vars['display_list'] = true;

            if (count(Xmlfile::get())) {
                $this->vars['xmlfiles'] = Xmlfile::orderBy('mod_time')->get();

                $li = Listing::get();
                foreach($li as $l) {
                   // dump(Listing::find($l->id)->xmlfile);
                }

                $xf = Xmlfile::get();
                foreach($xf as $x) {
                   // dump(Xmlfile::find($x->id)->listing);
                }

            } else {
                $files = glob(storage_path('app') . '\media\*.xml');

                foreach ($files as $file) {
                    $xml = simplexml_load_file($file) or die("Error: Cannot create object");

                    $dateArr = explode("-", $xml->residential['modTime'] . "");

                    $timeArr = explode(":", $dateArr[3] . "");
                
                    $time = mktime($timeArr[0], $timeArr[1], $timeArr[2], $dateArr[1], $dateArr[2], $dateArr[0]);

                    $xmlfile = [
                        'rex_id' => $xml->residential->uniqueID,
                        'mod_time' => $time,
                        'mod_date' => $xml->residential['modTime'] . "",
                        'address' => $xml->residential->address->suburb . " - " . $xml->residential->address->streetNumber . " " . $xml->residential->address->street . "",
                        'file' => basename($file),
                    ];
                    //print_r($listing);
                    array_push($xmlfiles, $xmlfile);
                }
                //dump($listings);

                $xmlfiles_s = array_reverse(array_sort($xmlfiles, function ($value) {
                    return $value['mod_time'];
                }));

                //dump($listings_s);

                $temp = array_unique(array_column($xmlfiles_s, 'rex_id'));

                $xmlfiles_t = array_intersect_key($xmlfiles_s, $temp);

                //dump($listings_t);

                foreach ($xmlfiles_t as $xmlfile) {
                    $xf = new Xmlfile;
                    $xf->rex_id = $xmlfile['rex_id'];
                    $xf->mod_time = $xmlfile['mod_time'];
                    $xf->mod_date = $xmlfile['mod_date'];
                    $xf->address = $xmlfile['address'];
                    $xf->file = $xmlfile['file'];
                    $xf->save();
                    //dump(strlen($listing['address']));
                }

                $this->vars['xmlfiles'] = Xmlfile::orderBy('mod_time')->get();
            }
        }
        //dump(count(Xmlfile::get()));
    }
}