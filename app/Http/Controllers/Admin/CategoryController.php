<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use App\Model\Category;

class CategoryController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate($this->itemsPerPage);
        $orderedCategories = Category::getTopCategories();
        return view('admin.category.list')->with(['categories' => $categories,'orderedCategories' => $orderedCategories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $name = $request->get('name');
        $foreColor = $request->get('foreColor');
        $backColor = $request->get('backColor');
        Category::create(['name' => $name, 'foreColor' => $foreColor, 'backColor' => $backColor]);
        return response()->redirectToRoute('category.index');
    }

    public function update(UpdateCategoryRequest $request, Category $category){
        $name = $request->get('name');
        $foreColor = $request->get('foreColor');
        $backColor = $request->get('backColor');
        $category->update(['name' => $name, 'foreColor' => $foreColor, 'backColor' => $backColor]);
        return response()->redirectToRoute('category.index');
    }

}
