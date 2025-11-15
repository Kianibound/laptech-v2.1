<?php // get_operations.php
include_once 'bcfunctions.php';
$batchno=$_GET["q"];
    
//get product code and build type

$batchinfo = queryMysql($mysqli, "SELECT * FROM bcbatchinfo WHERE batchno = '$batchno'");
// $result2 = queryMysql($mysqli, "SELECT * FROM bcstock ORDER BY $Arrange");
$num_batchinfo = mysqli_num_rows($batchinfo);
    for ($j = 0; $j < $num_batchinfo; ++$j)
    {
        $row_batchinfo = mysqli_fetch_row($batchinfo);
    }
$proddesc = queryMysql($mysqli, "SELECT * FROM bcoperations");
$num_proddesc = mysqli_num_rows($proddesc);
echo $row_batchinfo[9];
if ($row_batchinfo[9]== 'Full')//loop for full build type
{
    $proddesc = queryMysql($mysqli, "SELECT * FROM bcoperations");
    $num_proddesc = mysqli_num_rows($proddesc);
    for ($j = 0; $j < $num_proddesc; ++$j)
    {
        $glob_num = $j + 1;
        $Loc_num = $j + 1;
        $row_proddesc = mysqli_fetch_row($proddesc);
        echo '<option value="'.$glob_num.'" >Global op'.$glob_num.' Local Op'.$Loc_num.' '.$row_proddesc[1].'</option>';
    }
}
else
    {   
    //using productcode and build type get the operations in an array with 
    // the local op then global op then the operation description  
       
    $prodop = queryMysql($mysqli, "SELECT * FROM bcproductoperations WHERE (Product_code = '$row_batchinfo[1]' AND build_type = '$row_batchinfo[9]')");
    $num_prodop = mysqli_num_rows($prodop);
        for ($j = 0; $j < $num_prodop; ++$j)
        {
            $row_prodop = mysqli_fetch_row($prodop);
        }

    $num_global = count($row_prodop);
    $num_local = 0;
    //find number of ops in build
    for ($j = 2; $j < $num_global; ++$j)
    {
        if ($row_prodop[$j] != 0)
        {
            ++$num_local;
        }
    }

    for ($j = 0; $j < $num_local; ++$j)
    {
        
        for ($i = 2; $i < $num_global; ++$i)
        {
            
            if ($j+1 == $row_prodop[$i])
            {
                $prodoparray[$j]=$i;
                $glob_num = $i-1;
                $proddesc = queryMysql($mysqli, "SELECT * FROM bcoperations WHERE (OpNo = $glob_num)");
                $num_proddesc = mysqli_num_rows($proddesc);
                    for ($ij = 0; $ij < $num_proddesc; ++$ij)
                    {
                        $row_proddesc = mysqli_fetch_row($proddesc);
                    }//
                           
                $Loc_num = $j+1;
                echo '<option value="'.$glob_num.'" >Global op'.$glob_num.' Local Op'.$Loc_num.' '.$row_proddesc[1].'</option>';
            }
                
        
    //output the array to make a dropdown for the operation number with the local# global# and operation description
        
        }
    }
}   
        


?>