<?php
namespace NewsAggregator\helpers;

/**
 * @return bool
*/
function check_session_status()
{
  return session_id() === '' ? FALSE : TRUE;
}