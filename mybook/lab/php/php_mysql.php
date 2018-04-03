<?php
$st = time();
$mysqli = new mysqli('localhost', 'root', '123456', 'school_info');

/*
 * This is the "official" OO way to do it,
 * BUT $connect_error was broken until PHP 5.2.9 and 5.3.0.
 */
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

/*
 * Use this instead of $connect_error if you need to ensure
 * compatibility with PHP versions prior to 5.2.9 and 5.3.0.
 */
if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}

echo 'Success... ' . $mysqli->host_info . "\n";

function get_random_string()
{
    $char_pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
    $strlen = 60;
    $len = rand(10,20);
    $ret = "";
    for($i = 0; $i < $len; ++$i) {
        $ret.=$char_pool[rand(0, $strlen)];
    }
    return $ret;
}
$total_count = 500000;
$data_rows = 500;


function save_data($conn, $data_rows) {
    $ins_data = [];
    for($i = 0; $i < $data_rows; $i++) {
        $tmp = sprintf("('%s',%s,'%s')", get_random_string(), rand(10,100), get_random_string());
        $ins_data[] = $tmp;
    }
    $ins_val = implode(",", $ins_data);
    $ins_sql = sprintf("insert into students (name, age, address) values %s", $ins_val);
    mysqli_query($conn, $ins_sql);
}

for($cnt = 0; $cnt < $total_count; $cnt+=$data_rows) {
    save_data($mysqli, $data_rows);
}

$mysqli->close();

$abs = time() - $st;
echo sprintf("cost time %f seconds\n", $abs);

?>
