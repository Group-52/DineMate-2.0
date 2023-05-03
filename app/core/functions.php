<?php

/**
 * Display information of a variable in a readable format
 * @param $data
 * @return void
 */
function show($data): void
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

/**
 * Escape HTML characters
 * @param string $string
 * @return string
 */
function escape_string(string $string): string
{
    return htmlspecialchars($string, ENT_QUOTES, "UTF-8");
}

/**
 * Redirect to a page
 * @param string $path
 * @return void
 */
function redirect(string $path): void
{
    header("Location: " . ROOT . "/" . $path);
}

/**
 * Redirect to login page with current page as redirect parameter
 */
function redirectToLogin(): void
{
    redirect("auth/login?redirect=" . urlencode($_SERVER['REQUEST_URI']));
}

/**
 * Generates a unique name for the file using timestamp
 *
 * @param string $name
 * @param array $file
 * @return string
 */
function getFileName(string $name, array $file): string
{
    $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $name = str_replace(' ', '', $name);
    $date = new DateTime();
    $n = $date->format('H:i:s');
    $n = str_replace(array("-", " ", ":"), "_", $n);
    return $name . $n . "." . $ext;
}

/**
 * Check if the file is of an image type
 * @param array $file
 * @return bool
 */
function isImageType(array $file): bool
{
    $target_file = basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    return ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif");
}

/**
 * Check if the file size is not too large
 * @param array $file
 * @param int $size Size in bytes
 * @return bool
 */
function isValidSize(array $file, int $size): bool
{
    return ($file["size"] <= $size);
}

/**
 * Check if the file is an actual image
 * @param array $file
 * @return bool
 */
function isImage(array $file): bool
{
    $check = getimagesize($file["tmp_name"]);
    if ($check !== false) {
        return true;
    } else {
        return false;
    }
}

/**
 * Check if a registered user is logged in
 */
function isRegistered(): bool
{
    return isset($_SESSION['user']) && $_SESSION['user']->registered;
}

/**
 * Check if a guest user is logged in
 */
function isGuest(): bool
{
    return isset($_SESSION['user']) && !$_SESSION['user']->registered;
}

/**
 * Check if a user is logged in
 */
function isLoggedIn(): bool
{
    return isset($_SESSION['user']);
}

/**
 * Check if a user is not logged in
 */
function isNotLoggedIn(): bool
{
    return !isset($_SESSION['user']);
}

function userId(): int | null
{
    if (isLoggedIn())
        return $_SESSION['user']->user_id;
    else
        return null;
}

function createSessionGuest($guestId): void
{
    $_SESSION['user'] = new \stdClass();
    $_SESSION['user']->user_id = $guestId;
    $_SESSION['user']->registered = false;
}

function userColumn($isGuest = false): string
{
    return ($isGuest) ? 'guest_id' : 'reg_customer_id';
}