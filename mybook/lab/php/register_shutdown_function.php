<?php
function test()
{
    echo "in test method , this  function finished".PHP_EOL;
    register_shutdown_function('test_register_shutdown_function');
    echo "after test finished".PHP_EOL;
}

function test_register_shutdown_function()
{
    sleep(3);
    echo "this is register_shutdown_function".PHP_EOL;
}

test();
?>
