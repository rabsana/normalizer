<?php
/**
 * Created by Rabsana Team <info.rabsana@gmail.com>
 * Website: https://rabsana.ir
 * Author: Sajjad Sisakhti <sajjad.30sakhti@gmail.com> <+989389785588>
 * Created At: 2020-04-29 04:00
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRabsanaNormalizerNormalizersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create('rabsana_normalizer_normalizers', function(Blueprint $table)
        {
            $table->increments('id');
            $table->boolean('active');
            $table->decimal('from', 20, 8);
            $table->decimal('to', 20, 8);
            $table->string('prop');
            $table->integer('normalizable_id');
            $table->string('normalizable_type');
            $table->decimal('ratio', 20, 8);
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
        \Illuminate\Support\Facades\Schema::drop('rabsana_normalizer_normalizers');
    }

}
