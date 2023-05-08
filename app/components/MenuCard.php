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
    protected bool $isPromo;

    /**
     * @param object $dish
     */
    public function __construct(object $dish, bool $isPromo = false)
    {
        $this->id = $dish->dish_id;
        $this->name = $dish->dish_name;
        $this->description = $dish->description ?? null;
        $this->image_url = $dish->image_url ?? null;
        $this->old_price = $dish->old_price ?? null;
        $this->new_price = $dish->selling_price;
        $this->isPromo = $isPromo;
    }

    /**
     * Check if dish is in cart
     * @return bool
     */
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
        $html = "<div class='menu-item-card " . ((!$this->isPromo) ? "menu-dish" : ""). " rounded-sm'>";

        // Wrap card in link
        if ($this->isPromo) {
            $html .= "<a href='" . ROOT . "/promotion/id/{$this->id}' class='card-link'>";
        } else {
            $html .= "<a href='" . ROOT . "/dish/id/{$this->id}' class='card-link'>";
        }

        // Dish image
        $html .= "<div class='card-img-wrapper'>";
        if ($this->isPromo) {
            $html .= "<img src=" . ASSETS . "/images/promotions/{$this->image_url} class='card-img' alt='{$this->name}'>";
        } else {
            $html .= "<img src=" . ASSETS . "/images/dishes/{$this->image_url} class='card-img' alt='{$this->name}'>";
        }
        $html .= "</div></a>";

        if (!$this->isPromo) {
            // Add to Cart floating button (between links to prevent click event propagation)
            $html .= "<button class='add-to-cart not-mobile' data-id='{$this->id}' " . ($inCart ? "disabled" : "") . ">";
            $html .= "<i class='".($inCart ? "fa-solid fa-check" : "fa-sharp fa-solid fa-cart-plus")."'></i>";
            $html .= "</button>";
        }

        // Card link
        if ($this->isPromo) {
            $html .= "<a class='card-body-wrapper' href='" . ROOT . "/promotion/id/{$this->id}' class='card-link'>";
        } else {
            $html .= "<a class='card-body-wrapper' href='" . ROOT . "/dish/id/{$this->id}' class='card-link'>";
        }

        // Card body
        $html .= "<div class='card-body'><div class='card-content'>";
        $html .= "<h3 class='card-title". ($this->isPromo ? " text-uppercase secondary fw-bold" : "") ."'>{$this->name}</h2>";
        if ($this->isPromo && $this->description) {
            $html .= "<p class='card-description'>{$this->description}</p>";
        }
        $html .= "</div><div class='card-prices'>";

        // Old price
        if ($this->old_price) {
            $html .= "<span class='card-price-old'>LKR {$this->old_price}</span>";
        }

        $html .= "<div class='card-price-new'>LKR {$this->new_price}</div>";
        $html .= "</div></div></a></div>";
        return $html;
    }


}