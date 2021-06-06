<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use phpDocumentor\Reflection\PseudoTypes\True_;

class Orang extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'nama'       => [
				'type'       => 'VARCHAR',
				'constraint' => '225',
			],
			'alamat' => [
				'type' => 'VARCHAR',
				'constraint' => '225',
			],
			'created_at' => [
				'type' => 'DATETIME',
				'null' => True
			],
			'updated_at' => [
				'type' => 'DATETIME',
				'null' => True
			]

		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('orang');
	}

	public function down()
	{
		$this->forge->dropTable('orang');
	}
}
