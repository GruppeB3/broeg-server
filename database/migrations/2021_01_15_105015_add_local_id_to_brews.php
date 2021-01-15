<?php

use App\Models\Brew;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocalIdToBrews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brews', function (Blueprint $table) {
            $table->addColumn('int', 'local_id')->after('user_id');
        });

        $brews = Brew::all();
        foreach ($brews as $brew) {
            if ($brew->local_id == null) {
                $brew->update(['local_id' => $brew->id]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brews', function (Blueprint $table) {
            $table->dropColumn('local_id');
        });
    }
}
