<?php namespace Dooze\Listings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDoozeListings extends Migration
{
    public function up()
    {
        Schema::create('dooze_listings_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->smallInteger('published')->default(0);
            $table->string('address');
            $table->string('slug');
            $table->string('price');
            $table->smallInteger('under_offer')->default(0);
            $table->text('facilities')->nullable();
            $table->text('description')->nullable();
            $table->integer('suburb_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('dooze_listings_');
    }
}
