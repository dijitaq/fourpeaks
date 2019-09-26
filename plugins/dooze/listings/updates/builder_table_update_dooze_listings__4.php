<?php namespace Dooze\Listings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDoozeListings4 extends Migration
{
    public function up()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->string('poster');
        });
    }
    
    public function down()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->dropColumn('poster');
        });
    }
}
