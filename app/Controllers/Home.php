<?php

namespace App\Controllers;

use App\Models\ShopModel;
use App\Models\ChartModel;

class Home extends BaseController
{
    public function index()
    {
        return view('shop/index');
    }
    public function contact()
    {
        return view('shop/contact');
    }
    public function shop()
    {
        $shopModel = new ShopModel();
        $data['products'] = $shopModel->findAll();

        return view('shop/shop', $data);
    }
    public function about()
    {
        $db = db_connect();
        $query = $db->query("SELECT * FROM about"); // Ganti 'content' dengan nama tabel yang sesuai di database Anda
        $data['content'] = $query->getRow();
        return view('shop/about', $data);
    }
    public function detile($id)
    {
        $productModel = new ShopModel();
        // Create an instance of the product model


        // Fetch the product data from the model based on the $id
        $productData = $productModel->find($id);

        // Check if the product data is available
        if ($productData) {
            // Pass the product data to the view
            $data = [
                'images' => $productData['images'],
                'productName' => $productData['name'],
                'productDescription' => $productData['deskripsi'],
                'productPrice' => $productData['price'],
                'page_id' => $id
            ];
            // Load the view and pass the data
            return view('shop/detailes', $data);
        } else {
            // Handle the case when the product data is not found
            // $data = [
            //     'images' => $chartData['images'],
            //     'productName' => $chartData['name_product'],
            //     'quantity' => $chartData['quantity'],
            //     'price' => $chartData['price'],
            //     'price' => $chartData['total']
            // ];
            // Redirect or show an error message
        }
    }

    public function chart()
    {
        $user = array(user_id());
        $chartModel = new ChartModel();
        $chartData = $chartModel->like('user_id', implode(" ", $user));
        $data['products'] = $chartData->findAll();
        $result = $chartModel->where('user_id', $user)->select('sum(total) as total_price')->first();
        $data['total_price'] = $result['total_price'];
        $data['user_id'] = $user;
        return view('shop/chart', $data);
    }

    public function checkout()
    {
        $user = array(user_id());
        $chartModel = new ChartModel();
        $chartData = $chartModel->like('user_id', implode(" ", $user));
        $data['products'] = $chartData->findAll();
        $result = $chartModel->where('user_id', $user)->select('sum(total) as total_price')->first();
        $data['total_price'] = $result['total_price'];
        $data['user_id'] = $user;
        return view('shop/checkout', $data);
    }
    public function thankyou()
    {
        return view('shop/thankyou');
    }

}
