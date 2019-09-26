<?php namespace Dooze\Listings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDoozeListings extends Migration
{
    public function up()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->text('suburb');
            $table->dropColumn('suburb_id');
        });
    }
    
    public function down()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->dropColumn('suburb');
            $table->integer('suburb_id')->unsigned();
        });
    }
}
