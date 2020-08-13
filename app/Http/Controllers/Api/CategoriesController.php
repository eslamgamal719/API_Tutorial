<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Traits\GeneralTrait;
use Illuminate\Routing\Controller;

class CategoriesController extends Controller
{

	use GeneralTrait;

    
    public function index() {    //Selection() is A Scope
    	$categories = Category::selection()->get();
    	//return response()->json($categories);

    	return $this->returnData('categories', $categories);
    }



    public function getCategoryById(Request $request) {
    	$category = Category::selection()->find($request->id);
    	if(!$category)
    	  return $this->returnError('500', 'this Category Is Not Found');

    	return $this->returnData('category', $category, "Fetched Data Successfully");
    }




     public function changeStatus(Request $request) {
    	
    	 //validation
     	$category = Category::selection()->find($request->id);
    	if(!$category)
    	  return $this->returnError('500', 'this Category Is Not Found');

    	$category->update([
    		"active" => $request->active
    	]);

    	return $this->returnSuccessMessage('Updated Successfully');
    }

}
