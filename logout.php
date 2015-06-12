<?php

if (session_destroy()) {
	header('location: ./');
	die();
}
