<?php

namespace components;

class Pagination
{
    private int $totalPages;
    private int $currentPage;
    private int $windowSize;
    private int $windowStart;
    private int $windowEnd;

    public function __construct(int $totalCount, int $currentPage, int $perPage = 10, int $windowSize = 10)
    {
        $this->totalPages = ceil($totalCount / $perPage);
        $this->windowSize = $windowSize;
        $this->currentPage = $currentPage;
        $this->windowStart = $currentPage - floor($this->windowSize / 2);
        $this->windowEnd = $currentPage + floor($this->windowSize / 2) - 1;
    }

    public function render(): void
    {
        echo $this->html();
    }

    public function html(): string
    {
        $html = "<div class='pagination fs-4 my-5'>";
        $html .= "<ul>";
        if ($this->currentPage > 1) {
            $html .= "<li class='page-item'><a class='page-link' href='?page=" . ($this->currentPage - 1) . "'><i class='fa-solid fa-chevron-left'></i></a></li>";
        }
        for ($i = max($this->windowStart, 1); $i <= min($this->windowEnd, $this->totalPages); $i++) {
            $html .= "<li class='page-item";
            if ($i == $this->currentPage) {
                $html .= " active";
            }
            $html .= "'><a class='page-link' href='?page=$i'>$i</a></li>";
        }
        if ($this->currentPage < $this->totalPages) {
            $html .= "<li class='page-item'><a class='page-link' href='?page=" . ($this->currentPage + 1) . "'><i class='fa-solid fa-chevron-right'></i></a></li>";
        }
        $html .= "</ul>";
        $html .= "</div>";

        return $html;
    }
}