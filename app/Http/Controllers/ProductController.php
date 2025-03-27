<?php

namespace App\Http\Controllers;

use App\Repository\CategoryRepos;
use App\Repository\ProductRepos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {

        $product = ProductRepos::getAllProductWithCategory();

        return view('product.index',
            [
                'product' => $product,

            ]);
    }

    public function show($id_p)
    {

        $product = ProductRepos::getProductById($id_p); //xuống lại Database lấy sản phẩm có ID này

        $category = CategoryRepos::getCategoryByProductId($id_p);

        return view('product.show',
            [
                'product' => $product[0],//get the first element

                'category' => $category[0],

            ]
        );
    }

    public function create()
    {
        $category = CategoryRepos::getAllCategory();

        return view(
            'product.new',


            ["product" => (object)[
                'id_p' => '',
                'name_p' => '',
                'image_p' => '',
                'price_p' => '',
                'size_p' => '',
                'description_p' => '',
                'id_cate' => ''
            ],
                "category" => $category
            ]);

    }

    public function store(Request $request)

    {
        $this->formValidate($request)->validate(); //shortcut

        $product = (object)[
            'name_p' => $request->input('name_p'),
            'image_p' => $request->input('image_p'),
            'price_p' => $request->input('price_p'),
            'size_p' => $request->input('size_p'),
            'description_p' => $request->input('description_p'),
            'categoryid' => $request->input('category')
        ];

        $newId = ProductRepos::insert($product);


        return redirect()// chuyển hướng
        ->action('ProductController@index')
            ->with('msg', 'New Product with id: '.$newId.' has been inserted');

    }

    public function edit($id_p)
    {
        $product = ProductRepos::getProductById($id_p); //this is always an array

        $category = CategoryRepos::getAllCategory();

        return view(
            'product.update',
            [
                "product" => $product[0],

                "category" => $category
            ]);

    }

    public function update(Request $request, $id_p)
    {
        if ($id_p != $request->input('id_p')) {

            return redirect()->action('ProductController@index');
        }

        $this->formValidate($request)->validate(); //shortcut

        $product = (object)[
            'id_p' => $request->input('id_p'),
            'name_p' => $request->input('name_p'),
            'image_p' => $request->input('image_p'),
            'price_p' => $request->input('price_p'),
            'size_p' => $request->input('size_p'),
            'description_p' => $request->input('description_p'),
            'categoryid' => $request->input('category')

        ];
        ProductRepos::update($product);

        return redirect()->action('ProductController@index')
            ->with('msg', 'Update Successfully');;
    }

    public function confirm($id_p){
        $product = ProductRepos::getProductById($id_p); //this is always an array





        $category = CategoryRepos::getCategoryByProductId($id_p);
        return view('product.confirm',
            [
                'product' => $product[0],
                'category' => $category[0],
            ]
        );
    }

    public function destroy(Request $request, $id_p)
    {
        if ($request->input('id_p') != $id_p) {
            //id in query string must match id in hidden input
            return redirect()->action('ProductController@index');
        }

        ProductRepos::delete($id_p);
        return redirect()->action('ProductController@index')
            ->with('msg', 'Delete Successfully');
    }

    private function formValidate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'image_p' =>['required'],
                'name_p'=>['required'],
                'price_p'=>['required'],
                'size_p' =>['required'],
            ],
            [
                'image_p.required' => 'please enter image',
                'name_p.required' => 'please enter name!',

                'price.required'=>'please enter price',
                'size_p.required' => 'please enter size',

            ]
        );
    }
}
