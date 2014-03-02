<?php

$dir="modules/gpio/";
$gpio_post=$_POST['gpio'];

$name=$_POST['name'];
$id=$_POST['id'];

$day_zone1s=$_POST['day_zone1s'];
$day_zone1e=$_POST['day_zone1e'];



if ($_POST['off'] == "OFF") {
	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET simple_run='off', trigger_run='off', tempday_run='off', time_run='off', temp_run='off', day_run='off', time_start='off' WHERE gpio='$gpio_post'") or die("PDO exec error");
	$sth = $db->prepare("select * from gpio where gpio='$gpio_post'");
   $sth->execute();
   $result = $sth->fetchAll();    
   foreach ($result as $a) { 
     	if ( $a["gpio_rev_hilo"] == "on") { 
    		exec("/usr/local/bin/gpio -g write $gpio_post 1");	
    		}
    		else { 
    		exec("/usr/local/bin/gpio -g write $gpio_post 0");	
    		}
   	}
    	$db = NULL;
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
   
}


if ($_POST['on'] == "ON")  {
	exec("/usr/local/bin/gpio -g mode $gpio_post output");
	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET simple_run='on' WHERE gpio='$gpio_post'") or die("PDO exec error");
   $sth = $db->prepare("select * from gpio where gpio='$gpio_post'");
   $sth->execute();
   $result = $sth->fetchAll();    
   foreach ($result as $a) { 
     	if ( $a["gpio_rev_hilo"] == "on") { 
    		exec("/usr/local/bin/gpio -g write $gpio_post 0");	
    		}
    		else { 
    		exec("/usr/local/bin/gpio -g write $gpio_post 1");	
    		}
   	}
 	$db = NULL;
	header("location: " . $_SERVER['REQUEST_URI']);
   exit();
	}

  
$temp_sensor=$_POST['temp_sensor'];
$temp_onoff=$_POST['temp_onoff'];
$temp_op=$_POST['temp_op'];
$temp_temp=$_POST['temp_temp'];

$temp_sensor1=$_POST['temp_sensor1'];
$temp_onoff1=$_POST['temp_onoff1'];
$temp_op1=$_POST['temp_op1'];
$temp_temp1=$_POST['temp_temp1'];

$temp_sensor2=$_POST['temp_sensor2'];
$temp_onoff2=$_POST['temp_onoff2'];
$temp_op2=$_POST['temp_op2'];
$temp_temp2=$_POST['temp_temp2'];

$temp_sensor3=$_POST['temp_sensor3'];
$temp_onoff3=$_POST['temp_onoff3'];
$temp_op3=$_POST['temp_op3'];
$temp_temp3=$_POST['temp_temp3'];

if ($_POST['tempon'] == "tempON")  {
	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET temp_run='on',temp_op='$temp_op',temp_sensor='$temp_sensor',temp_onoff='$temp_onoff',temp_temp='$temp_temp' WHERE gpio='$gpio_post'") or die("exec error");
	$db->exec("UPDATE gpio SET temp_op1='$temp_op1',temp_sensor1='$temp_sensor1',temp_onoff1='$temp_onoff1',temp_temp1='$temp_temp1' WHERE gpio='$gpio_post'") or die("exec error");
	$db->exec("UPDATE gpio SET temp_op2='$temp_op2',temp_sensor2='$temp_sensor2',temp_onoff2='$temp_onoff2',temp_temp2='$temp_temp2' WHERE gpio='$gpio_post'") or die("exec error");
	$db->exec("UPDATE gpio SET temp_op3='$temp_op3',temp_sensor3='$temp_sensor3',temp_onoff3='$temp_onoff3',temp_temp3='$temp_temp3' WHERE gpio='$gpio_post'") or die("exec error");
	if (!empty($day_zone1s) && !empty($day_zone1e)) {
		$db->exec("UPDATE gpio SET tempday_run='on',day_zone1s='$day_zone1s',day_zone1e='$day_zone1e' WHERE gpio='$gpio_post'") or die("exec error");
		}
	$db = NULL;
	header("location: " . $_SERVER['REQUEST_URI']);
   exit();	
	}

if ($_POST['dayon'] == "dayON")  {
	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET day_run='on', day_zone1s='$day_zone1s',day_zone1e='$day_zone1e'  WHERE gpio='$gpio_post'") or die("exec error");
	$db = NULL;
	header("location: " . $_SERVER['REQUEST_URI']);
   exit();	
	}
$time_offset=$_POST['time_offset'];
if ($_POST['timeon'] == "timeON")  {
	$date = new DateTime();
	$time_start=$date->getTimestamp();
	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET time_offset='$time_offset',time_run='on',time_start='$time_start' WHERE gpio='$gpio_post'") or die("exec error");
	$sth = $db1->prepare("select * from gpio where gpio='$gpio_post'");
   $sth->execute();
   $result = $sth->fetchAll();    
   foreach ($result as $a) { 
     	if ( $a["gpio_rev_hilo"] == "on") { 
    		exec("/usr/local/bin/gpio -g write $gpio_post 0");	
    		}
    		else { 
    		exec("/usr/local/bin/gpio -g write $gpio_post 1");	
    		}
   	}
	$db = NULL;
	header("location: " . $_SERVER['REQUEST_URI']);
   exit();
}
if ($_POST['triggeron'] == "triggerON")  {
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET trigger_run='on' WHERE gpio='$gpio_post'") or die("exec error");
    $db = NULL;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}



// checkboxes

$time_checkbox=$_POST['time_checkbox'];
if ($_POST['xtimeon'] == "xtimeON")  {
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET time_checkbox='$time_checkbox' WHERE gpio='$gpio_post'") or die("exec error");
    $db = NULL;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
$temp_checkbox=$_POST['temp_checkbox'];
if ($_POST['xtempon'] == "xtempON")  {
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET temp_checkbox='$temp_checkbox' WHERE gpio='$gpio_post'") or die("exec error");
    $db->exec("UPDATE gpio SET tempday_checkbox='off' WHERE gpio='$gpio_post'") or  die("exec error");
    $db = NULL;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
$day_checkbox=$_POST['day_checkbox'];
if ($_POST['xdayon'] == "xdayON")  {
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET day_checkbox='$day_checkbox' WHERE gpio='$gpio_post'") or die("exec error");
    $db = NULL;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
$tempday_checkbox=$_POST['tempday_checkbox'];
if ($_POST['xtempdayon'] == "xtempdayON")  {
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET tempday_checkbox='$tempday_checkbox' WHERE gpio='$gpio_post'") or  die("exec error");
    $db = NULL;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
$trigger_checkbox=$_POST['trigger_checkbox'];
if ($_POST['xtriggeron'] == "xtriggerON")  {
	 exec("/usr/local/bin/gpio reset $gpio_post ");
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET trigger_checkbox='$trigger_checkbox' WHERE gpio='$gpio_post'") or die("exec error");
    $db = NULL;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}
$humi_checkbox=$_POST['humi_checkbox'];
if ($_POST['xhumion'] == "xhumiON")  {
	 exec("/usr/local/bin/gpio reset $gpio_post ");
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $sth = $db1->prepare("select * from gpio where gpio='$gpio_post'");
    $sth->execute();
    $result = $sth->fetchAll();    
    foreach ($result as $a) { 
    if ( $a["humi_checkbox"] == "on") { 
    	$db->exec("UPDATE gpio SET humi_checkbox='off' where gpio='$gpio_post' ") or die("exec error");
     	}
    	else { 
    	$db->exec("UPDATE gpio SET humi_checkbox='on' where gpio='$gpio_post' ") or die("exec error");
     	}
    }
    $db = NULL;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
}
if ($_POST['name1'] == "name2"){
	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
	$db->exec("UPDATE gpio SET name='$name' WHERE id='$id'") or die("name exec error");
	$db = NULL;
	header("location: " . $_SERVER['REQUEST_URI']);
	exit();
	 } 
$gpio_rev_hilo = $_POST["gpio_rev_hilo"];
if (($_POST['gpio_rev_hilo1'] == "gpio_rev_hilo2") ){
	//exec("/usr/local/bin/gpio -g mode $gpio_post output");
	$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $sth = $db->prepare("select * from gpio where gpio='$gpio_post'");
    $sth->execute();
    $result = $sth->fetchAll();    
    foreach ($result as $a) { 
    	if ( $a["gpio_rev_hilo"] == "on") { 
    	$db->exec("UPDATE gpio SET gpio_rev_hilo='off' where gpio='$gpio_post' ") or die("exec error");
    	//exec("/usr/local/bin/gpio -g write $gpio_post 0");	
    	}
    	else { 
    	$db->exec("UPDATE gpio SET gpio_rev_hilo='on' where gpio='$gpio_post' ") or die("exec error");
    	//exec("/usr/local/bin/gpio -g write $gpio_post 1");	
    	}
   }
	 $db = NULL;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
}



$dht11_onoff = $_POST["dht11_onoff"];
if (($_POST['dht11_onoff1'] == "dht11_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET humi_type='$dht11_onoff' where gpio='$gpio_post' ") or die("exec error");
	 $db = NULL;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }
$dht22_onoff = $_POST["dht22_onoff"];
if (($_POST['dht22_onoff1'] == "dht22_onoff2") ){
    $db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
    $db->exec("UPDATE gpio SET humi_type='$dht22_onoff' where gpio='$gpio_post' ") or die("exec error");
    $db = NULL;
    header("location: " . $_SERVER['REQUEST_URI']);
    exit();
    }

//main loop

$db = new PDO('sqlite:dbf/nettemp.db') or die("cannot open the database");
$sth = $db->prepare("select * from gpio");
$sth->execute();
$result = $sth->fetchAll();
foreach ( $result as $a) { ?>
<span class="belka">&nbsp Gpio <?php echo $a['gpio']; ?> <span class="okno">
<?php 
$gpio=$a['gpio'];
exec("$dir/gpio2 status $gpio", $out_arr);
    $out=$out_arr[0];
     //print_r ($out_arr); //debug
    unset($out_arr);    
    if ($out == 'on' ) { ?>
	<table><tr>
	<form action="gpio" method="post">
		<td>	<img type="image" src="media/ico/SMD-64-pin-icon_24.png" /></td>
		<td><?php echo $a['name']; ?></td>
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
		<input type="hidden" name="off" value="OFF" />
		<td><?php system("$dir/gpio2 check $gpio");
			
exec ('echo -e "dupa \n dupa \n dupa"', $scanme);
$scanme = implode("\n",$scanme);
	?> 
		</td>
		<td><input type="image"  src="media/ico/Button-Turn-Off-icon.png"/></td>
	</form>
	</tr></table>
 	<?php	} elseif ($out == 'off' || $out == 'temp' || $out == 'humi'  ) { ?>
	<table>
	<tr>
	<form action="gpio" method="post">
		<td><img type="image" src="media/ico/SMD-64-pin-icon_24.png" ></td>
		<td><input type="text" name="name" value="<?php echo $a['name']; ?>" size="10"></td>
		<input type="hidden" name="name1" value="name2">
		<input type="hidden" name="id" value="<?php echo $a['id']; ?>" >
		<td><input type="image" src="media/ico/Actions-edit-redo-icon.png" alt="Submit" title="Reload" ></td>
	</form>

<?php if  ($a['humi_checkbox'] == 'on') 
{ ?>
	<form action="gpio" method="post">
		<td><img  src="media/ico/rain-icon.png" title="Humidity on/off" /></td>
		<td><input type="checkbox" name="humi_checkbox" value="on" <?php echo $a["humi_checkbox"] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.submit()" /><td>
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
		<input type="hidden" name="xhumion" value="xhumiON" />
	</form>
	Humidity is enable
   <form action="gpio" method="post">
		<td>DHT11</td>
		<td><input type="checkbox" name="dht11_onoff" value="11" <?php echo $a["humi_type"] == '11' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
		<input type="hidden" name="dht11_onoff1" value="dht11_onoff2" />
	</form>
	<form action="gpio" method="post">
		<td>DHT22</td>
		<td><input type="checkbox" name="dht22_onoff" value="22" <?php echo $a["humi_type"] == '22' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
		<input type="hidden" name="dht22_onoff1" value="dht22_onoff2" />
	</form>
<?php } elseif ($a['time_checkbox'] == 'on') { ?>
	<form action="gpio" method="post">
		<td><img  src="media/ico/Clock-icon.png" title="Set time"/></td>
		<td><input type="checkbox" name="time_checkbox" value="on" <?php echo $a["time_checkbox"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /><td>
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
		<input type="hidden" name="xtimeon" value="xtimeON" />        
   </form>
   <form action="gpio" method="post">
    	<td><img type="image" src="media/ico/Letter-R-blue-icon.png" title="Reverse state HIGH to LOW" ></td>
    	<td><input type="checkbox" name="gpio_rev_hilo" value="on" <?php echo $a["gpio_rev_hilo"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    	<input type="hidden" name="gpio_rev_hilo1" value="gpio_rev_hilo2" />
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
	</form>
	<form action="gpio" method="post">
		<td><input type="text" name="time_offset" value="<?php echo $a['time_offset']; ?>" size="8"  ></td><td>min</td> 
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    	<td><input type="image" src="media/ico/Button-Turn-On-icon.png"/></td>
		<input type="hidden" name="timeon" value="timeON" />
	</form>
<?php } elseif ($a['day_checkbox'] == 'on') { ?>
	<form action="gpio" method="post">
		<td><img  src="media/ico/day-icon.png" title="day plan"/></td>
		<td><input type="checkbox" name="day_checkbox" value="on" <?php echo $a["day_checkbox"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /><td>
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
		<input type="hidden" name="xdayon" value="xdayON" />        
   </form>
   <form action="gpio" method="post">
    	<td><img type="image" src="media/ico/Letter-R-blue-icon.png" title="Reverse state HIGH to LOW" ></td>
    	<td><input type="checkbox" name="gpio_rev_hilo" value="on" <?php echo $a["gpio_rev_hilo"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    	<input type="hidden" name="gpio_rev_hilo1" value="gpio_rev_hilo2" />
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
   </form>
	<form action="gpio" method="post">
		<td>Start time</td>
		<td><input type="text" name="day_zone1s" value="<?php echo $a['day_zone1s']; ?>" size="8"  ></td><td></td> 
		<td>End time</td>
		<td><input type="text" name="day_zone1e" value="<?php echo $a['day_zone1e']; ?>" size="8"  ></td><td></td> 
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
		<td><input type="image" src="media/ico/Button-Turn-On-icon.png"/></td>
		<input type="hidden" name="dayon" value="dayON" />
	</form>


<?php
//         TEMP
 } elseif  ($a['temp_checkbox'] == 'on') { ?>
	<form action="gpio" method="post">
			<td><img  src="media/ico/temp2-icon.png" title="Set temp when sensor will turn on/off" /></td>
		<td><input type="checkbox" name="temp_checkbox" value="on" <?php echo $a["temp_checkbox"] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.submit()" /><td>
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
		<input type="hidden" name="xtempon" value="xtempON" />
	</form>
	<form action="gpio" method="post">
		<td><img  src="media/ico/day-icon.png" title="Day plan" /></td>
		<td><input type="checkbox" name="tempday_checkbox" value="on" <?php echo $a["tempday_checkbox"] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.submit()" /><td>
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
		<input type="hidden" name="xtempdayon" value="xtempdayON" />
	</form>
	<form action="gpio" method="post">
    	<td><img type="image" src="media/ico/Letter-R-blue-icon.png" title="Reverse state HIGH to LOW" ></td>
    	<td><input type="checkbox" name="gpio_rev_hilo" value="on" <?php echo $a["gpio_rev_hilo"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    	<input type="hidden" name="gpio_rev_hilo1" value="gpio_rev_hilo2" />
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    	</form>
	<td>
	if
	</td>
      <td>
	<form action="gpio" method="post">
		<select name="temp_sensor" >
		<?php $sth = $db->prepare("SELECT * FROM sensors");
		$sth->execute();
		$result = $sth->fetchAll();
		foreach ($result as $select) { ?>
		<option <?php echo $a['temp_sensor'] == $select['id'] ? 'selected="selected"' : ''; ?> value="<?php echo $select['id']; ?>"><?php echo "{$select['name']}  {$select['tmp']}" ?>&deg;C</option>
		<?php } ?>
        </select></td>
		<td>
	<select name="temp_op" >
        <option <?php echo $a['temp_op'] == 'lt' ? 'selected="selected"' : ''; ?> value="lt">&lt;</option>   
        <option <?php echo $a['temp_op'] == 'le' ? 'selected="selected"' : ''; ?> value="le">&lt;&#61;</option>     
        <option <?php echo $a['temp_op'] == 'gt' ? 'selected="selected"' : ''; ?> value="gt">&gt;</option>   
        <option <?php echo $a['temp_op'] == 'ge' ? 'selected="selected"' : ''; ?> value="ge">&gt;&#61;</option>  
	</select>
		</td>
		<td><input type="text" name="temp_temp" value="<?php echo $a['temp_temp']; ?>" size=3" >&deg;C</td>
		<td>then</td> 
		<td>
        <select name="temp_onoff" >
        <option <?php echo $a['temp_onoff'] == 'on' ? 'selected="selected"' : ''; ?> value="on">On</option>   
        <option <?php echo $a['temp_onoff'] == 'off' ? 'selected="selected"' : ''; ?> value="off">Off</option>     
        </select></td>
		<?php if ($a['tempday_checkbox'] == 'on') { ?>
	    <td>Time</td>
	    <td><input type="text" name="day_zone1s" value="<?php echo $a['day_zone1s']; ?>" size="4"  ></td><td></td> 
	    <td>to</td>
	    <td><input type="text" name="day_zone1e" value="<?php echo $a['day_zone1e']; ?>" size="4"  ></td><td></td> 
		<?php } ?>
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    	<td><input type="image" src="media/ico/Button-Turn-On-icon.png"/></td>
		<input type="hidden" name="tempon" value="tempON" />
<?php for ($i = 1; $i <= 2; $i++) { ?>

	</tr>
	<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td>
	if
	</td>
      <td>
		<select name="<?php echo "temp_sensor$i";?>" >
		<?php $sth = $db->prepare("SELECT * FROM sensors");
		$sth->execute();
		$result = $sth->fetchAll();
		foreach ($result as $select) { ?>
		<option <?php echo $a['temp_sensor'.$i] == $select['id'] ? 'selected="selected"' : ''; ?> value="<?php echo $select['id']; ?>"><?php echo "{$select['name']}  {$select['tmp']}" ?>&deg;C</option>
		<?php } ?>
        </select></td>
		<td>
	<select name="<?php echo "temp_op$i";?>" >
	<option <?php echo $a['temp_op'.$i] == 'lt' ? 'selected="selected"' : ''; ?> value="lt">&lt;</option>   
        <option <?php echo $a['temp_op'.$i] == 'le' ? 'selected="selected"' : ''; ?> value="le">&lt;&#61;</option>     
        <option <?php echo $a['temp_op'.$i] == 'gt' ? 'selected="selected"' : ''; ?> value="gt">&gt;</option>   
        <option <?php echo $a['temp_op'.$i] == 'ge' ? 'selected="selected"' : ''; ?> value="ge">&gt;&#61;</option>  
	</select>
		</td>
		<td><input type="text" name="<?php echo "temp_temp$i";?>" value="<?php echo $a['temp_temp'.$i]; ?>" size=3" >&deg;C</td>
		<td>then</td> 
		<td>
        <select name="<?php echo "temp_onoff$i";?>" >
        <option <?php echo $a['temp_onoff'.$i] == 'on' ? 'selected="selected"' : ''; ?> value="on">On</option>   
        <option <?php echo $a['temp_onoff'.$i] == 'off' ? 'selected="selected"' : ''; ?> value="off">Off</option>    

        </select></td>
			</tr>
<?php } ?>
	</form>
	
<?php } elseif ($a['trigger_checkbox'] == 'on') { ?>
	<form action="gpio" method="post">
		<td><img  src="media/ico/alarm-icon.png" title="Alarm trigger" /></td>
		<td><input type="checkbox" name="trigger_checkbox" value="on" <?php echo $a["trigger_checkbox"] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.submit()" /><td>
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
		<input type="hidden" name="xtriggeron" value="xtriggerON" />
	</form>
	<form action="gpio" method="post">
    	<td><img type="image" src="media/ico/Letter-R-blue-icon.png" title="Reverse state HIGH to LOW" ></td>
    	<td><input type="checkbox" name="gpio_rev_hilo" value="on" <?php echo $a["gpio_rev_hilo"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    	<input type="hidden" name="gpio_rev_hilo1" value="gpio_rev_hilo2" />
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>" />
    </form>
	<form action="gpio" method="post">
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    	<td><input type="image" src="media/ico/Button-Turn-On-icon.png"/></td>
		<input type="hidden" name="triggeron" value="triggerON" />
	</form>

<?php } else { ?>
	<td>                           </td>
	<form action="gpio" method="post">
		<td><img  src="media/ico/Clock-icon.png" title="Set time"/></td>
		<td><input type="checkbox" name="time_checkbox" value="on" <?php echo $a["time_checkbox"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /><td>
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
		<input type="hidden" name="xtimeon" value="xtimeON" />        
   </form>
	<form action="gpio" method="post">
		<td><img  src="media/ico/temp2-icon.png" title="Set temp when sensor will turn on/off" /></td>
		<td><input type="checkbox" name="temp_checkbox" value="on" <?php echo $a["temp_checkbox"] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.submit()" /><td>
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
		<input type="hidden" name="xtempon" value="xtempON" />
	</form>
	<form action="gpio" method="post">
		<td><img  src="media/ico/rain-icon.png" title="Humidity on/off" /></td>
		<td><input type="checkbox" name="humi_checkbox" value="on" <?php echo $a["humi_checkbox"] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.submit()" /><td>
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
		<input type="hidden" name="xhumion" value="xhumiON" />
	</form>
	<form action="gpio" method="post">
		<td><img  src="media/ico/day-icon.png" title="Day plan" /></td>
		<td><input type="checkbox" name="day_checkbox" value="on" <?php echo $a["day_checkbox"] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.submit()" /><td>
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
		<input type="hidden" name="xdayon" value="xdayON" />
	</form>
	<form action="gpio" method="post">
		<td><img  src="media/ico/alarm-icon.png" title="Alarm trigger" /></td>
		<td><input type="checkbox" name="trigger_checkbox" value="on" <?php echo $a["trigger_checkbox"] == 'on' ? 'checked="checked"' : ''; ?>  onclick="this.form.submit()" /><td>
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
		<input type="hidden" name="xtriggeron" value="xtriggerON" />
	</form>
	<form action="gpio" method="post">
    	<td><img type="image" src="media/ico/Letter-R-blue-icon.png" title="Reverse state HIGH to LOW" ></td>
    	<td><input type="checkbox" name="gpio_rev_hilo" value="on" <?php echo $a["gpio_rev_hilo"] == 'on' ? 'checked="checked"' : ''; ?> onclick="this.form.submit()" /></td>
    	<input type="hidden" name="gpio_rev_hilo1" value="gpio_rev_hilo2" />
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
   </form>
	<form action="gpio" method="post">
		<input type="hidden" name="gpio" value="<?php echo $a['gpio']; ?>"/>
    	<td><input type="image" src="media/ico/Button-Turn-On-icon.png"/></td>
		<input type="hidden" name="on" value="ON" />
	</form>
<?php } ?>
	</tr>
	</table>
<?php } ?>
	</span></span>
<?php 
} //end for
$db = NULL;
?>

 
