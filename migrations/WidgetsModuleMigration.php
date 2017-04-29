<?php

namespace plathir\widgets\migrations;


use yii\db\Migration;

class WidgetsModuleMigration extends Migration {

    public function up() {

        $this->CreateModuleTables();

    }
    
    public function down() {
        $this->dropIfExist('widgets');
        $this->dropIfExist('widgets_positions_sorder');
        $this->dropIfExist('widgets_positions');
        $this->dropIfExist('widgets_types');
    }


    public function CreateModuleTables() {

        $this->dropIfExist('widgets');
        $this->dropIfExist('widgets_positions_sorder');
        $this->dropIfExist('widgets_positions');
        $this->dropIfExist('widgets_types');
        
        // Widget Types Table
        $this->createTable('widgets_types', [
            'tech_name' => $this->string(50)->notNull(),
            'module_name' => $this->string(50)->notNull(),
            'widget_name' => $this->string(50)->notNull(),
            'widget_class' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
        ]);

        $this->addPrimaryKey('pk_widgets_types', 'widgets_types', ['tech_name']);
        
        
        // Widget Positions
        $this->createTable('widgets_positions', [
            'tech_name' => $this->string(50)->notNull(),
            'name' => $this->string(100)->notNull(),
            'publish' => $this->integer()->notNull(),
            'module_name' => $this->string(50)->notNull(),            
        ]);

        $this->addPrimaryKey('pk_widgets_positions', 'widgets_positions', ['tech_name']);

        // Widget Positions sort order
        $this->createTable('widgets_positions_sorder', [
            'position_tech_name' => $this->string(50)->notNull(),
            'widget_sort_order' => $this->text(),
        ]);

        $this->addPrimaryKey('pk_widgets_positions_sorder', 'widgets_positions_sorder', ['position_tech_name']);
        $this->addForeignKey('fk_widgets_position_position_tech_name', 'widgets_positions_sorder', 'position_tech_name', 'widgets_positions', 'tech_name', 'CASCADE', 'CASCADE');
        
        // Widgets
        $this->createTable('widgets', [
            'id' => $this->primaryKey(),
            'widget_type' => $this->string(50)->notNull(),
            'name' => $this->string(50)->notNull(),
            'description' => $this->text()->notNull(),
            'position' => $this->string(50),
            'publish' => $this->string(1)->notNull(),
            'config' => $this->text()->notNull(),
            'rules' => $this->text()->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ]);

        $this->addForeignKey('fk_widgets_widget_type', 'widgets', 'widget_type', 'widgets_types', 'tech_name', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_widgets_position', 'widgets', 'position', 'widgets_positions', 'tech_name', 'SET NULL', 'CASCADE');
        
    }

    public function dropIfExist($tableName) {
        if (in_array($tableName, $this->getDb()->schema->tableNames)) {
            $this->dropTable($tableName);
        }
    }

}
