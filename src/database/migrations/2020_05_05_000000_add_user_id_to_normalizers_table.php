<?php
/**
 * Created by Rabsana Team <info.rabsana@gmail.com>
 * Website: https://rabsana.ir
 * Author: Sajjad Sisakhti <sajjad.30sakhti@gmail.com> <+989389785588>
 * Created At: 2020-04-29 04:00
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddUserIdToNormalizersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::table('rabsana_normalizer_normalizers', function(Blueprint $table)
        {
            $table->integer('user_id')->nullable()->default(null);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\Schema::table('rabsana_normalizer_normalizers', function (Blueprint $table) {
            if(\Illuminate\Support\Facades\Schema::hasColumn('rabsana_normalizer_normalizers', 'user_id')){
                $table->dropColumn('user_id');
            }
        });
    }

}
