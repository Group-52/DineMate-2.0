<?php

namespace components;

class Pagination
{
    private int $totalPages;
    private int $currentPage;
    private int $windowSize;
    private int $windowStart;
    private int $windowEnd;

    /**
     * @param int $totalCount Total number of items
     * @param int $currentPage Current page number
     * @param int $perPage Number of items per page
     * @param int $windowSize Number of pages to show in pagination
     */
    public function __construct(int $totalCount, int $currentPage, int $perPage = 10, int $windowSize = 10)
    {
        $this->totalPages = ceil($totalCount / $perPage);
        $this->windowSize = $windowSize;
        $this->currentPage = $currentPage;
        $this->windowStart = $currentPage - floor($this->windowSize / 2);
        $this->windowEnd = $currentPage + floor($this->windowSize / 2) - 1;
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
     * Return HTML string
     * @return string
     */
    public function html(): string
    {
        if ($this->totalPages <= 1) {
            return "";
        }

        $html = "<div class='pagination fs-4 my-5'>";
        $html .= "<ul>";

        // Show previous page button if not on first page
        if ($this->currentPage > 1) {
            $html .= "<li class='page-item'><a class='page-link' href='?page=" . ($this->currentPage - 1) . "'><i class='fa-solid fa-chevron-left'></i></a></li>";
        }

        // Show buttons for pages in window
        for ($i = max($this->windowStart, 1); $i <= min($this->windowEnd, $this->totalPages); $i++) {
            $html .= "<li class='page-item";
            if ($i == $this->currentPage) {
                $html .= " active";
            }
            $html .= "'><a class='page-link' href='?page=$i'>$i</a></li>";
        }

        // Show next page button if not on last page
        if ($this->currentPage < $this->totalPages) {
            $html .= "<li class='page-item'><a class='page-link' href='?page=" . ($this->currentPage + 1) . "'><i class='fa-solid fa-chevron-right'></i></a></li>";
        }
        $html .= "</ul>";
        $html .= "</div>";

        return $html;
    }
}