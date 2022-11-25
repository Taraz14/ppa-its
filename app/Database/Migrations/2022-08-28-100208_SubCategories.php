<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SubCategories extends Migration
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
      'sub_categories' => [
        'type' => 'VARCHAR',
        'constraint' => 300,
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
    $this->forge->createTable('sub_categories');
  }

  public function down()
  {
    $this->forge->dropTable('sub_categories');
  }
}
