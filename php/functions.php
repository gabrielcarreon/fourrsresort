<?php
function convertToTextDate($input)
{
    if (is_null($input)) {
        return " ";
    } else {
        return date('M d, Y | h:i A', strtotime($input));
    }
}
function convertToMonth($input)
{
    if (is_null($input)) {
        return " ";
    } else {
        return date('M', strtotime($input));
    }
}

function convertAvailability($input)
{
    if ($input == 1) {
        return "Available";
    } else {
        return "Unavailable";
    }
}
