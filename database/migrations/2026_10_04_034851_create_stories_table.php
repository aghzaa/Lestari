<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->unsignedSmallInteger('umur');
            $table->string('jenis_kelamin', 20);
            $table->string('pendidikan', 30);
            $table->string('kategori', 50);
            $table->text('cerita');
            $table->text('motivation_text')->nullable();
            $table->text('quote_text')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stories');
    }
}
