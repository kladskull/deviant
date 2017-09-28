<?php
/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/5/17
 * Time: 7:05 PM
 */

if (!is_admin()) {
    redirect('/');
    exit(0);
}

// have a post?
if (!isset($_POST['lock']) && !isset($_POST['admin'])) {
    // just showed up...

} else {
    // only proceed if all fields are set
    if (isset($_POST['lock'])) {
        // get data
        $lock_data = explode('-', $_POST['lock']);
        if (count($lock_data) > 1) {
            $action = $lock_data[0];
            $id = (int)$lock_data[1];

            $lock = 1;
            if ($action !== 'lock') {
                $lock = 0;
            }

            $id = $lock_data[1];
            DB::update(TB_USER, [
                'locked' => $lock,
            ], 'id=%i', $id);
        }

        // clean-up
        unset($_POST['lock']);
    } else if (isset($_POST['admin'])) {
        // get data
        $admin_data = explode('-', $_POST['admin']);
        if (count($admin_data) > 1) {
            $action = $admin_data[0];
            $id = (int)$admin_data[1];

            $admin = 0;
            if ($action == 'admin') {
                $admin = 1;
            }

            $id = $admin_data[1];
            DB::update(TB_USER, [
                'admin' => $admin,
            ], 'id=%i', $id);
        }

        // clean-up
        unset($_POST['admin']);
    }
}

// get the user record count
$records = DB::query('SELECT id,email_address,locked,admin FROM ' . TB_USER);
$smarty->assign('currentUser', $_SESSION['user_record']);
$smarty->assign('users', $records);
$smarty->display('users.tpl');
