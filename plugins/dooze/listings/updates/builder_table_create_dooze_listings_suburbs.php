<?php namespace Dooze\Listings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDoozeListingsSuburbs extends Migration
{
    public function up()
    {
        Schema::create('dooze_listings_suburbs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('suburb_name');
            $table->string('slug');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('dooze_listings_suburbs');
    }
}
