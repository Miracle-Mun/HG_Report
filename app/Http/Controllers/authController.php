<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\logins;
use App\model\users;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Session;
use Auth;
use DB;

class authController extends Controller
{
    public function index()
    {
        //
    }

    public function signin() {
        $LoginTable = new logins;
        $login = json_decode($LoginTable->where(['username' => $_POST['username']])->get());

        if(count($login) > 0) {

            $password = $this->encryptPassword($_POST['password'], $login[0]->salt);

            if($login[0]->encrypted == $password) {
                if($login[0]->inactive == '0') {
                    Session::flash('error', "You aren't allowed yet.");
                    return redirect()->back();
                }
                $num = json_decode(DB::table('logins')->where(['username' => $_POST['username'], 'encrypted' => $password])->get('login_num'));
                DB::table('logins')->where(['username' => $_POST['username'], 'encrypted' => $password])->update(['last_login' => date('Y-m-d'), 'login_num' => ((int)$num[0]->login_num + 1)]);
                Session::put('whole', $login[0]);
                Session::put('session', $_POST['username']. ','. $password);
                return redirect('/main');
            }
            else {
                Session::flash('error', "Password doesn't match.");
                return redirect()->back();
            }
        }
        else {
            Session::flash('error', "User Name doesn't exist.");
            return redirect()->back();
        }
    }

    public function signup() {

        $usersTable = new users;
        $getrow  = $usersTable->where(['name' => $_POST['username'], 'email' => $_POST['email']])->get();

        if(count(json_decode($getrow)) > 0) {
            Session::flash('error', "This user has already exist.");
            return redirect()->back();
        }

        $_POST['community_id'] = (int)$_POST['community_id'] + 1;

        $user = array(
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'position' => $_POST['position'],
            'community_id' => $_POST['community_id'],
            'leveledit' => $_POST['leveledit'],
            'levelreport' => $_POST['levelreport'],
            'levelcompany' => $_POST['levelcompany'],
            'leveluser' => $_POST['leveluser'],
            'leveladd' => $_POST['leveladd']
        );

        $usersTable->insert($user);

        $id = json_decode($usersTable->where(['email' => $_POST['email'], 'name' => $_POST['name']])->get())[0]->id;

        $loginTable = new logins;

        $salt = $this->get_new_salt();
        $password = $this->encryptPassword($_POST['password'], $salt);
        $login = array(
            'user_id' => $id,
            'username' => $_POST['username'],
            'encrypted' => $password,
            'salt' => $salt,
            'inactive' => '0',
            'created_date' => date("Y-m-d")
        );

        $loginTable->insert($login);

        Session::flash('result', 'Login Success!');
        if($_POST['checkthisonlyadd']) {
            return redirect('/usermanage');
        }
        return redirect('/');
    }

    public function signout() {
        Session::forget('session');
        return redirect('/');
    }

    public function updatePass() {
        $login = new logins;
        $salt = $this->get_new_salt();
        $password = $this->encryptPassword($_POST['changePass'], $salt);
        DB::table('logins')->where('user_id', $_POST['mainId'])->update(['encrypted' => $password, 'salt' => $salt]);
        return redirect('/usermanage');
    }
    public function changepass() {
        $login = new logins;
        $salt = $this->get_new_salt();
        $password = $this->encryptPassword($_POST['changePass'], $salt);
        Session::put('session', $_POST['username']. ','. $password);
        DB::table('logins')->where('user_id', $_POST['mainId'])->update(['encrypted' => $password, 'salt' => $salt]);
        return redirect('/profile');
    }

    public function changeStatus() {
        $login = new logins;
        DB::table('logins')->where('user_id', $_POST['id'])->update(['inactive' => $_POST['statu']]);
        return redirect('/usermanage');
    }

    public function update() {

        $user = array(
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'position' => $_POST['position'],
            'community_id' => $_POST['community_id'],
            'leveledit' => $_POST['leveledit'],
            'levelreport' => $_POST['levelreport'],
            'levelcompany' => $_POST['levelcompany'],
            'leveladd' => $_POST['leveladd'],
            'leveluser' => $_POST['leveluser']
        );
        
        DB::table('users')->where('id', $_POST['mainId'])->update($user);

        return redirect('/usermanage');
    }

    public function encryptPassword($password, $hashsalt) {
        $HASH_SALT_LENGTH = 10;
        $HASH_KEY = "9169779b65ca061622d77f6a12c49a36eb3c3110efa8fd508d1c0c3b42e7f694";
        $HASH_ITERATION = 160;
        $HASH_ALGO = "sha256";

        for($i=0;$i<$HASH_ITERATION;$i++){
            $password = hash_hmac($HASH_ALGO, $password . $hashsalt, $HASH_KEY);
        }
        return $password;
    }

    private function get_new_salt(){
		$HASH_SALT_LENGTH = 10;
		return substr(sha1(rand()), 0, $HASH_SALT_LENGTH);
	}
}
