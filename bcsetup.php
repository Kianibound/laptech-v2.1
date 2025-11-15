<?php // bcsetup.php
include_once 'bcfunctions.php';

createTable($mysqli, 'bcpeople', 'firstname VARCHAR(16),lastname VARCHAR(16),
                    username VARCHAR(16), staffno INT UNSIGNED,
                    password VARCHAR(16)');
                    
createTable($mysqli, 'bcabilities','staffnumber INT UNSIGNED , operation VARCHAR(16),
                    approvaldate INT UNSIGNED');
                    
createTable($mysqli, 'bcoperations','operation VARCHAR(16),relateddocs VARCHAR(16)');

createTable($mysqli, 'bcoperationsdone','batchno VARCHAR(16),operation VARCHAR(16),staffnumber INT UNSIGNED, 
                    starttime INT UNSIGNED, endtime INT UNSIGNED, quantitycomplete INT UNSIGNED,
                    scrap INT UNSIGNED');
                    
createTable($mysqli, 'bcbatchinfo','batchno VARCHAR(16),productcode VARCHAR(16),
                    productdescription VARCHAR(16),qtystart INT UNSIGNED,
                    qtyadd INT UNSIGNED,qtyreq INT UNSIGNED,started BOOL, completed BOOL');
//should I put the required operations for a batch here as well or make another table??
                  
createTable($mysqli, 'bcorders','productcode VARCHAR(16),productdescription VARCHAR(16),
                    qtyreq INT UNSIGNED,shipdate INT UNSIGNED,notes VARCHAR(4096),
                    sor VARCHAR(16)');
                    
createTable($mysqli, 'bcshipped','batchno VARCHAR(16),qty INT UNSIGNED,sor VARCHAR(16)
                    ,date INT UNSIGNED');
                    
createTable($mysqli, 'bckits','batchno VARCHAR(16),qty INT UNSIGNED,wor VARCHAR(16)
                    ,date INT UNSIGNED');
                    
createTable($mysqli, 'bcmembers', 'user VARCHAR(16), pass VARCHAR(16),
	 	    INDEX(user(6))');

createTable($mysqli, 'bcmessages', 
		   'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	 	    auth VARCHAR(16), recip VARCHAR(16), pm CHAR(1),
	 	    time INT UNSIGNED, message VARCHAR(4096),
		    INDEX(auth(6)), INDEX(recip(6))');

createTable($mysqli, 'bcfriends', 'user VARCHAR(16), friend VARCHAR(16),
	 	    INDEX(user(6)), INDEX(friend(6))');

createTable($mysqli, 'bcprofiles', 'user VARCHAR(16), text VARCHAR(4096),
	 	    INDEX(user(6))');
?>
