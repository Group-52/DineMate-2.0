

<?php

class Ingredients
{
    use Controller;

    public function index()
    {
        $d = new Dish();
        $dishes = $d->getDishes();

        $items = new Item();
        $ingredients = $items->getItems();

        $u = new Unit();
        $units = $u->getUnits();

        $ing = new IngredientModel();
        $ingredientlist = $ing->getAllIngredients();

        $this->view('ingredients', ['ingredients' => $ingredients, 'dishes' => $dishes, 'units'=>$units,'ingredientlist'=>$ingredientlist]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $m = new IngredientModel();

            $data = json_decode(file_get_contents("php://input"), true);
            $dishId = $data['dish'];
            $itemId = $data['ingredient'];
            $unitId = $data['unit'];
            $amount = $data['quantity'];

            $m->addIngredient($dishId, $itemId, $amount, $unitId);
            echo json_encode(array("status" => "success", "message" => "Data received successfully"));
        } else
            echo json_encode(array("status" => "error", "message" => "Invalid request"));

    }

}