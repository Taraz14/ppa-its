<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Content extends Migration
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
      'categories_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'null' => true,
      ],
      'sub_categories_id' => [
        'type' => 'INT',
        'constraint' => 10,
        'null' => true,
      ],
      'content' => [
        'type' => 'TEXT',
        'null' => true,
      ],
      'title' => [
        'type' => 'VARCHAR',
        'constraint' => 500,
        'null' => true,
      ],
      'slug' => [
        'type' => 'VARCHAR',
        'constraint' => 500,
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
    $this->forge->createTable('content');
  }

  public function down()
  {
    $this->forge->dropTable('content');
  }
}
