<?php

namespace components;

class MenuItem
{
    protected int $id;
    protected string $name;
    protected string|null $description;
    protected string|null $image_url;
    protected string|null $old_price;
    protected string $new_price;

    /**
     * @param string $id
     * @param string $name
     * @param string $url
     * @param string $description
     * @param string $image_url
     * @param string $old_price
     * @param string $new_price
     */
    public function __construct(string $id, string $name, string|null $description, string|null $image_url, string|null $old_price, string $new_price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->image_url = $image_url;
        $this->old_price = $old_price;
        $this->new_price = $new_price;
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
        $html = "<div class='card rounded-sm shadow'>";
        $html .= "<div class='card-img-wrapper'>";
        $html .= "<img src=" . ASSETS . "/images/dishes/" . $this->image_url . " class='card-img' alt='{$this->name}'>";
        $html .= "</div>";
        $html .= "<div class='card-body'>";
        $html .= "<h2 class='card-title'>{$this->name}</h2>";
        $html .= "<div class='card-prices'>";
        if ($this->old_price) {
            $html .= "<span class='card-price-old'>LKR {$this->old_price}</span>";
        }
        $html .= "<div class='card-price-new'>LKR {$this->new_price}</div>";
        $html .= "</div></div></div>";
        return $html;
    }


}