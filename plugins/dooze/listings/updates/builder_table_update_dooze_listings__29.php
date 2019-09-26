<?php namespace Dooze\Listings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDoozeListings29 extends Migration
{
    public function up()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->string('price')->change();
            $table->string('on_offer')->change();
            $table->string('address')->change();
            $table->string('suburb')->change();
        });
    }
    
    public function down()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->string('price', 191)->change();
            $table->string('on_offer', 191)->change();
            $table->string('address', 191)->change();
            $table->string('suburb', 191)->change();
        });
    }
}
