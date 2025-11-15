<?php
include('db.php');
if($_POST['id'])
{
$id=$_POST['id'];
$batch = $id;
$inf_result = $mysqli->query("SELECT * FROM `bcbatchinfo` WHERE `batchno` = '$id'");
while($inf_row=mysqli_fetch_array($inf_result))
{
    $productcode = $inf_row[1];
    $build_type = $inf_row[9];
    
}
If ($build_type == 'Full')
{
    //get the number of operations#
    $sql = $mysqli->query("SELECT * FROM `bcproductoperations`");
    $once = 0;
    //$num_sql = mysqli_num_rows($sql);
    while($row=mysqli_fetch_array($sql))
    {
        $num = count($row,1);
        //$num = $num / $num_sql;
        if ($once == 0)
        {
            for ($i = 2; $i < $num; ++$i)
            {
                $once = 1;
                $op = $i-1;
                $ops = $mysqli->query("SELECT * FROM `bcoperations` WHERE `OpNo` = '$op'");
                while($row_ops=mysqli_fetch_array($ops))
                {
                    echo '<option value="'.$op.'">Local Op'.$op.' Global op '.$op.' '.$row_ops[1].'</option>';
                }
            }
        }
        //$num = $num - 5;
        //echo '<option value="'.$id.'">'.$num.'</option>';
    }
    //fill with every operation
}
else
{
    $sql = $mysqli->query("SELECT * FROM `bcproductoperations` WHERE `Product_code` = '$productcode'
        AND `Build_type` = '$build_type'");

    while($row=mysqli_fetch_array($sql))
    {
        $num = count($row,1);
        for ($i = 2; $i < $num; ++$i)
        {
            //$i  = global operation
            $op = $i - 1;
            $ops = $mysqli->query("SELECT 'operation_".$op."' FROM `bcproductoperations` WHERE `Product_code` = '$productcode'
                AND `Build_type` = '$build_type'");
            //$ops = $mysqli->query("SELECT 'operation".$op."' FROM `bcproductoperations` WHERE `Product_code` = '$productcode'
            //    AND `Build_type` = '$build_type'");
            while($row_ops=mysqli_fetch_array($ops))
            {
                $num_ops = count($row_ops,1);
                $thisop = $row_ops[0]-1;
                for ($j = 3; $j < $num; ++$j)
                {
                    $once = 0;
                    if ($row[$j] != '0' && $row[$j] == $op)
                    {
                        $thisop = $j-2;
                        $op1 = $op-1;
                        //$op is the local op 
                        //$thisop is the global op
                        $ops = $mysqli->query("SELECT * FROM `bcoperations` WHERE `OpNo` = '$thisop'");
                        while($row_ops=mysqli_fetch_array($ops))
                        {
                            echo '<option value="'.$op1.'">Local Op'.$op.' Global op '.$thisop.' '.$row_ops[1].'</option>';
                        }
                        //echo "<option value='.$op.'>$op,$row[$j],$j</option>";
                    }
                    
                } 
                
            }
            
        }

    }
}/*
*/
for ($i = 0; $i < 10; ++$i)
{
    $id = $i;
   //$data = $id;
   // echo '<option value="'.$id.'">'.$num.'</option>';
    //echo '<option value="'.$id.'">'.$id.'</option>';
}
}

?>