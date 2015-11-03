<?php
namespace App\Utilities;

class Utility  
{
function div($a,$b) {
    return (int) ($a / $b);
}	
	function gregorian_to_jalali ($g_y, $g_m, $g_d) 
	{
		$g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); 
		$j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);     
	   $gy = $g_y-1600; 
	   $gm = $g_m-1; 
	   $gd = $g_d-1; 
	
	   $g_day_no = 365*$gy+$this->div($gy+3,4)-$this->div($gy+99,100)+$this->div($gy+399,400); 
	
	   for ($i=0; $i < $gm; ++$i) 
		  $g_day_no += $g_days_in_month[$i]; 
	   if ($gm>1 && (($gy%4==0 && $gy%100!=0) || ($gy%400==0))) 
		  /* leap and after Feb */ 
		  $g_day_no++; 
	   $g_day_no += $gd; 
	
	   $j_day_no = $g_day_no-79; 
	
	   $j_np = $this->div($j_day_no, 12053); /* 12053 = 365*33 + 32/4 */ 
	   $j_day_no = $j_day_no % 12053; 
	
	   $jy = 979+33*$j_np+4*$this->div($j_day_no,1461); /* 1461 = 365*4 + 4/4 */ 
	
	   $j_day_no %= 1461; 
	
	   if ($j_day_no >= 366) { 
		  $jy += $this->div($j_day_no-1, 365); 
		  $j_day_no = ($j_day_no-1)%365; 
	   } 
	
	   for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i) 
		  $j_day_no -= $j_days_in_month[$i]; 
	   $jm = $i+1; 
	   $jd = $j_day_no+1; 
	
	   return array($jy, $jm, $jd); 
	} 
	
	function jalali_to_gregorian($j_y, $j_m, $j_d) 
	{ 
		$g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); 
		$j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);
	   $jy = $j_y-979; 
	   $jm = $j_m-1; 
	   $jd = $j_d-1; 
	
	   $j_day_no = 365*$jy + $this->div($jy, 33)*8 + $this->div($jy%33+3, 4); 
	   for ($i=0; $i < $jm; ++$i) 
		  $j_day_no += $j_days_in_month[$i]; 
	
	   $j_day_no += $jd; 
	
	   $g_day_no = $j_day_no+79; 
	
	   $gy = 1600 + 400*$this->div($g_day_no, 146097); /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */ 
	   $g_day_no = $g_day_no % 146097; 
	
	   $leap = true; 
	   if ($g_day_no >= 36525) /* 36525 = 365*100 + 100/4 */ 
	   { 
		  $g_day_no--; 
		  $gy += 100*$this->div($g_day_no,  36524); /* 36524 = 365*100 + 100/4 - 100/100 */ 
		  $g_day_no = $g_day_no % 36524; 
	
		  if ($g_day_no >= 365) 
			 $g_day_no++; 
		  else 
			 $leap = false; 
	   } 
	
	   $gy += 4*$this->div($g_day_no, 1461); /* 1461 = 365*4 + 4/4 */ 
	   $g_day_no %= 1461; 
	
	   if ($g_day_no >= 366) { 
		  $leap = false; 
	
		  $g_day_no--; 
		  $gy += $this->div($g_day_no, 365); 
		  $g_day_no = $g_day_no % 365; 
	   } 
	
	   for ($i = 0; $g_day_no >= $g_days_in_month[$i] + ($i == 1 && $leap); $i++) 
		  $g_day_no -= $g_days_in_month[$i] + ($i == 1 && $leap); 
	   $gm = $i+1; 
	   $gd = $g_day_no+1; 
	
	   return array($gy, $gm, $gd); 
	}

	function isKabise($year)
	{
	if($year < 473)
	{
		$k_hesabi = array(0,4,8,12,16,20,25,29,33,38,41,45,49,53,58,62,66,70,74,78,82,86,91,95,99,103,107,111,115,120,124);
	}else
	{
		$k_hesabi = array(0,4,8,12,16,20,24,29,33,38,41,45,49,53,57,62,66,70,74,78,82,86,90,95,99,103,107,111,115,119,124);
	}
	$kabi_plus = array(1275,1308,1341,1403,1436,1469,1473,1502);
	
	$kabi_minus = array(9,13,17,21,42,46,50,54,71,75,79,83,87,104,108,112,116,137,141,145,149,170,174,178,182,203,207,211,215,236,240,244,269,273,277,302,306,310,331,335,339,343,364,368,372,397,401,405,430,434,438,463,467,471,475,496,500,504,529,533,537,558,862,566,570,591,595,599,603,624,628,632,661,665,690,694,698,723,727,731,756,760,789,793,822,826,855,859,888,921,954,983,987,1014,1049,1082,1115,1243);
	
	foreach($kabi_minus as $value)
	{
		if($year == $value)
		{
			return 1 ;
		}
	}
	
	foreach($kabi_minus as $value)
	{
		$minus = $value - 1 ;
	
		if($year == $minus)
		{
			return 0;
		} 
	}
	
	foreach ($kabi_plus as $value) {
		
		if($year == $value)
		{
			return 1;
		}
	
	}
	
	foreach ($kabi_plus as $value) {
		
		$plus = $value + 1;
	
		if($year == $plus)
		{
			return 0;
		}
	
	
	}
	
	
	$baqimande = $year % 128;
	
	foreach ($k_hesabi as $val) {
		
		if($baqimande == $val)
		{
			return 1;
		}
	
	}
	
	return 0;
	
	}
	
	function nextKabise($year)
	{
		$year = $year + 1;
		$till = $year + 10;
	
		for($year;$year<=$till;$year++)
		{
			if($this->isKabise($year))
				return $year;
		}
	
	}
  function get_jalali_date( $gdate='now' )
   {
    if ( $gdate == 'now' ) 
     {
       list($gyear, $gmonth, $gday ) = preg_split ('/-/', date("Y-m-d"));
	   $dayofweek =date('w');
     }//end if
    else
     {
       	list( $gyear, $gmonth, $gday ) = preg_split('/-/',$gdate);
     }//end else
      list( $jyear, $jmonth, $jday ) = $this->gregorian_to_jalali($gyear, $gmonth, $gday);
	  $jyear= $jyear % 100;
	  if ($jday<10) $jday = "0".$jday;
	  if ($jmonth<10) $jmonth = "0".$jmonth;
	  $jtime=date("G:i:s", strtotime($gdate));  
	  
	  return compact( 'jyear','jmonth','jday','jtime');
   }//end function//echo get_jalali_date();	
}
?>
