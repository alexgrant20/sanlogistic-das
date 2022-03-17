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
		Schema::create('companies', function (Blueprint $table) {
			$table->id();
			$table->foreignId('address_id');
			$table->foreignId('company_type_id');
			$table->string('name')->unique();
			$table->string('phone_number');
			$table->string('email');
			$table->text('note')->nullable();
			$table->string('website')->nullable();
			$table->string('director');
			$table->string('npwp');
			$table->string('fax')->nullable();
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('companies');
	}
};