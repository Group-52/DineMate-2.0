<?php

namespace components;

use models\MenuDishes;

class Menu
{
    protected int $id;
    protected string $name;
    protected string|null $description;
    protected string|null $start_time;
    protected string|null $end_time;
    protected bool $all_day;
    protected array $menu_items = [];

    /**
     * @param string $id
     * @param string $name
     * @param string $description
     * @param string $start_time
     * @param string $end_time
     * @param string $all_day
     */
    public function __construct(string $id, string $name, string|null $description, string|null $start_time, string|null $end_time, string $all_day)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->all_day = $all_day;

        $menuDishes = (new MenuDishes())->getMenuDishes($id, 3);
        foreach ($menuDishes as $menuDish) {
            $this->menu_items[] = new MenuItem($menuDish->dish_id, $menuDish->dish_name, $menuDish->description ?? null, $menuDish->image_url ?? null, $menuDish->old_price ?? null, $menuDish->selling_price);
        }
    }

    /**
     * Render HTML
     * @return void
     */
    public function render(): void
    {
        echo $this->html();
    }

    /**
     * Return HTML
     * @return string
     */
    public function html(): string
    {
        $html = "<div class='menu'>";
        $html .= "<div class='row'>";
        $html .= "<div>";
        $html .= "<div class='d-flex flex-column justify-content-space-between mb-2'>";
        $html .= "<h2 class='menu-title'>{$this->name}</h2>";
        $html .= "<h4 class='menu-time secondary'>";
        if ($this->all_day) {
            $html .= "All Day";
        } else {
            $html .= "{$this->start_time} - {$this->end_time}";
        }
        $html .= "</h4></div></div>";
        $html .= "<div class='d-flex align-items-center'>";
        $html .= "<button class='btn btn-primary text-uppercase'>View More</button>";
        $html .= "</div></div>";
        $html .= "<div class='row flex-column flex-lg-row'>";
        foreach ($this->menu_items as $menu_item) {
            $html .= "<div class='col-12 col-lg-4'>";
            $html .= $menu_item->html();
            $html .= "</div>";
        }
        $html .= "</div></div>";

        return $html;
    }
}