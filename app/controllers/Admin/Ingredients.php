

<?php

class Ingredients
{
    use Controller;

    public function index()
    {
        $ing = new IngredientModel();
        $ingredients = $ing->getIngredients(1);
        $this->view('ingredients', ['ingredients' => $ingredients]);
    }

}