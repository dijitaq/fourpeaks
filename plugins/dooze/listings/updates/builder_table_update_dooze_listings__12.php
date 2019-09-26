<?php namespace Dooze\Listings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDoozeListings12 extends Migration
{
    public function up()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->string('rex_id');
        });
    }
    
    public function down()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->dropColumn('rex_id');
        });
    }
}
