<?php namespace App\Http\Controllers\Stores;

use Illuminate\Http\Request;
use App\Link;

trait LinkStore
{
	private function storeLink( Request $request , $serial_id ){
		$link 		= strtolower($request->get('lastlink'));
		$title 		= ( !empty( $request->get('titlelink') ) ) ? strtolower($request->get('titlelink')) : null;
		$season 	= strtolower($request->get('season'));
		$serie 		= strtolower($request-> get('serie'));
		$user_id 	= $request->user()->id;
		if( !empty($link) && !empty($serial_id) ){

			$Link = Link::where([
				'serial_id' => $serial_id ,
				'url'		=> $link
			])->get();

			// Если такой ссылки нет в базе даных
			if( !$Link->count() ){
				$NewLink 			= new Link();
				$NewLink->user_id 	= $user_id;
				$NewLink->serial_id	= $serial_id;
				$NewLink->url 		= $link;
				$NewLink->season 	= $season;
				$NewLink->serie 	= $serie;
				$NewLink->title 	= $title;

				$NewLink->save();
			}
		} else {
			return response( [
				'message' => 'Не обнаружена ссылка и/или ид сериала'
			] , 422)->header( 'Content-Type' , 'application/json' );
		}
	}
}

?>