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
    public function addField(string $name, string $id, string $type = "text", string $label = "", bool $required = false, string $placeholder = "", string $value = "", array $options = []): void
    {
        $this->fields[] = [
            "name" => $name,
            "id" => $id,
            "type" => $type,
            "label" => $label,
            "required" => $required,
            "placeholder" => $placeholder,
            "value" => $value,
            "options" => $options
        ];
    }

    /**
     * Validate form data.
     * @param array $data
     * @return bool
     */
    public function validate(array $data): bool
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
            $html .= "<div class='form-group'>";
            if (!empty($field["label"])) {
                $html .= "<label class='label text-uppercase fw-bold " . ($field["required"] ? "required" : "") . " for='{$field['id']}'>{$field['label']}</label>";
            }
            $html .= "<input type='{$field['type']}' name='{$field['name']}' id='{$field['id']}' class='form-control' value='{$field['value']}' " . (($field['required']) ? "required" : "");
            if (!empty($field["placeholder"])) {
                $html .= " placeholder='{$field['placeholder']}'";
            }
            if (!empty($field["options"])) {
                foreach ($field["options"] as $option => $value) {
                    $html .= " {$option}='{$value}'";
                }
            }
            $html .= ">";
            $html .= "</div>";
        }
        $html .= "<button type='submit' class='btn btn-primary btn-lg text-uppercase w-100'>{$this->submitText}</button>";
        $html .= "</form>";
        return $html;
    }
}