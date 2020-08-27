<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\logins;

class projectMainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('panda');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $login = new logins;
        $salt = $this->get_new_salt();
        $password = $this->encryptPassword($request->pass, $salt);
        $login->where('id', $request->id)->update(array('password' => $password, 'salt' => $salt));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        print_r($id);
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
