<?php
include 'includes/db.php';

function diff_in_time ($time)
{
	// The $time variable that is being passed is a 'since Unix Epoch' number that has been converted
	// from a string by the strtotime() function.  
	
	$diff_in_times = time() - $time; // to get the time since that moment
	
	// The number 31536000 is how many seconds are in a year
	// By dividing our $diff_in_times value by this number will give us a mixed number of the 
	// total number of years that have passed.
	// We use the floor function to round off the decimal
	$how_many_years = floor($diff_in_times / 31536000);
	return $how_many_years;
}

// **** No longer needed ****
//function expire_sermons ($expiration_date) {
//	$expiration_date = strtotime('13-05-01');
//	$today = time();
//	
//	if($today >= $expiration_date){
//		return true;
//	}else{
//		return false;
//	}
//}	

// **** No longer needed ****
// For undownloadable sermons on media page
//function bad_dates($x) {
//	$years = array('2012', '2011', '2010');
//	
//	if(in_array($x, $years)){ 
//		return true;
//	}
//}

// ruudrp at live dot nl
// http://us2.php.net/manual/en/function.get-browser.php
function getBrowser() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        if (preg_match('/iPhone/i', $u_agent)){
			$platform = 'iPhone';
		}
		else {
			$platform = 'mac';
		}
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
    
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    }
	elseif(preg_match('/Mozilla/5.0 (compatible; AhrefsBot/4.0; +http://ahrefs.com/robot/)/i',$u_agent))
	{
		$bname = 'reject';
		$ub = 'reject';
	}
    
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
    
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
    
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
    
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}
$ua=getBrowser();
?>