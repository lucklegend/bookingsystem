<?php 

//Change the $mainURL for migration.

$mainURL = 'http://localhost/ardmore/';
$routes = [
    'URL' => $mainURL,
    'login' => $mainURL.'login',
    'logout' => $mainURL.'logout',
    'home' => $mainURL.'index',
    'amenities' => $mainURL.'pages/amenities/view?crypted='.$_GET['crypted'],
    'amenitiesEdit'=> $mainURL.'pages/amenities/edit?crypted='.$_GET['crypted'],
    'amenitiesCreate'=> $mainURL.'pages/amenities/create?crypted='.$_GET['crypted'],
    'amenitiesDelete'=> $mainURL.'pages/amenities/delete?crypted='.$_GET['crypted'],
    'users'=> $mainURL.'pages/users/view?crypted='.$_GET['crypted'],
    'usersEdit'=> $mainURL.'pages/users/edit?crypted='.$_GET['crypted'],
    'usersCreate'=> $mainURL.'pages/users/create?crypted='.$_GET['crypted'],
    'usersDelete'=> $mainURL.'pages/users/delete?crypted='.$_GET['crypted'],
    'calendar'=> $mainURL.'pages/calendar/view?crypted='.$_GET['crypted'],
];
?>