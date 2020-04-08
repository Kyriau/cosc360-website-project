<?php

	$pwhash = password_hash("password", PASSWORD_DEFAULT);
	echo "$pwhash";

?>