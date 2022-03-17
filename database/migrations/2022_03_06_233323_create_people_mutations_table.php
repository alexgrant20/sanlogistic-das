<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('people_mutations', function (Blueprint $table) {
			$table->id();
			$table->foreignId('person_id');
			$table->foreignId('created_by');
			$table->date('date');
			$table->string('mutation_number');
			$table->string('employee_number');
			$table->string('mutation_type');
			$table->date('apply_date');
			$table->text('description');
			$table->string('prob_sallary');
			$table->string('prob_allowance');
			$table->string('sallary');
			$table->string('allowance');
			$table->string('status');
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('people_mutations');
	}
};