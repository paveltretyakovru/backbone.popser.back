<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Serial;
use App\Catalog;

class SerialsController extends Controller {

	use Stores\CatalogStore;
	use Stores\LinkStore;

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$title 		= strtolower($request->get('title'));
		$user_id 	= $request->user()->id;

		if( !empty( $title ) )
		{
			
			$serial = Serial::where( 'title' , $title )->get();

			// Сериал с таким названием уже был создан ранее
			if( $serial->count() )
			{
				
				$catalog = Catalog::where([
					'user_id'	=> $user_id ,
					'serial_id'	=> $serial->first()->id
				])->get();

				// У пользователя уже есть в списке этот сериал
				if( $catalog->count() ) {
					return response( [
						'message' => 'У Вас уже есть сериал с таким названием'
					] , 422)->header( 'Content-Type' , 'application/json' );
				} else {

					// Иначе добавляем пользователю в каталог сериал
					$catalog 			= new Catalog();
					$catalog->user_id 	= $user_id;
					$catalog->serial_id = $serial->first()->id;
					$catalog->title 	= $title;
					$catalog->season 	= 0;
					$catalog->serie 	= 0;

					$catalog->save();

					return response()->json( $catalog->toArray() );
				}

			// Такого сериала еще не создано, поэтому создаем запись,
			// и добавляем в каталог пользователя
			} else {
				$new_serial 		= new Serial();
				$new_serial->title 	= $title;
				$new_serial->user_id= $user_id;

				$new_serial->save();

				$catalog = new Catalog();
				$catalog->user_id 	= $user_id;
				$catalog->serial_id = $new_serial->id;
				$catalog->title 	= $title;
				$catalog->season 	= 0;
				$catalog->serie 	= 0;

				$catalog->save();

				return response()->json( $catalog->toArray() );
			}

			return $serial;
			
		} else {
			return response( [
				'message' => 'Поле не может быть пустым'
			] , 422)->header( 'Content-Type' , 'application/json' );
		}
	}

	/**check isset in data table
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request , $id)
	{
		$user_id = $request->user()->id;
		$catalog = Catalog::find( $id );
		if( $catalog && $catalog->user_id == $user_id ){
			$this->validate( $request , [
				'season' 	=> 'required' ,
				'serie' 	=> 'required'
			]);
			// Сохраняем  изменения пользователя
			$catalog->season 	= $request->get('season');
			$catalog->serie  	= $request->get('serie');
			$catalog->link 	 	= $request->get('link');
			$catalog->lastlink	= $request->get('lastlink');
			$catalog->save();
			// Заносим ссылку в базу данных
			$this->storeLink( $request , $catalog->serial_id );
			// Возвращаем обновленную модель пользователю
			return response()->json( $catalog->toArray() );
		} else {
			return response( [
				'message' => 'Не найдено записи'
			] , 422)->header( 'Content-Type' , 'application/json' );
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy( Request $request , $id )
	{
		$catalog = Catalog::find( $id );

		if( $catalog && $catalog->user_id == $request->user()->id ){
			$catalog->delete();

			return response()->json([ 'result'	=> 'success' , 'message' => 'Запись успешно удалена' ]);
		} else {
			return response( [
				'message' => 'Не найдено записи'
			] , 422)->header( 'Content-Type' , 'application/json' );
		}
	}

}
