<?php namespace Dooze\Listings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDoozeListings25 extends Migration
{
    public function up()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->text('events')->nullable();
            $table->string('address', 65535)->nullable()->change();
            $table->text('description')->nullable(false)->change();
            $table->string('suburb', 65535)->nullable(false)->unsigned(false)->default(null)->change();
            $table->renameColumn('xmlfile_id', 'rex_id');
            $table->renameColumn('facilities', 'attributes');
            $table->dropColumn('published');
            $table->dropColumn('slug');
            $table->dropColumn('inspection');
            $table->dropColumn('posterimage');
            $table->dropColumn('image_path');
            $table->dropColumn('xmlfile');
        });
    }
    
    public function down()
    {
        Schema::table('dooze_listings_', function($table)
        {
            $table->dropColumn('events');
            $table->string('address', 191)->nullable(false)->change();
            $table->text('description')->nullable()->change();
            $table->text('suburb')->nullable(false)->unsigned(false)->default(null)->change();
            $table->renameColumn('rex_id', 'xmlfile_id');
            $table->renameColumn('attributes', 'facilities');
            $table->smallInteger('published')->default(0);
            $table->string('slug', 191);
            $table->string('inspection', 191)->nullable();
            $table->string('posterimage', 191);
            $table->string('image_path', 191);
            $table->text('xmlfile');
        });
    }
}
