<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'id' => [
        'type' => 'INT',
        'constraint' => 10,
        'unsigned' => true,
        'auto_increment' => true,
      ],
      'nama_depan' => [
        'type' => 'VARCHAR',
        'constraint' => 50,
        'null' => true,
      ],
      'nama_belakang' => [
        'type' => 'VARCHAR',
        'constraint' => 50,
        'null' => true,
      ],
      'password' => [
        'type' => 'VARCHAR',
        'constraint' => 250,
        'null' => true,
      ],
      'email' => [
        'type' => 'VARCHAR',
        'constraint' => 100,
        'null' => true,
      ],
      'profile_picture' => [
        'type' => 'VARCHAR',
        'constraint' => 500,
        'null' => true,
      ],
      'level' => [
        'type' => 'TINYINT',
        'null' => true,
      ],
      'status' => [
        'type' => 'TINYINT',
        'constraint' => 1,
        'null' => true,
      ],
      'updated_at' => [
        'type' => 'datetime',
        'null' => true,
      ],
      'deleted_at' => [
        'type' => 'datetime',
        'null' => true,
      ],
      'created_at datetime default current_timestamp',

    ]);
    $this->forge->addPrimaryKey('id');
    $this->forge->createTable('user');
  }

  public function down()
  {
    $this->forge->dropTable('user');
  }
}
