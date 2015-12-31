<?php namespace App\Http\Controllers\Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Auth;
use App\User;

class AuthController extends Controller {

	public function postLogin( Request $request )
	{
		$this->validate( $request , [
			'email'		=> 'required|email' ,
			'password'	=> 'required|min:5'
		]);
	}

	public function postRegistrate( Request $request )
	{
		$this->validate( $request , [
			'name'		=> 'required' ,
			'email'		=> 'required|email|unique' ,
			'password'	=> 'required|min:5'
		]);

		$user = User::create( $request->all() );
		
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
