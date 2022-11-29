<?php

function tep_get_images_model_release_name($sText) {
	if($sText=='') return "No";
	if($sText=='0')	return "No";
	if($sText=='1')	return "Yes";
	if($sText=='2')	return "No";
}

function tep_get_images_property_release_name($sText) {
	if($sText=='') return "No";
	if($sText=='0')	return "No";
	if($sText=='1')	return "Yes";
	if($sText=='2')	return "No";
}

function tep_get_image_usage($image_usage) {
    if($image_usage=='1') return 'Magazine Advertising';
	else if($image_usage=='2') return 'Newspaper Advertising';	
	else if($image_usage=='3') return 'TV Commercial';
	else if($image_usage=='4') return 'Web Advertisement';
	else if($image_usage=='5') return 'Annual Report';
	else if($image_usage=='6') return 'Brochure/ Direct Mailer/ Marketing Collateral';	
	else if($image_usage=='7') return 'Promotional Calendar';
	else if($image_usage=='8') return 'Promotional Poster';
	else if($image_usage=='9') return 'Corporate Website';
	else if($image_usage=='10') return 'Newsletter';	
	else if($image_usage=='11') return 'Press Release';
	else if($image_usage=='12') return 'Wall Print';
	else if($image_usage=='13') return 'Electronic Display';
	else if($image_usage=='14') return 'Museum/ Gallery Exhibit';	
	else if($image_usage=='15') return 'Outdoor Display-Billboard';
	else if($image_usage=='16') return 'Outdoor Display/ Poster/ Transit';
	else if($image_usage=='17') return 'Point of Purchase/ Table Tent/ Counter Card';	
	else if($image_usage=='18') return 'Trade Show';
	else if($image_usage=='19') return 'All Marketing Multiple Usage';
	else if($image_usage=='20') return 'Computer Game/ CDROM Software';
	else if($image_usage=='21') return 'Retail Calendar';	
	else if($image_usage=='22') return 'Retail Postcard/ Greetingcard/ Holidaycard';
	else if($image_usage=='23') return 'Product Packaging';
	else if($image_usage=='24') return 'Others';
	else return 'None';
	}

function tep_get_image_size($size) {
	
    if($size=='1') return 'Up to 1/4 Page';
	else if($size=='2') return 'Up to 1/2 Page';	
	else if($size=='3') return 'Up to 3/4 Page';
	else if($size=='4') return 'Up to Full Page';
	else if($size=='5') return 'Up to Double Spread Page';
	else return 'None';
	}

function tep_get_image_circulation($circulation) {
    if($circulation=='1') return 'Up to 5';
	else if($circulation=='2') return 'Up to 10';	
	else if($circulation=='3') return 'Up to 50';
	else if($circulation=='4') return 'Up to 200';
	else if($circulation=='5') return 'Up to 500';
	else if($circulation=='6') return 'Up to 1000';	
	else if($circulation=='7') return 'Up to 2000';
	else if($circulation=='8') return 'Up to 5000';
	else if($circulation=='9') return 'Up to 10,000';
	else if($circulation=='10') return 'Up to 20,000';	
	else if($circulation=='21') return 'Up to 25,000';
	else if($circulation=='11') return 'Up to 50,000';
	else if($circulation=='12') return 'Up to 100,000';
	else if($circulation=='13') return 'Up to 250,000';
	else if($circulation=='14') return 'Up to 500,000';	
	else if($circulation=='15') return 'Up to 1,000,000';
	else if($circulation=='16') return 'More than 1,000,000';
	else if($circulation=='17') return 'More than 1000';	
	else if($circulation=='18') return 'More than 20,000';
	else if($circulation=='19') return 'Up to 5 Websites';
	else if($circulation=='20') return 'Up to 10 Websites';
	else return 'None';
	}
function tep_get_image_placement($placement) {
	
    if($placement=='1') return 'Cover';
	else if($placement=='2') return 'Inside';	
	else if($placement=='3') return 'Back Cover';
	else return 'None';
	}

function tep_get_image_duration($duration) {
    if($duration=='1') return '1 Day';
	else if($duration=='12') return '1 Week';
	else if($duration=='2') return 'Up to 1 Month';	
	else if($duration=='3') return 'Up to 3 Months';
	else if($duration=='4') return 'Up to 6 Months';
	else if($duration=='5') return 'Up to 1 Year';
	else if($duration=='6') return 'Up to 2 Years';	
	else if($duration=='7') return 'Up to 3 Years';
	else if($duration=='8') return 'Up to 4 Years';
	else if($duration=='9') return 'Up to 5 Years';
	else if($duration=='10') return 'Up to 6 Years';	
	else if($duration=='11') return 'Up to 7 Years';
	else return 'None';
	}
function tep_date_short($raw_date) {
    if ( ($raw_date == '0000-00-00 00:00:00') || ($raw_date == '') ) return false;
    $year = substr($raw_date, 0, 4);
    $month = (int)substr($raw_date, 5, 2);
    $day = (int)substr($raw_date, 8, 2);
    $hour = (int)substr($raw_date, 11, 2);
    $minute = (int)substr($raw_date, 14, 2);
    $second = (int)substr($raw_date, 17, 2);
    if (@date('Y', mktime($hour, $minute, $second, $month, $day, $year)) == $year) {
      return date(DATE_FORMAT, mktime($hour, $minute, $second, $month, $day, $year));
    } else {
      return ereg_replace('2037' . '$', $year, date(DATE_FORMAT, mktime($hour, $minute, $second, $month, $day, 2037)));
    }
  }
  function tep_get_sales_person($invoice_sales_person) {
    if ($invoice_sales_person == '1')
        return 'Farhaan';
    else if ($invoice_sales_person == '2')
        return 'Tikam';
    else if ($invoice_sales_person == '3')
        return 'Sanjiv';
    else if ($invoice_sales_person == '4')
        return 'Amit';
    else if ($invoice_sales_person == '5')
        return 'Harrish';
    else if ($invoice_sales_person == '6')
        return 'Celestina';
    else if ($invoice_sales_person == '7')
        return 'Avik';
    else if ($invoice_sales_person == '8')
        return 'Bhumika';
    else if ($invoice_sales_person == '9')
        return 'Satyen';
    else if ($invoice_sales_person == '10')
        return 'Arvin';
    else if ($invoice_sales_person == '11')
        return 'Sumeet';
    else if ($invoice_sales_person == '12')
        return 'Tarang';
    else if ($invoice_sales_person == '13')
        return 'Rajesh';
    else if ($invoice_sales_person == '14')
        return 'Manav';
    else if ($invoice_sales_person == '15')
        return 'Sourav';
    else if ($invoice_sales_person == '16')
        return 'Sadia';
    else if ($invoice_sales_person == '17')
        return 'Darshana';
    else if ($invoice_sales_person == '18')
        return 'Supreet';
    else if ($invoice_sales_person == '19')
        return 'Varun';
    else if ($invoice_sales_person == '20')
        return 'Avishek';
    else if ($invoice_sales_person == '21')
        return 'Deepti';
    else if ($invoice_sales_person == '22')
        return 'Puneet';
    else if ($invoice_sales_person == '23')
        return 'Pubarun';
    else if ($invoice_sales_person == '24')
        return 'Rahul';
    else if ($invoice_sales_person == '25')
        return 'Faisal';
    else if ($invoice_sales_person == '26')
        return 'Neeraj';
    else if ($invoice_sales_person == '27')
        return 'Alkash';
    else if ($invoice_sales_person == '28')
        return 'Amit Pradhan';
    else if ($invoice_sales_person == '29')
        return 'Vijeesh';
    else if ($invoice_sales_person == '30')
        return 'Geet';
    else if ($invoice_sales_person == '31')
        return 'Shadab Rana';
    else if ($invoice_sales_person == '32')
        return 'Arun';
    else if ($invoice_sales_person == '33')
        return 'Gaurav';
    else if ($invoice_sales_person == '34')
        return 'Kuvarpal Singh';
    else if ($invoice_sales_person == '35')
        return 'Abhishek Kumar';
    //else if($invoice_sales_person=='36') return 'Ateendra Tripathi';
    else if ($invoice_sales_person == '37')
        return 'Chander';
    else if ($invoice_sales_person == '39')
        return 'Babita Sharma';
    else if ($invoice_sales_person == '40')
        return 'Rahul Jaiswal';
}

function tep_get_sales_contactno_salesperson($invoice_sales_person) {
    if ($invoice_sales_person == '1')
        return 'Contact No- +91-9987082401';
    else if ($invoice_sales_person == '2')
        return 'Contact No- +91-9821193966';
    else if ($invoice_sales_person == '3')
        return 'Contact No- +91-9880883518';
    else if ($invoice_sales_person == '4')
        return 'Contact No- +91-8860016456';
    else if ($invoice_sales_person == '5')
        return 'Contact No- +91-9311112646';
    else if ($invoice_sales_person == '6')
        return 'Contact No- +91-9849410007';
    else if ($invoice_sales_person == '7')
        return 'Contact No- +91-9311112646';
    else if ($invoice_sales_person == '8')
        return 'Contact No- +91-9873721488';
    else if ($invoice_sales_person == '9')
        return 'Contact No- +91-9899198881';
    else if ($invoice_sales_person == '10')
        return 'Contact No- +91-9845382953';
    else if ($invoice_sales_person == '11')
        return 'Contact No- +91-9810830475';
    else if ($invoice_sales_person == '12')
        return 'Contact No- +91-9953471897';
    else if ($invoice_sales_person == '13')
    //@120720191752        return 'Contact No- +91-8882668800';
        return 'Contact No- +91-9871954443';
    else if ($invoice_sales_person == '14')
        return 'Contact No- +91-9987304930';
    else if ($invoice_sales_person == '15')
        return 'Contact No- +91-9899226253';
    else if ($invoice_sales_person == '16')
        return 'Contact No- +91-9899209159';
    else if ($invoice_sales_person == '17')
        return 'Contact No- +91-9899490969';
    else if ($invoice_sales_person == '18')
        return 'Contact No- +91-9810303177';
    else if ($invoice_sales_person == '19')
        return 'Contact No- +91-9930945707';
    else if ($invoice_sales_person == '20')
        return 'Contact No- +91-9967199686';
    else if ($invoice_sales_person == '21')
        return 'Contact No- +91-9312921598';
    else if ($invoice_sales_person == '22')
        return 'Contact No- +91-9004175599';
    else if ($invoice_sales_person == '23')
        return 'Contact No- +91-9873203739';
    else if ($invoice_sales_person == '24')
    //@120720191752        return 'Contact No- +91-8882668800';
        return 'Contact No- +91-9911082058';
    else if ($invoice_sales_person == '25')
        return 'Contact No- +91-9833446696';
    else if ($invoice_sales_person == '26')
        return 'Contact No- +91-9911217808';
    else if ($invoice_sales_person == '27')
        return 'Contact No- +91-9833459093';
    else if ($invoice_sales_person == '28')
        return 'Contact No- +91-8425908555';
    else if ($invoice_sales_person == '29')
        return 'Contact No- +91-9900713424';
    else if ($invoice_sales_person == '30')
        return 'Contact No- +91-8879745889';
    else if ($invoice_sales_person == '31')
        return 'Contact No- +91-9953046535';
    else if ($invoice_sales_person == '32')
        return 'Contact No- +91-9910166555';
    else if ($invoice_sales_person == '33')
        return 'Contact No- +91-9871913105';
    else if ($invoice_sales_person == '34')
        return 'Contact No- +91-8587991079';
    else if ($invoice_sales_person == '35')
        return 'Contact No- +91-8879419353';
    else if ($invoice_sales_person == '37')
        return 'Contact No- +91-9871826312';
    else if ($invoice_sales_person == '39')
        return 'Contact No- +91-9599648838';
    else if ($invoice_sales_person == '40')
        return 'Contact No- +91-8448997285';
}
function tep_get_sales_email_salesperson($invoice_sales_person) {
    if ($invoice_sales_person == '1')
        return 'farhaan@indiapicture.in';
    else if ($invoice_sales_person == '2')
        return 'tikam@indiapicture.in';
    else if ($invoice_sales_person == '3')
        return 'sanjiv@indiapicture.in';
    else if ($invoice_sales_person == '4')
        return 'amit@indiapicture.in';
    else if ($invoice_sales_person == '5')
        return 'harrish@indiapicture.in';
    else if ($invoice_sales_person == '6')
        return 'celestina@indiapicture.in';
    else if ($invoice_sales_person == '7')
        return 'avik@indiapicture.in';
    else if ($invoice_sales_person == '8')
        return 'bhumika@indiapicture.in';
    else if ($invoice_sales_person == '9')
        return 'satyen@indiapicture.in';
    else if ($invoice_sales_person == '10')
        return 'arvin@indiapicture.in';
    else if ($invoice_sales_person == '11')
        return 'sumeet@indiapicture.in';
    else if ($invoice_sales_person == '12')
        return 'tarang@indiapicture.in';
    else if ($invoice_sales_person == '13')
        return 'rajesh@indiapicture.in';
    else if ($invoice_sales_person == '14')
        return 'manav@indiapicture.in';
    else if ($invoice_sales_person == '15')
        return 'sourav@indiapicture.in';
    else if ($invoice_sales_person == '16')
        return 'sadia@indiapicture.in';
    else if ($invoice_sales_person == '17')
        return 'darshana@indiapicture.in';
    else if ($invoice_sales_person == '18')
        return 'supreet@indiapicture.in';
    else if ($invoice_sales_person == '19')
        return 'varun@indiapicture.in';
    else if ($invoice_sales_person == '20')
        return 'avishek@indiapicture.in';
    else if ($invoice_sales_person == '21')
        return 'deepti@indiapicture.in';
    else if ($invoice_sales_person == '22')
        return 'puneet@indiapicture.in';
    else if ($invoice_sales_person == '23')
        return 'pubarun@indiapicture.in';
    else if ($invoice_sales_person == '24')
        return 'rahul@indiapicture.in';
    else if ($invoice_sales_person == '25')
        return 'faisal@indiapicture.in';
    else if ($invoice_sales_person == '26')
        return 'neeraj@indiapicture.in';
    else if ($invoice_sales_person == '27')
        return 'alkash.memon@mahattamultimedia.com';
    else if ($invoice_sales_person == '28')
        return 'amit.pradhan@mahattamultimedia.com';
    else if ($invoice_sales_person == '29')
        return 'vijeesh@mahattamultimedia.com';
    else if ($invoice_sales_person == '30')
        return 'geet.lambhate@mahattamultimedia.com';
    else if ($invoice_sales_person == '31')
        return 'shadab.rana@mahattamultimedia.com';
    else if ($invoice_sales_person == '32')
        return 'arun@indiapicture.in';
    else if ($invoice_sales_person == '33')
        return 'gaurav@indiapicture.in';
    else if ($invoice_sales_person == '34')
        return 'kuvarpal@indiapicture.in';
    else if ($invoice_sales_person == '35')
        return 'abhishek@mahattamultimedia.com';
    else if ($invoice_sales_person == '37')
        return 'chander@indiapicture.in';
    else if ($invoice_sales_person == '39')
        return 'marketing@indiapicture.in';
    else if ($invoice_sales_person == '40')
        return 'rahul.jaiswal@indiapicture.in ';
}

function tep_get_client_service($invoice_client_service) {
    if ($invoice_client_service == '1')
        return 'Deepti';
    else if ($invoice_client_service == '2')
        return 'Celestina';
    else if ($invoice_client_service == '3')
        return 'Shilpi';
    else if ($invoice_client_service == '4')
        return 'Amit';
    else if ($invoice_client_service == '5')
        return 'Avishek';
    else if ($invoice_client_service == '6')
        return 'Sumeet';
    else if ($invoice_client_service == '7')
        return 'Rajesh';
    else if ($invoice_client_service == '8')
        return 'Darshana';
    else if ($invoice_client_service == '9')
        return 'Sadia';
    else if ($invoice_client_service == '10')
        return 'Rahul';
    else if ($invoice_client_service == '11')
        return 'Manav';
    else if ($invoice_client_service == '12')
        return 'Plabita';
    else if ($invoice_client_service == '13')
        return 'Varun';
    else if ($invoice_client_service == '14')
        return 'Pubarun';
    else if ($invoice_client_service == '15')
        return 'Sanjivani';
    else if ($invoice_client_service == '16')
        return 'Puneet';
    else if ($invoice_client_service == '17')
        return 'Ruchi';
    else if ($invoice_client_service == '18')
        return 'Prachi';
    else if ($invoice_client_service == '19')
        return 'Shivanjana';
    else if ($invoice_client_service == '20')
        return 'Nisha';
    else if ($invoice_client_service == '21')
        return 'Pooja';
    else if ($invoice_client_service == '22')
        return 'Ashwini';
    else if ($invoice_client_service == '23')
        return 'Daljeet';
    else if ($invoice_client_service == '24')
        return 'Renuka';
    else if ($invoice_client_service == '25')
        return 'Faisal';
    else if ($invoice_client_service == '26')
        return 'Neeraj';
    else if ($invoice_client_service == '27')
        return 'Aditya';
    else if ($invoice_client_service == '28')
        return 'Mehnaz';
    else if ($invoice_client_service == '29')
        return 'Ajit';
    else if ($invoice_client_service == '30')
        return 'Jaskaran';
    else if ($invoice_client_service == '31')
        return 'Chander';
    else if ($invoice_client_service == '32')
        return 'Arun';
    else if ($invoice_client_service == '33')
        return 'Shadab';
    else if ($invoice_client_service == '34')
        return 'Kuvarpal singh';
    else if ($invoice_client_service == '35')
        return 'Alkash';
    else if ($invoice_client_service == '36')
        return 'Gaurav';
    else if ($invoice_client_service == '37')
        return 'Fizza Khan';
    else if ($invoice_client_service == '38')
        return 'Ateendra Tripathi';
    else if ($invoice_client_service == '40')
        return 'Vaishali';
    else if ($invoice_client_service == '41')
        return 'Monica';
    else if ($invoice_client_service == '42')
//        return 'Shikha Shilpi';//@151120191548//now update
        return 'Pankhuri';
    else if ($invoice_client_service == '43')
        return 'Rahul Jaiswal';
    else if ($invoice_client_service == '44')
        return 'Rama Rao';
    else if ($invoice_client_service == '45')
        return 'Geetanshul';
    else if ($invoice_client_service == '46')
        return 'Neha Sharma';
    
}

function tep_get_contactno_client_service($invoice_client_service) {
    if ($invoice_client_service == '1')
        return 'Contact No- +91-9312921598';
    else if ($invoice_client_service == '2')
        return 'Contact No- +91-9849410007';
    else if ($invoice_client_service == '3')
        return 'Contact No- +91-9971140634';
    else if ($invoice_client_service == '4')
        return 'Contact No- +91-8860016456';
    else if ($invoice_client_service == '5')
        return 'Contact No- +91-9967199686';
    else if ($invoice_client_service == '6')
        return 'Contact No- +91-9810830475';
    else if ($invoice_client_service == '7')
        return 'Contact No- +91-9718222336';
    else if ($invoice_client_service == '8')
        return 'Contact No- +91-9899490969';
    else if ($invoice_client_service == '9')
        return 'Contact No- +91-9899209159';
    else if ($invoice_client_service == '10')
    //@120720191752        return 'Contact No- +91-8882668800';
        return 'Contact No- +91-9871954443';
    else if ($invoice_client_service == '11')
        return 'Contact No- +91-9987304930';
    else if ($invoice_client_service == '12')
        return 'Contact No- +91-9911716084';
    else if ($invoice_client_service == '13')
        return 'Contact No- +91-9930945707';
    else if ($invoice_client_service == '14')
        return 'Contact No- +91-9873203739';
    else if ($invoice_client_service == '15')
        return 'Contact No- +91-9870540516';
    else if ($invoice_client_service == '16')
        return 'Contact No- +91-9004175599';
    else if ($invoice_client_service == '17')
        return 'Contact No- +91-9820869234';
    else if ($invoice_client_service == '18')
        return 'Contact No- +91-9820276974';
    else if ($invoice_client_service == '19')
        return 'Contact No- +91-9833247079';
    else if ($invoice_client_service == '20')
        return 'Contact No- +91-9833934687';
    else if ($invoice_client_service == '21')
        return 'Contact No- +91-9999979247';
    else if ($invoice_client_service == '22')
        return 'Contact No- +91-9821785369';
    else if ($invoice_client_service == '23')
        return 'Contact No- +91-9910346827';
    else if ($invoice_client_service == '24')
        return 'Contact No- +91-9650626016';
    else if ($invoice_client_service == '25')
        return 'Contact No- +91-9833446696';
    else if ($invoice_client_service == '26')
        return 'Contact No- +91-9911217808';
    else if ($invoice_client_service == '27')
        return 'Contact No- +91-9654891386';
    else if ($invoice_client_service == '28')
        return 'Contact No- +91-9312770464';
    else if ($invoice_client_service == '29')
        return 'Contact No- +91-7503481810';
    else if ($invoice_client_service == '30')
        return 'Contact No- +91-8800624288';
    else if ($invoice_client_service == '31')
        return 'Contact No- +91-9871826312';
    else if ($invoice_client_service == '32')
        return 'Contact No- +91-9910166555';
    else if ($invoice_client_service == '33')
        return 'Contact No- +91-9953046535';
    else if ($invoice_client_service == '34')
        return 'Contact No- +91-8587991079';
    else if ($invoice_client_service == '35')
        return 'Contact No- +91-9833459093';
    else if ($invoice_client_service == '36')
        return 'Contact No- +91-9871913105';
    else if ($invoice_client_service == '38')
        return 'Contact No- +91-9650836441';
    else if ($invoice_client_service == '40')
        return 'Contact No- +91-8810463908';
    else if ($invoice_client_service == '42')
//        return 'Contact No- +91-8448997282';//@151120191548//now update
        return 'Contact No- +91-8448997282';
    else if ($invoice_client_service == '43')
    //@120720191752        return 'Contact No- +91-8882668800';
        return 'Contact No- +91-8448997285';
    else if ($invoice_client_service == '44')
        return 'Contact No- +91-0000000000';
    else if ($invoice_client_service == '45')
        return 'Contact No- +91-8448539407';
    else if ($invoice_client_service == '46')
        return 'Contact No- +91-9599801592';
    
}

function tep_get_client_service_email($invoice_client_service) {
    if ($invoice_client_service == '1')
        return 'deepti@indiapicture.in';
    else if ($invoice_client_service == '2')
        return 'celestina@indiapicture.in';
    else if ($invoice_client_service == '3')
        return 'smiti@indiapicture.in';
    else if ($invoice_client_service == '4')
        return 'amit@indiapicture.in';
    else if ($invoice_client_service == '5')
        return 'avishek@indiapicture.in';
    else if ($invoice_client_service == '6')
        return 'sumeet@indiapicture.in';
    else if ($invoice_client_service == '7')
        return 'rajesh@indiapicture.in';
    else if ($invoice_client_service == '8')
        return 'darshana@indiapicture.in';
    else if ($invoice_client_service == '9')
        return 'sadia@indiapicture.in';
    else if ($invoice_client_service == '10')
        return 'rahul@indiapicture.in';
    else if ($invoice_client_service == '11')
        return 'manav@indiapicture.in';
    else if ($invoice_client_service == '12')
        return 'plabita@indiapicture.in';
    else if ($invoice_client_service == '13')
        return 'varun@indiapicture.in';
    else if ($invoice_client_service == '14')
        return 'pubarun@indiapicture.in';
    else if ($invoice_client_service == '15')
        return 'sanjivani@indiapicture.in';
    else if ($invoice_client_service == '16')
        return 'puneet@indiapicture.in';
    else if ($invoice_client_service == '17')
        return 'ruchi@indiapicture.in';
    else if ($invoice_client_service == '18')
        return 'prachi@indiapicture.in';
    else if ($invoice_client_service == '19')
        return 'hivanjana@indiapicture.in';
    else if ($invoice_client_service == '20')
        return 'nisha@indiapicture.in';
    else if ($invoice_client_service == '21')
        return 'pooja@indiapicture.in';
    else if ($invoice_client_service == '22')
        return 'ashwini@indiapicture.in';
    else if ($invoice_client_service == '23')
        return 'daljeet@indiapicture.in';
    else if ($invoice_client_service == '24')
        return 'renuka@indiapicture.in';
    else if ($invoice_client_service == '25')
        return 'faisal@indiapicture.in';
    else if ($invoice_client_service == '26')
        return 'neeraj@indiapicture.in';
    else if ($invoice_client_service == '27')
        return 'aditya@indiapicture.in';
    else if ($invoice_client_service == '28')
        return 'mehnaz@indiapicture.in';
    else if ($invoice_client_service == '29')
        return 'ajit@mahattamultimedia.com';
    else if ($invoice_client_service == '30')
        return 'jaskaran@indiapicture.in';
    else if ($invoice_client_service == '31')
        return 'chander@indiapicture.in';
    else if ($invoice_client_service == '32')
        return 'arun@indiapicture.in';
    else if ($invoice_client_service == '33')
        return 'shadab.rana@mahattamultimedia.com';
    else if ($invoice_client_service == '34')
        return 'kuvarpal@indiapicture.in';
    else if ($invoice_client_service == '35')
        return 'alkash.memon@mahattamultimedia.com';
    else if ($invoice_client_service == '36')
        return 'gaurav@indiapicture.in';
    else if ($invoice_client_service == '37')
        return 'fizza.khan@mahattamultimedia.com';
    else if ($invoice_client_service == '38')
        return 'editorial@indiapicture.in';
    else if ($invoice_client_service == '40')
        return 'vaishali@indiapicture.in';
    else if ($invoice_client_service == '41')
        return 'teamsouth@indiapicture.in';
    else if ($invoice_client_service == '42')
//        return 'shikha@indiapiture.in';//@151120191548//now update
        return 'editorial@indiapicture.in';
    else if ($invoice_client_service == '43')
        return 'rahul.jaiswal@indiapicture.in';
    else if ($invoice_client_service == '44')
        return 'ramarao@indiapicture.in';
    else if ($invoice_client_service == '45')
        return 'care@indiapicture.in';
    else if ($invoice_client_service == '46')
        return 'info@indiapicturebudget.com';
    
}

function tep_get_invoice_type($invoice_type_id) {
    if($invoice_type_id=='1') return 'Invoice';
    else if($invoice_type_id=='2') return 'Proforma Invoice';   
    else return 'Quotation';
  }
?>