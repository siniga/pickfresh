<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::get();
        return $categories;
    }

    public function getBusinessCategories($id){
        $categories = Category::join("businesses","businesses.id","categories.business_id")
            ->select("categories.id", "categories.name","categories.url")
            ->where("businesses.id", $id)
            ->orderBy('categories.id', 'desc')
            ->get()->toArray();
            
        array_unshift($categories, ["id"=>0,"name"=>"All Categories","url"=>"none"]);
            
        return response(["categories"=> $categories], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->url = "none";
        $category->business_id = $request->business_id;

        if($category->save()){
            return  response($category, 200);
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
