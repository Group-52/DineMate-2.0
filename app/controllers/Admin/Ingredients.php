

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

}