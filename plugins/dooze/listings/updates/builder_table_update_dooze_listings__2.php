<?php namespace Dooze\Listings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDoozeListings2 extends Migration
{
    public function up()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->text('images');
        });
    }
    
    public function down()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->dropColumn('images');
        });
    }
}
