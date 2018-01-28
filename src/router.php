<?php

    use \App\Middleware\Authorization;


    $app->get('/', '\App\Controllers\Frontend\Home:showFrontpage');

    $app->group('/panel', function() {

        $this->get('', '\App\Controllers\Backend\Panel:showPanel');

        $this->get('/logout', '\App\Controllers\Backend\Panel:logout');

        $this->post('/login', '\App\Controllers\Backend\Panel:login');

        $this->get('/clear-cache', '\App\Controllers\Controller:clearCache')->add(new Authorization());

    })->add($container->get('csrf'));

    $app->group('/panel/users', function() {

        $this->get('', '\App\Controllers\Backend\Users:showUsersList');

        $this->get('/edit-user', '\App\Controllers\Backend\Users:editUser');

        $this->get('/add-user', '\App\Controllers\Backend\Users:addUser');

        $this->post('/insert-user', '\App\Controllers\Backend\Users:insertUser');

        $this->post('/update-user', '\App\Controllers\Backend\Users:updateUser');

        $this->post('/delete-user', '\App\Controllers\Backend\Users:deleteUser');

    })->add($container->get('csrf'))->add(new Authorization());



