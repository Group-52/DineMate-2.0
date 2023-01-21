<?php
/**
 * Controller
 * Base controller trait.
 */

namespace core;
trait Controller
{
    /**
     * Render a view.
     * @param string $view
     * @param array $data
     */
    public function view(string $view, array $data = []): void
    {
        if (!empty($data)) {
            extract($data);
        }

        $filename = "../app/views/" . $view . ".view.php";
        if (!file_exists($filename)) {
            $filename = "../app/views/404.view.php";
        }
        require $filename;
    }
}