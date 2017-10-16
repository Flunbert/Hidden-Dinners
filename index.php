<?php
require_once 'lib/limonade.php';

dispatch_get('/', 'hello');

function hello()
{
  return html('html/index.html');
}

run();
?>
