<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Link;

class LinksController extends Controller {

	public function index( Request $request ){
		$all = Link::all();

		return response()->json( $all );
	}

}
