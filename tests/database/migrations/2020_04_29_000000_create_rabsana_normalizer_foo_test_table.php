<?php
/**
 * Created by Rabsana Team <info.rabsana@gmail.com>
 * Website: https://rabsana.ir
 * Author: Sajjad Sisakhti <sajjad.30sakhti@gmail.com> <+989389785588>
 * Created At: 2020-04-30 04:14
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRabsanaNormalizerFooTestTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create('rabsana_normalizer_foo', function(Blueprint $table)
        {
            $table->increments('id');
            $table->decimal('price', 20, 8);
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
        \Illuminate\Support\Facades\Schema::drop('rabsana_normalizer_foo');
    }

}
