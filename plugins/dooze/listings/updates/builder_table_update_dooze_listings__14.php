<?php namespace Dooze\Listings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDoozeListings14 extends Migration
{
    public function up()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->dropColumn('rex_id');
            $table->dropColumn('xml_modtime');
        });
    }
    
    public function down()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->string('rex_id', 191);
            $table->integer('xml_modtime');
        });
    }
}
