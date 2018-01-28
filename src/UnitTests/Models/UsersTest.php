<?php

    namespace App\UnitTests\Models;

    use App\Models\Backend\Users;
    use App\Traits\Helper;

    final class UsersTest extends DBTest
    {
        private $__model;

        public function __construct($name = null, array $data = [], $dataName = '')
        {
            parent::__construct($name, $data, $dataName);
            $this->__model = new Users($this->_db);
        }

        public function testUserModelClass()
        {
            $this->assertInstanceOf(
                Users::class,
                $this->__model
            );
        }

        public function testUsersList()
        {
            if (!isset($_SESSION['Users']) || empty($_GET))
                $_SESSION['Users'] = array(
                    'nav' => array(
                        'sort' => '',
                        'order' => 'asc',
                        'paginate' => '',
                        'total_rows' => '',
                    )
                );

            $_SESSION['Users']['nav']['limit']       		= isset($_GET['l']) 	? Helper::sanitizeInput($_GET['l'], 'INT') 		: 5;
            $_SESSION['Users']['nav']['page']        		= isset($_GET['p']) 	? Helper::sanitizeInput($_GET['p'], 'STRING')   	: 1;
            $_SESSION['Users']['nav']['sort']        		= isset($_GET['s']) 	? Helper::sanitizeInput($_GET['s'], 'STRING')   	: '';
            $_SESSION['Users']['nav']['order']        		= isset($_GET['o']) 	? Helper::sanitizeInput($_GET['o'], 'STRING')   	: $_SESSION['Users']['nav']['order'];
            $_SESSION['Users']['nav']['start']       		= $_SESSION['Users']['nav']['page'] ? ($_SESSION['Users']['nav']['page'] - 1) * $_SESSION['Users']['nav']['limit'] : 0;
            $_SESSION['Users']['nav']['targetpage']  		= '?';

            $data = $this->__model->usersList();
            $this->assertArrayHasKey('list', $data);
            $this->assertArrayHasKey('paginate', $data);
            $this->assertArrayHasKey('total_rows', $data);
        }

    }