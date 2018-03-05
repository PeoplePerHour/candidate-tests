<?php

    include_once 'mysqldatabase.class.php';

    /* parse config data */
    $config = parse_ini_file('config.ini');

    /** Initialize database connection */
    $db = new MysqlDatabase($config);

    /* Connect to database */
    $db->openConnection();

    /* Start transaction */
    $db->startTransaction();

    /* Select data from database */
    $rows = $db->selectData('MyGuests', array('order_by'=>'id DESC'));

    /**
     * If you want to check the rest of queries, please remove the comments of code below
     * and comment out the line 44
     */

    /* Insert data */
    // $tblName = "MyGuests";
    // $userData = array(
    //         'firstname' => 'ioannis'
    //     );
    // $insertedData = $db->insertData($tblName,$userData);

    /* Update data */
    // $userData1 = array(
    //             'firstname' => 'yiannis update'
    //         );
    // $condition = array('id' => 3);
    // $updatedData = $db->updateData($tblName,$userData1,$condition);

    // /* Delete data */
    // $condition = array('id' => 3);
    // $deletedData =$db->deleteData($tblName,$condition);

    /* Check if all queries execute correctly , then commit
    *  the changes, else rollback the transaction
    */
    // if (!$insertedData && !$updatedData && !$deletedData) 
    if (!empty($insertedData)) 
    {
        /* commit transaction */
        $db->commitTransaction();
    } else 
    {
        /* rollback the transaction */
        $db->rollbackTransaction();
    }

    /* Kill connection */
    $db->closeConnection();
?>