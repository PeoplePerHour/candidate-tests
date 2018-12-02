<?php

use PHPUnit\Framework\TestCase;
use Manager\Store\ConnectionManager;
use Manager\Driver\Config;
use Manager\Model\Model;

class ModelTest extends TestCase {

    public function test_select_query_return_not_empty_array_of_results()
    {
        $manager = new ConnectionManager(new Config('postgres'));
        $connection = $manager->connect();
        $model = new Model($connection);
        $results = $model->select()->from('users')->results();
        $this->assertNotEquals($results,[]);
    }

    public function test_select_data_with_where_clause()
    {
        $manager = new ConnectionManager(new Config('postgres'));
        $connection = $manager->connect();
        $model = new Model($connection);
        $result = $model->select()->from('users')->where('user_id = 152')->results();
        $this->assertEquals($result[0]["firstname"], "Test");
    }

    public function test_select_data_with_where_and_clause()
    {
        $manager = new ConnectionManager(new Config('postgres'));
        $connection = $manager->connect();
        $model = new Model($connection);
        $result = $model->select()->from('users')->where("user_id = 152 and lastname = 'User'")->results();
        $this->assertEquals($result[0]["email"], "test@user.com");
    }

    public function test_select_data_with_pagination()
    {
        $manager = new ConnectionManager(new Config('postgres'));
        $connection = $manager->connect();
        $model = new Model($connection);
        $result = $model->select()->from('users')->paginate(0,5)->results();
        $this->assertEquals(count($result), 5);
    }

    public function test_select_data_with_order()
    {
        $manager = new ConnectionManager(new Config('postgres'));
        $connection = $manager->connect();
        $model = new Model($connection);
        $result = $model->select('user_id')->from('users')->orderBy('user_id', 'asc')->results();
        $first_row = $result[0]["user_id"];
        $second_row = $result[1]["user_id"];
        $this->assertTrue($second_row > $first_row);
    }

    public function test_select_data_with_limit()
    {
        $manager = new ConnectionManager(new Config('postgres'));
        $connection = $manager->connect();
        $model = new Model($connection);
        $result = $model->select('user_id')->from('users')->limit(2)->results();
        $this->assertEquals(count($result), 2);
    }

    public function test_select_data_exception()
    {
        $manager = new ConnectionManager(new Config('postgres'));
        $connection = $manager->connect();
        $model = new Model($connection);
        $this->expectException(Exception::class);
        $model->select('user_id')->limit(2)->results();
    }

    public function test_insert_data()
    {
        $manager = new ConnectionManager(new Config('postgres'));
        $connection = $manager->connect();
        $model = new Model($connection);
        $result = $model->insert('users', ['firstname' => 'Foo', 'lastname' => 'Bar', 'email' => 'foo@bar.com']);
        $this->assertTrue($result);
    }

    public function test_update_data()
    {
        $manager = new ConnectionManager(new Config('postgres'));
        $connection = $manager->connect();
        $model = new Model($connection);
        $result = $model->update('users', ['firstname' => 'bob'], 'user_id = 213');
        $this->assertTrue($result);
    }

    public function test_delete_data()
    {
        $manager = new ConnectionManager(new Config('postgres'));
        $connection = $manager->connect();
        $model = new Model($connection);
        $result = $model->delete('users', 'user_id = 187');
        $this->assertTrue($result);
    }

    public function test_delete_all_data()
    {
        $manager = new ConnectionManager(new Config('postgres'));
        $connection = $manager->connect();
        $model = new Model($connection);
        $result = $model->deleteAll('posts');
        $this->assertTrue($result);
    }

    public function test_delete_data_exception()
    {
        $manager = new ConnectionManager(new Config('postgres'));
        $connection = $manager->connect();
        $model = new Model($connection);
        $this->expectException(Exception::class);
        $model->delete('users', null);
    }

}

