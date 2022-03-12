<?php
namespace NewsAggregator\helpers;
/**
 * @return bool
 */
function validateUserSession()
{
  return (!isset($_SESSION["username"]) && !isset($_SESSION["userID"])) ? FALSE : TRUE;
}
?>