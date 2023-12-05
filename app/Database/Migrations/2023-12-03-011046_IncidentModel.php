<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class IncidentModel extends Migration
{
    /**
     * @var array
     */
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'location' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'date' => [
                'type' => 'DATETIME',
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'reported_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('reported_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('incidents', true);
    }

    /**
     * @var array
     */
    public function down()
    {
        //
    }
}
