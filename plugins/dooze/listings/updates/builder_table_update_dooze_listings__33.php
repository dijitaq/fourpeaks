<?php namespace Dooze\Listings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDoozeListings33 extends Migration
{
    public function up()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->string('poster_image');
            $table->string('image_path')->change();
            $table->string('slug')->change();
        });
    }
    
    public function down()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->dropColumn('poster_image');
            $table->string('image_path', 191)->change();
            $table->string('slug', 191)->change();
        });
    }
}
