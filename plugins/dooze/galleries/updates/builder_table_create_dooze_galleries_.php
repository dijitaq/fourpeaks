<?php namespace Dooze\Galleries\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDoozeGalleries extends Migration
{
    public function up()
    {
        Schema::create('dooze_galleries_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('dooze_galleries_');
    }
}
