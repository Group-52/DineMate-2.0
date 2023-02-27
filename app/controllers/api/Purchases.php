<?php
namespace controllers\api;
use core\controller;
use models\Purchase;

class Purchases {
    use Controller;

    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $purchaseModel = new Purchase();
            $data = json_decode(file_get_contents("php://input"), true);
            $id = $data['purchase_id'];
            unset($data['purchase_id']);
            $purchaseModel->updatePurchase($id, $data);
            echo json_encode(array("status" => "success", "message" => "Data updated successfully"));
        } else
            echo json_encode(array("status" => "error", "message" => "Invalid request"));
    }
    public function delete():void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $purchaseModel = new Purchase();
            $data = json_decode(file_get_contents("php://input"), true);
            $id = $data['purchase_id'];
            $purchaseModel->deletePurchase($id);
            echo json_encode(array("status" => "success", "message" => "Data deleted successfully"));
        } else
            echo json_encode(array("status" => "error", "message" => "Invalid request"));
    }

}