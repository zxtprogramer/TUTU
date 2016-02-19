<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
  require("../dbase/dbFunction.php");
  session_start();
  session_destroy();
  echo "<script type=text/javascript>window.location=\"/index.php\";</script>";
?>

