<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class CitiesMigration_101
 */
class CitiesMigration_101 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('cities', [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'autoIncrement' => true,
                            'size' => 11,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'city',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'size' => 50,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'lat',
                        [
                            'type' => Column::TYPE_FLOAT,
                            'notNull' => true,
                            'size' => 10,
                            'scale' => 6,
                            'after' => 'city'
                        ]
                    ),
                    new Column(
                        'lon',
                        [
                            'type' => Column::TYPE_FLOAT,
                            'notNull' => true,
                            'size' => 10,
                            'scale' => 6,
                            'after' => 'lat'
                        ]
                    ),
                    new Column(
                        'timestamp',
                        [
                            'type' => Column::TYPE_TIMESTAMP,
                            'default' => "current_timestamp()",
                            'size' => 1,
                            'after' => 'lon'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY')
                ],
                'options' => [
                    'TABLE_TYPE' => 'BASE TABLE',
                    'AUTO_INCREMENT' => '4',
                    'ENGINE' => 'InnoDB',
                    'TABLE_COLLATION' => 'utf8_general_ci'
                ],
            ]
        );
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {

    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {

    }

}
