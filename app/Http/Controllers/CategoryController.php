<?php

namespace App\Http\Controllers;

use App\Repository\CategoryShowRepos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $category = CategoryShowRepos::getAllCategory();
        return view('category.index',
            [
                'category' => $category,
            ]);
    }

    public function show($id_cate)
    {

        $category = CategoryShowRepos::getCategoryById($id_cate);
        return view('category.show',
            [
                'category' => $category[0]
            ]
        );
    }

    public function create()
    {

        return view(
            'category.new',
            ["category" => (object)[
                'id_cate' => '',
                'name_cate' => '',
                'image_cate' => ''

            ]]);

    }

    public function store(Request $request)
    {
        $this->formValidate($request)->validate(); //shortcut

        $category = (object)[
            'name_cate' => $request->input('name_cate'),
            'image_cate' => $request->input('image_cate'),

        ];

        $newId = CategoryShowRepos::insert($category);

        return redirect()
            ->action('CategoryController@index')
            ->with('msg', 'New Category with id: '.$newId.' has been inserted');
    }

    public function edit($id_cate)
    {
        $category = CategoryShowRepos::getCategoryById($id_cate); //this is always an array


        return view(
            'category.update',
            ["category" => $category[0]]);
    }

    public function update(Request $request, $id_cate)
    {
        if ($id_cate != $request->input('id_cate')) {
            //id in query string must match id in hidden input
            return redirect()->action('CategoryController@index');
        }

        $this->formValidate($request)->validate(); //shortcut

        $category = (object)[
            'id_cate' => $request->input('id_cate'),
            'name_cate' => $request->input('name_cate'),
            'image_cate' => $request->input('image_cate'),

        ];
        CategoryShowRepos::update($category);

        return redirect()->action('CategoryController@index')
            ->with('msg', 'Update Successfully');;
    }

    public function confirm($id_cate){
        $category = CategoryShowRepos::getCategoryById($id_cate); //this is always an array

        return view('category.confirm',
            [
                'category' => $category[0]
            ]
        );
    }

    public function destroy(Request $request, $id_cate)
    {
        if ($request->input('id_cate') != $id_cate) {

            return redirect()->action('CategoryController@index');
        }
        $product = CategoryShowRepos::getCategoryWithProductsById($id_cate);
        if (count($product) > 0) {
            return redirect()->action('CategoryController@index')
                ->withErrors('msg', 'Can not delete!!! Please check products before delete category!!!');
        } else {
            CategoryShowRepos::delete($id_cate);
            return redirect()->action('CategoryController@index')
                ->with('msg', 'Delete Successfully');
        }
    }

    private function formValidate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'name_cate'=>['required'],
                'image_cate' =>['required'],
            ],
            [
                'name_cate.required'=>'please Enter name',
                'image_cate.required' => 'please enter image',

            ]
        );
    }

}
