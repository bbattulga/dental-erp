<?php

	$d1 = Date('Y-m-d');
	$d2 = Date('Y-m-d', strtotime('-1 Years'));

	echo $d1 == $d2;
	echo $d2;