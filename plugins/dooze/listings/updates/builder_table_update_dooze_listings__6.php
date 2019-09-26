<?php namespace Dooze\Listings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDoozeListings6 extends Migration
{
    public function up()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->dropColumn('images');
            $table->dropColumn('poster');
            $table->dropColumn('image_path');
        });
    }
    
    public function down()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->text('images');
            $table->string('poster', 191);
            $table->string('image_path', 191);
        });
    }
}
