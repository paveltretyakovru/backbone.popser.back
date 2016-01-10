<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Link;

class LinksController extends Controller {

	private function arrayPrint( $array ){
		echo "<pre>";
			print_r( $array );
		echo "</pre>";
	}
 
	public function index( Request $request ){
		$serial = $request->get('serial');
		
		$all = Link::where([ 'serial_id' => $serial['serial_id'] ]);
		$just = $all->where([
			'serial_id'	=> $serial['serial_id']
		])->get();

		return response()->json( $just );
	}

}
