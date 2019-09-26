<?php namespace Dooze\Listings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDoozeListingsXmlfiles extends Migration
{
    public function up()
    {
        Schema::create('dooze_listings_xmlfiles', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('rex_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('dooze_listings_xmlfiles');
    }
}
