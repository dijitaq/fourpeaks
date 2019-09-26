<?php namespace Dooze\Listings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDoozeListings16 extends Migration
{
    public function up()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->integer('xmlfile_id')->unsigned();
            $table->dropColumn('xmlfile');
        });
    }
    
    public function down()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->dropColumn('xmlfile_id');
            $table->text('xmlfile');
        });
    }
}
