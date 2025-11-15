<?php
include('db.php');
if($_POST['id'])
{
$id=$_POST['id'];
$sql=$mysqli->query("select b.id,b.data from data_parent a,data b where b.id=a.did and parent='$id'");

while($row=mysqli_fetch_array($sql))
{
$id=$row['id'];
$data=$row['data'];
echo '<option value="'.$id.'">'.$data.'</option>';

}
}

?>