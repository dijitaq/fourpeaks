<?php namespace Dooze\Listings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDoozeListings31 extends Migration
{
    public function up()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->string('image_path')->change();
            $table->renameColumn('attributes', 'facilities');
        });
    }
    
    public function down()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->string('image_path', 191)->change();
            $table->renameColumn('facilities', 'attributes');
        });
    }
}
