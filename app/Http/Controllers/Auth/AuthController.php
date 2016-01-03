<?php namespace App\Http\Controllers\Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Auth;
use App\User;

class AuthController extends Controller {

	public function getLogout( Request $request ){
		Auth::logout();
		return $this->getCheck();
	}

	public function postLogin( Request $request )
	{
		$this->validate( $request , [
			'email'		=> 'required|email|exists:users' ,
			'password'	=> 'required|min:5'
		]);

		$email 		= $request->get('email');
		$password 	= $request->get('password');

		if( Auth::attempt([ 'email' => $email , 'password' => $password ]) )
		{
			return response()->json([]);
		} else {
			return response( [
				'message' => 'Неправильно введены логин и/или пароль. Пожалуйста, попробуйте еще раз'
			] , 422)->header( 'Content-Type' , 'application/json' );
		}
	}

	public function postRegister( Request $request )
	{
		$this->validate( $request , [
			'name'		=> 'required' ,
			'email'		=> 'required|email|unique:users' ,
			'password'	=> 'required|min:5'
		]);

		$user = new User();
		$user->name 	= $request->get( 'name' );
		$user->email 	= $request->get( 'email');
		$user->password = bcrypt( $request->get( 'password' ) );

		$user->save();

		if( $user )
		{
			return response()->json( [ 'result'	=> 'success' ] );
		} else {
			return response()->json( [ 'result' => 'failed' , 'message' => 'Ошибка при создании записи' ] );
		}
	}

	/**
	 * Проверяет авторизован ли пользователь 
	 *
	 * @return json с булевым параметром auth
	 */
	public function getCheck()
	{
		return response()->json( [ 'auth' => Auth::check() , 'token' => csrf_token() ]);
	}

}
