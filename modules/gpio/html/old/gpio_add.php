<?php 
$gpioad = isset($_POST['gpioad']) ? $_POST['gpioad'] : '';
$add = isset($_POST['add']) ? $_POST['add'] : '';
$gpio = isset($_POST['gpio']) ? $_POST['gpio'] : '';

if ( $add == "ADD") {
	$db = new PDO('sqlite:dbf/nettemp.db');
	if (!empty($gpioad)) { 
	    $db->exec("INSERT INTO gpio (gpio, name, time_start, gpio_rev_hilo ,gpio_kwh_divider) VALUES ('$gpio','new','off','off','1')") or die ($db->lastErrorMsg());
	}
	else {
	    $db->exec("DELETE FROM gpio WHERE gpio='$gpio'") or die ($db->lastErrorMsg());
	}
	$db = NULL;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
}
?>
<span class="belka">&nbsp Free gpio <span class="okno">
<?php
    exec("/usr/local/bin/gpio -v |grep B+", $rpicheck );
    if (!empty($rpicheck[0]))
    {
        $gpiolist = array(17,27,22,5,6,13,19,26,18,23,24,25,12,16,20,21);
    }
    else
    {
		$gpiolist = array(17,18,21,22,23,24,25);
    } ?>
<table><tr>
<?php
foreach ($gpiolist as $value1) {
	$db = new PDO('sqlite:dbf/nettemp.db');
	$rows = $db->query("SELECT * FROM gpio WHERE gpio='$value1'");
	$row = $rows->fetchAll();
	foreach ($row as $result) { 
   	$check = $result['gpio']; 
	}; ?>
 
   <form action="" method="post">
    <td><?php echo $value1 ?></td>
    <td><input type="checkbox" name="gpioad" value="<?php echo $value1 ?>" <?php  echo $check==$value1 ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    <input type="hidden" name="gpio" value="<?php echo $value1 ?>" />
    <input type="hidden" name="add" value="ADD" />
    </form>







<?php } ?>
</tr></table>
</span></span>