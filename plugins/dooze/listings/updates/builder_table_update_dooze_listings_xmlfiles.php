<?php namespace Dooze\Listings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDoozeListingsXmlfiles extends Migration
{
    public function up()
    {
        Schema::table('dooze_listings_xmlfiles', function($table)
        {
            $table->integer('mod_time');
            $table->string('address');
            $table->string('mod_date');
            $table->string('rex_id')->change();
        });
    }
    
    public function down()
    {
        Schema::table('dooze_listings_xmlfiles', function($table)
        {
            $table->dropColumn('mod_time');
            $table->dropColumn('address');
            $table->dropColumn('mod_date');
            $table->string('rex_id', 191)->change();
        });
    }
}
