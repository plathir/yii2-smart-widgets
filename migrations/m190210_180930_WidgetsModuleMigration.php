<?php

use yii\db\Migration;

class m190210_180930_WidgetsModuleMigration extends Migration {

    public function up() {

        $this->CreateModuleTables();
    }

    public function down() {
        $this->dropIfExist('widgets');
        $this->dropIfExist('widgets_positions_sorder');
        $this->dropIfExist('widgets_positions');
        $this->dropIfExist('widgets_types');
        $this->dropIfExist('widgets_layouts');
    }

    public function CreateModuleTables() {

        $this->dropIfExist('widgets');
        $this->dropIfExist('widgets_positions_sorder');
        $this->dropIfExist('widgets_positions');
        $this->dropIfExist('widgets_types');
        $this->dropIfExist('widgets_layouts');

        // Widget Types Table
        $this->createTable('{{%widgets_types}}', [
            'tech_name' => $this->string(50)->notNull(),
            'module_name' => $this->string(50)->notNull(),
            'widget_name' => $this->string(50)->notNull(),
            'widget_class' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
                ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addPrimaryKey('pk_widgets_types', '{{%widgets_types}}', ['tech_name']);


        // Widget Positions
        $this->createTable('{{%widgets_positions}}', [
            'tech_name' => $this->string(50)->notNull(),
            'name' => $this->string(100)->notNull(),
            'publish' => $this->integer()->notNull(),
            'module_name' => $this->string(50)->notNull(),
                ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addPrimaryKey('pk_widgets_positions', '{{%widgets_positions}}', ['tech_name']);

        // Widget Positions sort order
        $this->createTable('{{%widgets_positions_sorder}}', [
            'position_tech_name' => $this->string(50)->notNull(),
            'widget_sort_order' => $this->text(),
                ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addPrimaryKey('pk_widgets_positions_sorder', '{{%widgets_positions_sorder}}', ['position_tech_name']);
        $this->addForeignKey('fk_widgets_position_position_tech_name', '{{%widgets_positions_sorder}}', 'position_tech_name', '{{%widgets_positions}}', 'tech_name', 'CASCADE', 'CASCADE');

// Widgets Layouts
        // Widget Positions
        $this->createTable('{{%widgets_layouts}}', [
            'tech_name' => $this->string(50)->notNull(),
            'name' => $this->string(100)->notNull(),
            'path' => $this->text()->notNull(),
            'html_layout' => $this->text()->notNull(),
            'publish' => $this->integer(11)->notNull(),
            'module_name' => $this->string(50)->notNull(),
                ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addPrimaryKey('pk_widgets_layouts', '{{%widgets_layouts}}', ['tech_name']);

        // Widgets
        $this->createTable('{{%widgets}}', [
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
                ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');


        $this->addForeignKey('fk_widgets_widget_type', '{{%widgets}}', 'widget_type', '{{%widgets_types}}', 'tech_name', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_widgets_position', '{{%widgets}}', 'position', '{{%widgets_positions}}', 'tech_name', 'SET NULL', 'CASCADE');
    }

    public function dropIfExist($tableName) {
        if (in_array($this->db->tablePrefix . $tableName, $this->getDb()->schema->tableNames)) {
            $this->dropTable($this->db->tablePrefix . $tableName);
        }
    }

}
