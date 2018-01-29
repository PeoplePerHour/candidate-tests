<?php

    namespace App\Entities;


    class UserEntity
    {
        protected $_id;
        protected $_user_name;
        protected $_name;
        protected $_last_name;
		protected $_password;
        protected $_email;
        protected $_is_enabled;
        protected $_in_backend;

		public function __construct(array $data)
        {
            if(isset($data['id']))
                $this->_id = $data['id'];

            if(isset($data['user_name']))
                $this->_user_name = $data['user_name'];

            if(isset($data['name']))
                $this->_name = $data['name'];

            if(isset($data['last_name']))
                $this->_last_name = $data['last_name'];

			if(isset($data['password']))
				$this->_password = $data['password'];

            if(isset($data['email']))
                $this->_email = $data['email'];

            if(isset($data['is_enabled']))
                $this->_is_enabled = $data['is_enabled'];

            if(isset($data['in_backend']))
                $this->_in_backend = $data['in_backend'];
        }

        public function id() :int
        {
			if($this->_id == null)
				$this->_id = (int) 0;

			return $this->_id;
        }

        public function username() :string
        {
			if($this->_user_name == null)
				$this->_user_name = '';

			return $this->_user_name;
        }

        public function name() :string
        {
			if($this->_name == null)
				$this->_name = '';

			return $this->_name;
        }

        public function last_name() :string
        {
			if($this->_last_name == null)
				$this->_last_name = '';

			return $this->_last_name;
        }

		public function password() :string
		{
			return $this->_password;
		}

        public function email() :string
        {
            return $this->_email;
        }

        public function is_enabled() :int
        {
            return $this->_is_enabled;
        }

        public function in_backend() :int
        {
            return $this->_in_backend;
        }
    }