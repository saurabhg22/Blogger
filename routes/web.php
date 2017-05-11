<?php
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/api/reg', function (Request $req) {
	header('Content-Type: application/json');
	$username = $req->input('username');
	$name = $req->input('name');
	$email = $req->input('email');
	$password = $req->input('password');
	$permission = $req->input('permission');
	//echo $permission;
	$passhash = md5($password);
	if ($username == null){
		$data = [ 'success' => false, 'msg' => 'Username is required'];
    	echo json_encode( $data );
		die();
	}
	if ($name == null){
		$data = [ 'success' => false, 'msg' => 'Name is required'];
    	echo json_encode( $data );
		die();
	}
	if ($email == null){
		$data = [ 'success' => false, 'msg' => 'Email is required'];
    	echo json_encode( $data );
		die();
	}
	if ($password == null){
		$data = [ 'success' => false, 'msg' => 'Password is required'];
    	echo json_encode( $data );
		die();
	}
	if ($permission == null){
		$data = [ 'success' => false, 'msg' => 'Select any one type of permission.'];
    	echo json_encode( $data );
		die();
	}
	$user = DB::table('users')->where('username', $username)->first();
	if ($user != null){
		$data = [ 'success' => false, 'msg' => 'Username already taken.'];
    	echo json_encode( $data );
		die();
	}
	$user = DB::table('users')->where('email', $email)->first();
	if ($user != null){
		$data = [ 'success' => false, 'msg' => 'Email already taken.'];
    	echo json_encode( $data );
		die();
	}

	DB::table('users')->insert([
		'name' => $name, 
		'username' => $username, 
		'email' => $email, 
		'password' => $passhash, 
		'token' => 'sample token',
		'permission' => $permission
	]);
	$data = [ 'success' => true, 'msg' => 'Registration successful.'];
    echo json_encode( $data );
});


Route::post('/api/login', function (Request $req) {
	header('Content-Type: application/json');

	$username = $req->input('username');
	$password = $req->input('password');
	$passhash = md5($password);
	if ($username == null){
		$data = [ 'success' => false, 'msg' => 'Username is required'];
    	echo json_encode( $data );
		die();
	}
	if ($password == null){
		$data = [ 'success' => false, 'msg' => 'Password is required'];
    	echo json_encode( $data );
		die();
	}

	$user = DB::table('users')->where([
								    ['username', '=', $username],
								    ['password', '=', $passhash],
								])->first();
	if ($user == null){
		$data = [ 'success' => false, 'msg' => 'Username or Password is incorrect'];
    	echo json_encode( $data );
		die();
	}
	else{

	  	$tokenId    = base64_encode(mcrypt_create_iv(32));
	    $issuedAt   = time();
	    $notBefore  = $issuedAt + 10;             //Adding 10 seconds
	    $expire     = $notBefore + 24*60*60;      // Adding 24 hrs in seconds
	    $serverName = $req->server('SERVER_NAME'); // Retrieve the server name from config file
	    
	    /*
	     * Create the token as an array
	     */
	    $tokendata = [
	        'iat'  => $issuedAt,         // Issued at: time when the token was generated
	        'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
	        'iss'  => $serverName,       // Issuer
	        'nbf'  => $notBefore,        // Not before
	        'exp'  => $expire,      
	        'secret'  => 'awsome key',           // Expire
	        'data' => [                  // Data related to the signer user
	            'username' => $user->username, 
	            'email' => $user->email, 
	            'name' => $user->name, 
	            'permission' => $user->permission, 
	        ]
	    ];
		$jwt = base64_encode(json_encode($tokendata));
	        
		$data = [ 'success' => true, 'msg' => 'Login successful.', 'token' => $jwt];
	    echo json_encode( $data );
	}
});












Route::post('/api/me', ['middleware' => 'tokendecoder', function(Request $req){
	header('Content-Type: application/json');
	$user = App\User::where('username', '=', $req->decodedtoken->data->username)->first();
	$req->decodedtoken->blogs = $user->blogs;
	echo json_encode($req->decodedtoken);
}]);




Route::post('/api/blogs', function () {
	header('Content-Type: application/json');
    echo  json_encode(DB::table('blogs')->get());
});



Route::post('/api/singleblog', function (Request $req) {
	header('Content-Type: application/json');
	if($req->input('id') == null){
		$data = [ 'success' => false, 'msg' => 'Id not provided.'];
	    echo json_encode( $data );
	}
	else{
		$blog = App\Blog::where('id', '=', $req->input('id'))->first();
		if($blog != null){
			$user = $blog->user;
			$data = [ 'success' => true, 'blog' => $blog];
		    echo  json_encode($data);
		}
		else{
			$data = [ 'success' => false, 'msg' => 'That blog does no exist.'];
		    echo json_encode( $data );
		}
	}
});


Route::post('/api/editable', ['middleware' => 'tokendecoder', function (Request $req) {
	header('Content-Type: application/json');
	if($req->input('id') == null){
		echo json_encode( [ 'success' => false] );
	}
	else{
		$blog = App\Blog::where('id', '=', $req->input('id'))->first();
		$user = $blog->user;
		if($req->decodedtoken->data->permission == 2){
	    	echo json_encode( [ 'success' => true] );
		}
		else if($req->decodedtoken->data->username == $user->username && $user->permission == 1){
			echo json_encode( [ 'success' => true] );
		}
		else{
			echo json_encode( [ 'success' => false] );
		}
	}
}]);

Route::post('/api/editblog', ['middleware' => 'tokendecoder', function (Request $req) {
	header('Content-Type: application/json');
	if($req->input('id') == null){
		echo json_encode( [ 'success' => false, 'msg' => 'Blog id is required.'] );
	}
	else{
		$blog = App\Blog::where('id', '=', $req->input('id'))->first();
		$user = $blog->user;
		if($blog != null && $req->input('heading') != null && $req->input('data') != null){
			if($req->decodedtoken->data->permission == 2){
				DB::table('blogs')
		            ->where('id', $req->input('id'))
		            ->update([
		            	'heading' =>  $req->input('heading'),
		            	'data' => $req->input('data'),
						'updated_at' => date('Y-m-d H:i:s')
		            	]);

		    	echo json_encode( [ 'success' => true] );
			}
			else if($req->decodedtoken->data->username == $user->username && $user->permission == 1){
				DB::table('blogs')
		            ->where('id', $req->input('id'))
		            ->update([
		            	'heading' => $req->input('heading'), 
		            	'data' => $req->input('data'),
						'updated_at' => date('Y-m-d H:i:s')
		            	]);

		    	echo json_encode( [ 'success' => true] );
			}
			else{
				echo json_encode( [ 'success' => false, 'msg' => 'You do not have right permissions to do this task'] );
			}
		}
		else{
			echo json_encode( [ 'success' => false, 'msg' => 'Heading and data of blog both are required.'] );
		}

	}
}]);


Route::post('/api/deleteblog', ['middleware' => 'tokendecoder', function (Request $req) {
	header('Content-Type: application/json');
	if($req->input('id') == null){
		echo json_encode( [ 'success' => false, 'msg' => 'Blog id is required.'] );
	}
	else{
		$blog = App\Blog::where('id', '=', $req->input('id'))->first();
		$user = $blog->user;
		if($blog != null){
			if($req->decodedtoken->data->permission == 2){
		        DB::table('blogs')->where('id', '=', $req->input('id'))->delete();

		    	echo json_encode( [ 'success' => true] );
			}
			if($req->decodedtoken->data->username == $user->username && $user->permission == 1){
		        DB::table('blogs')->where('id', '=', $req->input('id'))->delete();

		    	echo json_encode( [ 'success' => true] );
			}
			else{
				echo json_encode( [ 'success' => false, 'msg' => 'You do not have right permissions to do this task'] );
			}
		}
		else{
			echo json_encode( [ 'success' => false, 'msg' => 'That blog does not exists is database.'] );
		}

	}
}]);



Route::post('/api/newblog', ['middleware' => 'tokendecoder', function (Request $req) {
	header('Content-Type: application/json');
	//echo json_encode($req->heading);
	if($req->decodedtoken->data->permission > 0){
		if($req->input('heading') != null && $req->input('data') != null){
			$user = DB::table('users')->where([
								    ['username', '=', $req->decodedtoken->data->username],
								])->first();
			$id = DB::table('blogs')->insertGetId([
				'heading' => $req->input('heading'), 
				'data' => $req->input('data'), 
				'user_id' => $user->id,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			]);

    		echo json_encode( [ 'success' => true, 'id' => $id] );
    	}
    	else{
    		echo json_encode( [ 'success' => false, 'msg' => 'Heading and text data of blog both are required.'] );
    	}
	}
	else{
		echo json_encode( [ 'success' => false, 'msg' => 'You do not have right permissions to do this task'] );
	}
}]);


Route::get('/', function () {
    return view('index');
});

Route::get('/{any}', function ($any) {
    return view('index');
})->where('any', '.*');


