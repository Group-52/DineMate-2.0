

<?php

class Inventory
{
    use Controller;

    public function index()
    {
        $inv = new InventoryModel();
        $inventory = $inv->getInventory();
        $this->view('inventory', ['inventory' => $inventory]);
    }
    public function info()
    {
        $inv2 = new Inventory2Model();
        $inventory2 = $inv2->getInventory();
        $this->view('inventory2', ['inventory2' => $inventory2]);
    }

    public function updateInventory()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $m = new Inventory2Model();

            $data = json_decode(file_get_contents("php://input"), true);
            for ($i = 0; $i < count($data); $i++) {
                $pid = $data[$i]['pid'];
                $fieldName = $data[$i]['fieldName'];
                $newValue = $data[$i]['newValue'];

                if ($fieldName === 'amount_remaining') {
                    $m->updateInventory($pid, $newValue);
                } else if ($fieldName === 'special_notes') {
                    $m->updateInventory($pid, null, $newValue);
                } else if ($fieldName === 'expiryrisk') {
                    $m->updateInventory($pid, null, null, $newValue);
                }
            }
            echo json_encode(array("status" => "success", "message" => "Data received successfully"));
        } else
            echo json_encode(array("status" => "error", "message" => "Invalid request"));
    }

    public function deleteInventory()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = json_decode(file_get_contents("php://input"), true);
            $id = $id['purchaseId'];
            
            $m = new Inventory2Model();
            $m->deleteInventory($id);

            echo json_encode(array("status" => "success", "message" => "Data received successfully", "id" => $id));
        } else
            echo json_encode(array("status" => "error", "message" => "Invalid request"));
    }
}
