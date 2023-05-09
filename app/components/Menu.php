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
     * @param object $menu
     * @param int $n
     */
    public function __construct(object $menu, int $n = 100)
    {
        $this->id = $menu->menu_id;
        $this->name = $menu->menu_name;
        $this->description = $menu->description ?? null;
        $this->start_time = $menu->start_time ?? null;
        $this->end_time = $menu->end_time ?? null;
        $this->all_day = $menu->all_day;

        $menuDishes = array_slice((new MenuDishes())->getMenuDishes($this->id, $n, 0, true), 0, 4);
        foreach ($menuDishes as $menuDish) {
            $this->menu_items[] = new MenuCard($menuDish);
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
        $html = "<div class='menu mb-4'>";
        $html .= "<div class='row justify-content-md-space-between justify-content-center'>";
        $html .= "<div>";

        // Menu name and time column
        $html .= "<div class='d-flex flex-column justify-content-space-between align-items-md-start align-items-center mb-3'>";
        $html .= "<h2 class='menu-title not-mobile'>{$this->name}</h2>";
        $html .= "<h1 class='menu-title only-mobile'>{$this->name}</h1>";
        $html .= "<h4 class='secondary lead fs-6'>";
        if ($this->description) {
            $html .= "{$this->description}";
        }
        $html .= "</h4>";
        $html .= "</div></div>";
        //        $html .= "<h4 class='menu-time secondary'>";
        //        if ($this->all_day) {
        //            $html .= "All Day";
        //        } else {
        //            $html .= "{$this->start_time} - {$this->end_time}";
        //        }
        //        $html .= "</h4></div></div>";

        // View more button column (desktop)
        $html .= "<div class='d-flex align-items-center'>";
        $html .= "<a href='menu/id/{$this->id}' class='btn btn-primary text-uppercase not-mobile'>View More</a>";
        $html .= "</div></div>";

        // Menu dishes
        $html .= "<div class='grid-lg-4 grid-md-2 grid-1 grid-gap-2'>";
        foreach ($this->menu_items as $menu_item) {
            $html .= "<div>";
            $html .= $menu_item->html();
            $html .= "</div>";
        }
        $html .= "</div>";

        // View more button (mobile)
        $html .= "<div class='text-center my-4'><a href='menu/id/{$this->id}' class='btn btn-primary text-uppercase only-mobile'>View More</a></div>";
        $html .= "</div>";

        return $html;
    }

    public function count(): int
    {
        return count($this->menu_items);
    }
}