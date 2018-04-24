<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try{
            Schema::create('links', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title')->comment('资源的描述')->index();
                $table->string('link')->comment('资源的链接')->index();
                $table->timestamps();
            });
        }catch (\Illuminate\Database\QueryException $e) {
            app('log')->error($e->getMessage());
        }

    }

    public function down()
    {
        Schema::dropIfExists('links');
    }
}