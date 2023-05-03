<?php

namespace components;

class Form
{
    protected array $errors = [];
    protected string $action = "";
    protected string $method = "POST";
    protected string $submitText = "Submit";
    protected array $fields = [];

    /**
     * @param string $action Form action
     * @param string $method Form method
     * @param string $submitText Submit button text
     */
    public function __construct(string $action, string $method = "POST", string $submitText = "Submit")
    {
        $this->action = $action;
        $this->method = $method;
        $this->submitText = $submitText;
    }

    /**
     * Add a field to the form
     * @param string $name Field name
     * @param string $id Field id
     * @param string $type Field type
     * @param string $label Field label
     * @param bool $required Field required
     * @param string $placeholder Field placeholder
     * @param string $value Field value
     * @param array $options Field options
     * @return void
     */
    public function addInputField(string $name, string $id, string $type = "text", string $label = "", bool $required = false, string $placeholder = "", string $value = "", bool $disabled = false, array $options = []): void
    {
        $this->fields[] = [
            "name" => $name,
            "id" => $id,
            "type" => $type,
            "label" => $label,
            "required" => $required,
            "placeholder" => $placeholder,
            "value" => $value,
            "disabled" => $disabled,
            "options" => $options
        ];
    }

    /**
     * Add a select field to the form
     * @param string $name Field name
     * @param string $id Field id
     * @param string $label Field label
     * @param bool $required Field required
     * @param array $options Field options
     * @param string $placeholder Field value
     */
    public function addSelectField(string $name, string $id, string $label = "", bool $required = false, array $options = [], string $placeholder = "", bool $disabled = false): void
    {
        $this->fields[] = [
            "name" => $name,
            "id" => $id,
            "type" => "select",
            "label" => $label,
            "required" => $required,
            "options" => $options,
            "placeholder" => $placeholder,
            "disabled" => $disabled
        ];
    }

    /**
     * Validate form data.
     * @param array $data
     * @return bool
     */
    public function isValid(array $data): bool
    {
        $this->errors = [];
        foreach ($this->fields as $field) {
            if (empty($data[$field["name"]]) && $field["required"]) {
                $this->errors[$field["name"]] = $field["label"] . " is required.";
            }
        }
        return empty($this->errors);
    }

    /**
     * Get form errors
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Renders form
     * @return void
     */
    public function render(): void
    {
        echo $this->html();
    }

    /**
     * Return HTML representation of Form
     * @return string
     */
    public function html(): string
    {
        $html = "<form class='w-100' action='{$this->action}' method='{$this->method}'>";
        foreach ($this->fields as $field) {
            $html .= $this->getHtml($field);
        }
        $html .= "<button type='submit' class='btn btn-primary text-uppercase w-100'>{$this->submitText}</button>";
        $html .= "</form>";
        return $html;
    }

    /**
     * @return array Array of HTML fields
     */
    public function htmlFields(): array
    {
        $fields = [];
        foreach ($this->fields as $field) {
            $html = $this->getHtml($field);
            $fields[] = $html;
        }
        return $fields;
    }

    /**
     * @param $id int Field id
     * @return string HTML representation of field
     */
    public function htmlField(int $id): string
    {
        return $this->getHtml($this->fields[$id]);
    }

    /**
     * @param bool $fullWidth
     * @return string HTML representation of submit button
     */
    public function htmlButton(bool $fullWidth = true): string
    {
        $btnId = strtolower(str_replace(" ", "-", $this->submitText));
        return "<button type='submit' class='btn btn-primary text-uppercase " . ($fullWidth ? "w-100" : "") . "' id='{$btnId}'>{$this->submitText}</button>";
    }

    /**
     * @return void Set form start tag
     */
    public function beginForm(): void
    {
        echo "<form class='w-100' action='{$this->action}' method='{$this->method}'>";
    }

    /**
     * @return void Set form end tag
     */
    public function endForm(): void
    {
        echo "</form>";
    }

    /**
     * @param mixed $field
     * @return string
     */
    public function getHtml(mixed $field): string
    {
        $html = "<div class='form-group'>";
        // Displays label before input field if not a checkbox
        if (!empty($field["label"] && $field["type"] != "checkbox")) {
            $html .= "<label class='label text-uppercase fw-bold " . ($field["required"] ? "required" : "") . "' for='{$field['id']}'>{$field['label']}</label>";
        }
        // Displays options if select input field
        if ($field["type"] == "select") {
            $html .= "<select name='{$field['name']}' id='{$field['id']}' class='form-control'" . (($field['required']) ? " required" : "") . (($field['disabled']) ? " disabled" : "");
            if (!empty($field["options"])) {
                foreach ($field["options"] as $option => $value) {
                    $html .= " {$option}='{$value}'";
                }
            }
            $html .= ">";

            // Displays placeholder if set
            if (!empty($field["placeholder"])) {
                $html .= "<option value=''>{$field['placeholder']}</option>";
            }

            // Displays options
            foreach ($field["options"] as $option => $value) {
                $html .= "<option value='{$option}'>{$value}</option>";
            }
            $html .= "</select>";

        } else {
            $html .= "<input type='{$field['type']}' name='{$field['name']}' id='{$field['id']}' class='form-control' value='{$field['value']}'" . (($field['required']) ? " required" : "") . (($field['disabled']) ? " disabled" : "");
            if (!empty($field["placeholder"])) {
                $html .= " placeholder='{$field['placeholder']}'";
            }
            if (!empty($field["options"])) {
                foreach ($field["options"] as $option => $value) {
                    $html .= " {$option}='{$value}'";
                }
            }
            $html .= ">";
        }
        // Displays label after checkbox
        if (!empty($field["label"] && $field["type"] == "checkbox")) {
            $html .= "<label class='label text-uppercase fw-bold " . ($field["required"] ? "required" : "") . "' for='{$field['id']}'>{$field['label']}</label>";
        }
        $html .= "</div>";
        return $html;
    }

    /**
     * @return int Number of fields in form
     */
    public function countFields(): int
    {
        return count($this->fields);
    }
}