<?php

    namespace App\UnitTests\Models;

    use App\Models\Backend\Panel;

    final class PanelTest extends DBTest
    {
        private $__model;

        public function __construct($name = null, array $data = [], $dataName = '')
        {
            parent::__construct($name, $data, $dataName);
            $this->__model = new Panel($this->_db);
        }

        public function testPanelModelClass()
        {
            $this->assertInstanceOf(
                Panel::class,
                $this->__model
            );
        }

        public function testAuthenticateUser()
        {
            $userAuthenticate = $this->__model->authenticateUser('admin', 'admin');

            $this->assertTrue($userAuthenticate);
        }
    }