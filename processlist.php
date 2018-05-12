<?php

$username = 'root';//'dbadmin';
$password = 'Root123$';//'M3sh00t0nm3';
$con = mysqli_connect("192.168.2.68:33060", $username, $password, 'ss_foundation');

$result = mysqli_query($con, "SHOW FULL PROCESSLIST");
$deleted = 0;
$count = 0;
$sleep = 0;
while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
//echo "<pre>";print_r($row);
  $process_id=$row["Id"];
  $tabledata[$count] = $row;
  $row["Command"]."<br />";
  if ($row["Command"] =='Sleep'){
      if($row["Time"] > 2){
          $sql="KILL $process_id";
          mysqli_query($con, $sql);
        $deleted++;
      } else {
        $sleep++;
      }
  }
  $count++;
}
//echo ($count-$deleted);
mysqli_close($con);

?>
<table border="1" cellpadding="3" cellspacing="5">
     <tr>
          <th>Total Process</th>
          <th>Total Sleep Process</th>
          <th>Total Running Process</th>
     </tr>
    <tr>
          <td><?php echo $count?></td>
          <td><?php echo $sleep?></td>
          <td><?php echo ($count-$deleted-$sleep)?></td>              
    </tr> 
</table>
<table border="1" cellpadding="3" cellspacing="4">
    <tr>
      <th>Process Id</th>       
      <th>User</th>
      <th>Host</th>
      <th>DB Name</th>
      <th>Process Type</th>
      <th>Time</th>
      <th>State</th>
      <th>Info</th>
    </tr>
    <?php 
    foreach($tabledata as $data){
   ?>
      <tr>
          <td><?php echo $data['Id']?></td>
          <td><?php echo $data['User']?></td>
          <td><?php echo $data['Host']?></td>
          <td><?php echo $data['db']?></td>
          <td><?php echo $data['Command']?></td>
          <td><?php echo $data['Time']?></td>
          <td><?php echo $data['State']?></td>
          <td><?php echo $data['Info']?></td>
      </tr>
   <?php
    } ?>
</table>
