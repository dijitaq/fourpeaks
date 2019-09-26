<?php namespace Dooze\Listings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDoozeListingsXmlfiles6 extends Migration
{
    public function up()
    {
        Schema::table('dooze_listings_xmlfiles', function($table)
        {
            $table->integer('listing_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::table('dooze_listings_xmlfiles', function($table)
        {
            $table->dropColumn('listing_id');
        });
    }
}
