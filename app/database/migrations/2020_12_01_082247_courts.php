<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Courts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courts', function (Blueprint $table) {
            $table->id();
            $table->string('acronym');
            $table->string('name_nl')->nullable();
            $table->string('name_de')->nullable();
            $table->string('name_fr')->nullable();
            $table->string('def')->nullable();
            $table->string('court_href')->nullable();
            $table->string('logo_href')->nullable();
            $table->integer('category_id')->nullable();
            $table->timestamps();
            $table->index('acronym');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('courts');
    }
}
