<?php

if(isset($_POST['email'])) {
    $name = $_POST['name'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $location = $_POST['location'];
    $message = $_POST['message'];

    if ($name && $lastName && $email && $location) {
        $url = 'URL';
        $url_auth = $url . '/xmlrpc/2/common';
        $url_exec = $url . '/xmlrpc/2/object';
        $db = 'DATABASE NAME';
        $username = 'USERNAME';
        $password = 'PASSWORD';

        require_once('includes/ripcord/ripcord.php');

        $common = ripcord::client($url_auth);
        $uid = $common->authenticate($db, $username, $password, array());

        $models = ripcord::client($url_exec);

        $new_lead_id = $models->execute_kw($db, $uid, $password,
            'crm.lead',
            'create',
            array(
                array(
                    'name'=>$name . ' ' . $lastName,
                    'email_from'=>$email,
                    'description'=>$message,
                    'city'=>$location
                )
            )
        );
        $data['status'] = TRUE;
        echo json_encode($data);
    } else {
        $data['status'] = FALSE;
        echo json_encode($data);
    }
}
