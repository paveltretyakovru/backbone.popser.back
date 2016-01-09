<?php namespace App\Http\Controllers\Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Catalog;
use DB;

class AuthController extends Controller {

	public function getLogout( Request $request ){
		Auth::logout();
		return $this->getCheck( $request );
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
			return response()->json( [ 'user' => $this->getUserInfo( $request ) ] );
		} else {
			return response( [
				'message' => 'Неправильно введены логин и/или пароль. Пожалуйста, попробуйте еще раз'
			] , 422)->header( 'Content-Type' , 'application/json' );
		}
	}

	public function getUserInfo( Request $request )
	{
		return [
			'id'		=> $request->user()->id 	,
			'name'		=> $request->user()->name 	,
			'email'		=> $request->user()->email 	,
			'catalogs'	=> $request->user()->catalogs
		];
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
			return response()->json([
				'result' => 'success' ,
				'user'	 => [ 'name' => $user->name , 'email' => $user->email , 'serials' => [] ] ,
				'serials'=> $this->getSerials()
			]);
		} else {
			return response()->json( [ 'result' => 'failed' , 'message' => 'Ошибка при создании записи' ] );
		}
	}

	/**
	 * Проверяет авторизован ли пользователь 
	 *
	 * @return json с булевым параметром auth
	 */
	public function getCheck( Request $request )
	{
		if( Auth::check() )
		{
			return response()->json(
				[ 'auth' => true  , 'token' => csrf_token() , 'user' => $this->getUserInfo( $request ) , 'serials' => $this->getSerials() ]
			);	
		} else {
			return response()->json( [ 'auth' => false , 'token' => csrf_token() , 'serials' => $this->getSerials() ]);
		}
		
	}

	private function getSerials(){
		return DB::table('serials')->select( 'id' , 'title' )->get();
	}

}
