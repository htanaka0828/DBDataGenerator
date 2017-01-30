<?php
namespace Htanaka0828\DbDataGeneratorTest;

use Htanaka0828\DbDataGenerator\Generator as Target;


class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerate()
    {
        $target = new Target();
        $this->assertInstanceOf(Target::class, $target);
    }

    public function testConnection()
    {
        $target = new Target();
        // CREATE DATABASE test_db DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
        $target->addConnection([
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'test_db',
            'username'  => 'root',
            'password'  => 'password',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => ''
        ]);
        $this->assertTrue(true);
    }
}
