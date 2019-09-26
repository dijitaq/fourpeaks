<?php namespace Dooze\Listings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDoozeListingsXmlfiles3 extends Migration
{
    public function up()
    {
        Schema::table('dooze_listings_xmlfiles', function($table)
        {
            $table->renameColumn('url', 'file');
        });
    }
    
    public function down()
    {
        Schema::table('dooze_listings_xmlfiles', function($table)
        {
            $table->renameColumn('file', 'url');
        });
    }
}
