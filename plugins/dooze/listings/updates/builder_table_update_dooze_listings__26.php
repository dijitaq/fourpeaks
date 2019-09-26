<?php namespace Dooze\Listings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDoozeListings26 extends Migration
{
    public function up()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->integer('rex_id');
            $table->integer('mod_time');
            $table->string('price');
            $table->string('on_offer');
            $table->string('address');
            $table->string('suburb');
            $table->text('attributes');
            $table->text('events');
            $table->text('images');
            $table->text('description');
        });
    }
    
    public function down()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->dropColumn('rex_id');
            $table->dropColumn('mod_time');
            $table->dropColumn('price');
            $table->dropColumn('on_offer');
            $table->dropColumn('address');
            $table->dropColumn('suburb');
            $table->dropColumn('attributes');
            $table->dropColumn('events');
            $table->dropColumn('images');
            $table->dropColumn('description');
        });
    }
}
