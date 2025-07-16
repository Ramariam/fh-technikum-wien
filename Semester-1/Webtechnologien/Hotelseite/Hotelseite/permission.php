<?php
$roles = array("anonymous", "user", "admin");

function hasPermission($requiredRole, $currentRole) {
    global $roles;

    if (!in_array($requiredRole, $roles) || !in_array($currentRole, $roles)) {
        return false;
    }

    $requiredIndex = array_search($requiredRole, $roles);
    $currentIndex = array_search($currentRole, $roles);

    return $currentIndex <= $requiredIndex;
}
?>
