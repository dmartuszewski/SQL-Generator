<?php

require_once 'PHPUnit/Autoload.php';

require_once dirname(__FILE__) . '/../class.SqlGenerator.php';

/**
 * Test class for SqlGenerator.
 * Generated by PHPUnit on 2011-08-19 at 08:06:54.
 */
class SqlGeneratorTest extends PHPUnit_Framework_TestCase {

    /**
     * @var SqlGenerator
     */
    protected $object;


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new SqlGenerator;
    }


    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }


    public function testSelect() {
        $exp = 'SELECT name,age FROM users;';
        $act = $this->object->select('name,age')->from('users')->getSql(true);
        
        $this->assertEquals($exp, $act);
    }


    public function testSelectAll() {
        $exp = 'SELECT * FROM users';
        $act = $this->object->select('*')->from('users')->getSql();
        
        $this->assertEquals($exp, $act);
    }


    public function testInsert() {
        $values = array(
            array('name' => 'Marcin', 'surname' => 'Kowalski', 'age' => 14),
            array('name' => 'Rafał', 'surname' => 'Nowak', 'age' => 19),
            array('name' => 'Stanisław', 'surname' => 'Adamczyk', 'age' => 33)
        );
        
        $exp = 'INSERT INTO users (name, surname, age) VALUES ("Marcin", "Kowalski", 14), ("Rafał", "Nowak", 19), ("Stanisław", "Adamczyk", 33)';
        $act = $this->object->insert($values)->into('users')->getSql();

        $this->assertEquals($exp, $act);
    }


    public function testInto() {
        $values = array(
            array('name' => 'Marcin'),
            array('name' => 'Rafał'),
            array('name' => 'Stanisław')
        );
        
        $exp = 'INSERT INTO users (name) VALUES ("Marcin"), ("Rafał"), ("Stanisław")';
        $act = $this->object->insert($values)->into('users')->getSql();

        $this->assertEquals($exp, $act);
    }


    public function testUpdate() {
        $exp = 'UPDATE users SET name = "Agnes", age = 17;';
        $act = $this->object->update('users')->set('name', 'Agnes')->set('age', 17)->getSql(true);

        $this->assertEquals($exp, $act);
    }


    public function testSet() {
        $exp = 'UPDATE users SET name = "Agnes";';
        $act = $this->object->update('users')->set('name', 'Agnes')->getSql(true);

        $this->assertEquals($exp, $act);
    }


    public function testSetMultiple() {
        $exp = 'UPDATE users SET name = "Agnes", age = 17;';
        $act = $this->object->update('users')->set('name', 'Agnes')->set('age', 17)->getSql(true);

        $this->assertEquals($exp, $act);
    }


    public function testDelete() {
        $exp = 'DELETE FROM users';
        $act = $this->object->delete('users')->getSql();
        
        $this->assertEquals($exp, $act);
    }


    public function testLimit() {
        $exp = 'SELECT * FROM users LIMIT 3';
        $act = $this->object->select('*')->from('users')->limit(3)->getSql();
        
        $this->assertEquals($exp, $act);
    }


    public function testTable() {
        $exp = 'SELECT * FROM users';
        $act = $this->object->select('*')->table('users')->getSql();
        
        $this->assertEquals($exp, $act);
    }


    public function testTables() {
        $exp = 'SELECT * FROM users, profiles, tokens';
        $act = $this->object->select('*')->tables(array('users', 'profiles', 'tokens'))->getSql();
        
        $this->assertEquals($exp, $act);
    }


    public function testWhere() {
        $exp = 'SELECT * FROM users WHERE id = 10';
        $act = $this->object->select('*')->from('users')->where('id =', 10)->getSql();
        
        $this->assertEquals($exp, $act);
    }


    public function testWhereOr() {
        $exp = 'SELECT * FROM users WHERE age = 10 OR name = "Dan"';
        $act = $this->object->select('*')->from('users')->where('age =', 10)->where('name =', 'Dan', 'OR')->getSql();
        
        $this->assertEquals($exp, $act);
    }


    public function testWhereMultiple() {
        $exp = 'SELECT * FROM users WHERE age = 10 AND name = "Dan"';
        $act = $this->object->select('*')->from('users')->where('age =', 10)->where('name =', 'Dan', 'AND')->getSql();
        
        $this->assertEquals($exp, $act);
    }


    public function testWhereWithoutCondition() {
        $exp = 'SELECT * FROM users WHERE id IN (1, 3, 4)';
        $act = $this->object->select('*')->from('users')->where('id')->in(array(1,3,4))->getSql();
        
        $this->assertEquals($exp, $act);
    }
    
    public function testAndSql() {
        $exp = 'SELECT * FROM users WHERE age = 4 AND city = "New York"';
        $act = $this->object->select('*')->from('users')->where('age =', 4)->andSql('city =', 'New York')->getSql();
        
        $this->assertEquals($exp, $act);
    }


    public function testOrSql() {
        $exp = 'SELECT * FROM users WHERE age = 4 OR city = "New York"';
        $act = $this->object->select('*')->from('users')->where('age =', 4)->orSql('city =', 'New York')->getSql();
        
        $this->assertEquals($exp, $act);
    }


    public function testLike() {
        $exp = 'SELECT * FROM users WHERE name LIKE "a%"';
        $act = $this->object->select()->from('users')->like('name', 'a%')->getSql();
     
        $this->assertEquals($exp, $act);
    }

    public function testLikeWithoutFields() {
        $exp = 'SELECT * FROM users WHERE name LIKE "a%"';
        $act = $this->object->select()->from('users')->where('name')->like('a%')->getSql();
     
        $this->assertEquals($exp, $act);
    }


    public function testIn() {
        $exp = 'SELECT * FROM users WHERE code IN (1, "Dan", 3, "Paul")';
        $act = $this->object->select()->from('users')->in('code', array(1, 'Dan', 3, 'Paul'))->getSql();
     
        $this->assertEquals($exp, $act);
    }


    public function testSetTables() {
        $exp = 'SELECT * FROM users, profiles, tokens';
        $act = $this->object->select()->setTables(array('users','profiles','tokens'))->getSql();
     
        $this->assertEquals($exp, $act);
    }


    public function testSetFields() {
        $exp = 'SELECT id, name, age FROM users';
        $act = $this->object->select()->setFields(array('id','name','age'))->from('users')->getSql();
     
        $this->assertEquals($exp, $act);
    }


    public function testSetSql() {
        $exp = 'SELECT id, name, age FROM users';
        $act = $this->object->setSql($exp)->getSql();
     
        $this->assertEquals($exp, $act);
    }


    /**
     * @todo Implement testReset().
     */
    public function testReset() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }


    public function testFrom() {
        $exp = 'SELECT id, name, age FROM users';
        $act = $this->object->select(array('id', 'name', 'age'))->from('users')->getSql();
     
        $this->assertEquals($exp, $act);
    }


    public function testGetSql() {
        $exp = 'SELECT id, name, age FROM users';
        $act = $this->object->select(array('id', 'name', 'age'))->from('users')->getSql();

        $this->assertEquals($exp, $act);
    }


    public function testBuildDeleteSql() {
        $exp = 'DELETE FROM users WHERE id > 5';
        $act = $this->object->delete('users')->where('id >', 5)->getSql();
        
        $this->assertEquals($exp, $act);
    }


    public function testGetSqlAction() {
        $exp = 'UPDATE';
        $act = $this->object->update('users')->set('name', 'Dan')->where('id =', 5)->getSqlAction();
     
        $this->assertEquals($exp, $act);
    }


    public function testGroup() {
        $exp = 'SELECT * FROM users GROUP BY city';
        $act = $this->object->select()->from('users')->group('city')->getSql();
     
        $this->assertEquals($exp, $act);
    }
    
    public function testDistinct() {
        $exp = 'SELECT DISTINCT name FROM users';
        $act = $this->object->select('name')->distinct()->from('users')->getSql();
     
        $this->assertEquals($exp, $act);
    }
    
    public function testDistinctAsSelectParameter() {
        $exp = 'SELECT DISTINCT name FROM users';
        $act = $this->object->select('name', true)->from('users')->getSql();
     
        $this->assertEquals($exp, $act);
    }
    
    public function testOrder() {
        $exp = 'SELECT name, lastname FROM users ORDER BY lastname';
        $act = $this->object->select(array('name', 'lastname'))->from('users')->order('lastname')->getSql();
     
        $this->assertEquals($exp, $act);
    }
    
    public function testOrderASC() {
        $exp = 'SELECT name, lastname FROM users ORDER BY lastname ASC';
        $act = $this->object->select(array('name', 'lastname'))->from('users')->order('lastname ASC')->getSql();
     
        $this->assertEquals($exp, $act);
    }


    /**
     * @todo Implement test__toString().
     */
    public function test__toString() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}

?>