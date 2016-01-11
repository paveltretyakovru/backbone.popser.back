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
		$serial 	= $request->get('serial');
		$serial_id 	= strtolower( $serial['serial_id'] );
		$count_rand = 2;
		$rand 		= [];
		$result 	= [];
		
		$all = Link::where([ 'serial_id' => $serial_id ]);
		$just = $all->where([
			'serial_id'	=> $serial_id
		])->get()->toArray();
		
		if(count($just)){
			$count_rand = ( $count_rand <= count( $just ) ) ? $count_rand : count( $just );
			$rand 		= array_rand( $just , $count_rand );
			
			foreach ($rand as $key => $value) {
				$result[] = $just[$value];
			}
		}

		return response()->json( $result );
	}

}
