<?php namespace Dooze\Listings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDoozeListingsXmlfiles2 extends Migration
{
    public function up()
    {
        Schema::table('dooze_listings_xmlfiles', function($table)
        {
            $table->string('url');
        });
    }
    
    public function down()
    {
        Schema::table('dooze_listings_xmlfiles', function($table)
        {
            $table->dropColumn('url');
        });
    }
}
