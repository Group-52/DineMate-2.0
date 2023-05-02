<?php

namespace components;

use models\Cart;

class MenuCard
{
    protected int $id;
    protected string $name;
    public string|null $description;
    public string|null $image_url;
    protected string|null $old_price;
    protected string $new_price;

    /**
     * @param object $dish
     */
    public function __construct(object $dish)
    {
        $this->id = $dish->dish_id;
        $this->name = $dish->dish_name;
        $this->description = $dish->description ?? null;
        $this->image_url = $dish->image_url ?? null;
        $this->old_price = $dish->old_price ?? null;
        $this->new_price = $dish->selling_price;
    }

    private function inCart(): bool
    {
        if (isLoggedIn()) {
            return (new Cart)->getQty(userId(), $this->id, isGuest());
        } else {
            return false;
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
        $inCart = $this->inCart();
        $html = "<div class='menu-item-card rounded-sm'>";
        $html .= "<a href='" . ROOT . "/dish/id/{$this->id}' class='card-link'>";
        $html .= "<div class='card-img-wrapper'>";
        $html .= "<img src=" . ASSETS . "/images/dishes/{$this->image_url} class='card-img' alt='{$this->name}'>";
        $html .= "</a></div>";
        $html .= "<button class='add-to-cart' data-id='{$this->id}' " . ($inCart ? "disabled" : "") . ">";
        $html .= "<i class='".($inCart ? "fa-solid fa-check" : "fa-sharp fa-solid fa-cart-plus")."'></i>";
        $html .= "</button>";
        $html .= "<a href='" . ROOT . "/dish/id/{$this->id}' class='card-link'>";
        $html .= "<div class='card-body'>";
        $html .= "<h3 class='card-title'>{$this->name}</h2>";
        $html .= "<div class='card-prices'>";
        if ($this->old_price) {
            $html .= "<span class='card-price-old'>LKR {$this->old_price}</span>";
        }
        $html .= "<div class='card-price-new'>LKR {$this->new_price}</div>";
        $html .= "</div></div></a></div>";
        return $html;
    }


}