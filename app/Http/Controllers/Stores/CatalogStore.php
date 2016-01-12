<?php namespace App\Http\Controllers\Stores;

trait CatalogStore
{
	private function storeCatalog(){
		return response()->json([
			'test' => 'sotres trait!'
		]);
	}
}

?>