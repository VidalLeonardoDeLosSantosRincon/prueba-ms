<?php namespace App\Controllers;


use App\Models\ProductModel;

class Product extends BaseController{

    public function index(){
        $template = view("elements/content_start")
                    .view("elements/Header")
                    .view("product_view")
                    .view("elements/Footer")
                    .view("elements/content_end");
        return $template;
    }

    //method to show products added
    public function get(){
        $productModel = new ProductModel($db);
        $products = $productModel->findAll();
        $products = Array("products"=>$products);
        echo json_encode($products);
    }

    public function saved(){
        $template = view("elements/content_start")
                    .view("elements/Header")
                    .view("kart_view")
                    .view("elements/Footer")
                    .view("elements/content_end");
        return $template;
    }


    //method to add product
    public function add(){
        $productModel = new ProductModel($db);
        $request = \Config\Services::request();
        
        $code_id = $request->getPostGet('code_id');
        $image = $request->getPostGet('image');
        $name = $request->getPostGet('name');
        $status = $request->getPostGet('status');
        $category = $request->getPostGet('category');
        $condition = $request->getPostGet('condition');
        $color = $request->getPostGet('color');
        $size = $request->getPostGet('size');
        $occasion = $request->getPostGet('occasion');
        $gender = $request->getPostGet('gender');
        $description = $request->getPostGet('description');

        $data = [
            "code_id"=> (int)$code_id,
            "image" => $image,
            "name" => $name,
            "status" => $status,
            "category" => $category,
            "condicion" => $condition,
            "color" => $color,
            "size"=>$size,
            "occasion"=>$occasion,
            "gender"=>$gender,
            "description"=>$description
        ];

        //echo var_dump($data);
        $addedproduct = $productModel->insert($data);
        if($addedproduct){
            echo json_encode(true);
        }else{
            echo json_encode(false);
        }
    }

    //method to delete product
    public function delete(){
        $productModel = new ProductModel($db);
        $request = \Config\Services::request();
        $id = $request->getPostGet("id");

        $addedproduct = $productModel->delete($id);
        if($addedproduct){
            echo json_encode(true);
        }else{
            echo json_encode(false);
        }
    }

}