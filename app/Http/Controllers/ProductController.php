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

        foreach ($product as $p) {
            $p->price_p = number_format($p->price_p, 0, ',', '.');
        }

        return view('product.index', ['product' => $product]);
    }

    public function show($id_p)
    {
        $product = ProductRepos::getProductById($id_p);
        $category = CategoryRepos::getCategoryByProductId($id_p);

        $product[0]->price_p = number_format($product[0]->price_p, 0, ',', '.');

        return view('product.show', [
            'product' => $product[0],
            'category' => $category[0]
        ]);
    }

    public function create()
    {
        $category = CategoryRepos::getAllCategory();

        return view('product.new', [
            "product" => (object)[
                'id_p' => '',
                'name_p' => '',
                'image_p' => '',
                'price_p' => '',
                'description_p' => '',
                'id_cate' => ''
            ],
            "category" => $category
        ]);
    }

    public function store(Request $request)
    {
        $this->formValidate($request)->validate();

        // Chuyển đổi giá tiền thành số để lưu trữ
        $price = str_replace('.', '', $request->input('price_p'));

        $product = (object)[
            'name_p' => $request->input('name_p'),
            'image_p' => $request->input('image_p'),
            'price_p' => (int)$price,
            'description_p' => $request->input('description_p'),
            'categoryid' => $request->input('category')
        ];

        $newId = ProductRepos::insert($product);

        return redirect()->route('product.index')
            ->with('msg', 'New Product with id: ' . $newId . ' has been inserted');
    }

    public function edit($id_p)
    {
        $product = ProductRepos::getProductById($id_p);
        $category = CategoryRepos::getAllCategory();

        return view('product.update', [
            "product" => $product[0],
            "category" => $category
        ]);
    }

    public function update(Request $request, $id_p)
    {
        if ($id_p != $request->input('id_p')) {
            return redirect()->route('product.index');
        }

        $this->formValidate($request)->validate();

        $price = str_replace('.', '', $request->input('price_p'));

        $product = (object)[
            'id_p' => $request->input('id_p'),
            'name_p' => $request->input('name_p'),
            'image_p' => $request->input('image_p'),
            'price_p' => (int)$price,
            'description_p' => $request->input('description_p'),
            'categoryid' => $request->input('category')
        ];

        ProductRepos::update($product);

        return redirect()->route('product.index')
            ->with('msg', 'Update Successfully');
    }

    public function confirm($id_p)
    {
        $product = ProductRepos::getProductById($id_p);
        $category = CategoryRepos::getCategoryByProductId($id_p);

        // Định dạng giá tiền
        $product[0]->price_p = number_format($product[0]->price_p, 0, ',', '.');

        return view('product.confirm', [
            'product' => $product[0],
            'category' => $category[0],
        ]);
    }

    public function destroy(Request $request, $id_p)
    {
        if ($request->input('id_p') != $id_p) {
            return redirect()->route('product.index');
        }

        ProductRepos::delete($id_p);
        return redirect()->route('product.index')
            ->with('msg', 'Delete Successfully');
    }

    public function curriculumGeneral()
    {
        $product = ProductRepos::getAllProduct(); // Lấy tất cả sản phẩm
        return view('flm.curriculum', compact('product'));
    }

    public function curriculum($productName = null)
    {
        if ($productName) {
            $product = ProductRepos::getProductByName($productName);
        } else {
            $product = null;
        }

        return view('flm.curriculum', compact('product', 'productName'));
    }

    private function formValidate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'image_p' => ['required'],
                'name_p' => ['required'],
                'price_p' => ['required'],
            ],
            [
                'image_p.required' => 'Please enter image',
                'name_p.required' => 'Please enter name!',
                'price_p.required' => 'Please enter price',
            ]
        );
    }
}
