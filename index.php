<?php
require_once 'lib/limonade.php';

dispatch_get('/', 'index');
dispatch_get('/get_by_ingredient', 'get_by_ingredient');

function index(){return html('views/index.html');}
function get_by_ingredient(){return html('views/recipe_by_ingredient.html');}

run();
?>
