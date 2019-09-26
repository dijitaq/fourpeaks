<?php namespace Dooze\Listings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDoozeListingsXmlfiles2 extends Migration
{
    public function up()
    {
        Schema::create('dooze_listings_xmlfiles', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('rex_id');
            $table->integer('mod_time');
            $table->string('mod_date');
            $table->string('address');
            $table->string('file');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('dooze_listings_xmlfiles');
    }
}
