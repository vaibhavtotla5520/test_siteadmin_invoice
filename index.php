<?php
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);
// include autoloader



require_once 'autoload.inc.php';
require_once 'all_func.php';

require_once 'database.php';


// import dompdf class into global namespace
use Dompdf\Dompdf;


// instantiate dompdf class
$dompdf = new Dompdf();

$dompdf->getOptions()->getChroot();

$disp_quotation = json_decode($_GET['disp_quotation'], true);


$invoice_id = $_GET['invoice_id'];
$financial_year = $_GET['financial_year'];
$InvDate = $_GET['InvDate'];
$po_date = $_GET['po_date'];
$contact_person = $_GET['contact_person'];
$invoice_due_date = $_GET['invoice_due_date'];
$condition = $_GET['condition'];
$date_in = $_GET['date_in'];
$current_in = $_GET['current_in'];


$tbl_client_detail_name = $_GET['tbl_client_detail_name'];

$tbl_client_detail_name_email = $_GET['tbl_client_detail_name_email'];

//====================================//
//Class and database
$invoice = new invoice;
$connect = $invoice->connectivity();
//====================================//

//=============QR CODE=============//
$QR=$invoice->invoiceQrCode($financial_year,$connect);
$qrCode=$QR['signedQRCode'];
$irn=$QR['irn'];
//===============================//


//====================================//
if($invoice_id==''){
    $order = $invoice->invoiceNot();
}else{
    $order = $invoice->invoiceData($invoice_id,$financial_year,$connect);
}
$customers_id=$order['customer']['invoice_customers_id'];

$invoice_sales_person_contact=tep_get_sales_contactno_salesperson($order['customer']['invoice_sales_person']);
$invoice_sales_person=tep_get_sales_person($order['customer']['invoice_sales_person']);
$invoice_sales_person_email=tep_get_sales_email_salesperson($order['customer']['invoice_sales_person']);

$invoice_client_service_name=tep_get_client_service($order['customer']['invoice_client_service']);
$invoice_client_service_contact=tep_get_contactno_client_service($order['customer']['invoice_client_service']);
$invoice_client_service_email=tep_get_client_service_email($order['customer']['invoice_client_service']);


if($order['customer']['invoice_customers_name'])
	$ClientName=$order['customer']['invoice_customers_name'];
else
    $ClientName='';
if($order['customer']['invoice_customers_address_line1'])
	$ClientAddress=$order['customer']['invoice_customers_address_line1'];
else
    $ClientAddress='';
if($order['customer']['invoice_customers_address_line2'])
	$ClientAddress.=$order['customer']['invoice_customers_address_line2'];
if($order['customer']['invoice_customers_city'])
	$ClientCity=$order['customer']['invoice_customers_city'];
else
    $ClientCity='';
if($order['customer']['invoice_customers_state'])
	$ClientState= $order['customer']['invoice_customers_state'];
else
    $ClientState='';
if($order['customer']['invoice_customers_postcode'])
	$ClientPostcode=$order['customer']['invoice_customers_postcode'];
else
    $ClientPostcode='';
if($order['customer']['invoice_customers_country'])
	$ClientCountry=$order['customer']['invoice_customers_country'];
else
    $ClientCountry='';
if($order['customer']['invoice_customers_telephone'])
	$ClientTelephone=$order['customer']['invoice_customers_telephone'];
else
    $ClientTelephone='';
if($order['customer']['invoice_customers_email_address'])
	$ClientEmail=$order['customer']['invoice_customers_email_address'];
else
    $ClientEmail='';
if($order['customer']['po_number'])
	$ClientPoNumber=$order['customer']['po_number'];
else
    $ClientPoNumber='';
if($order['customer']['invoice_customers_company'])
    $ClientCompany=$order['customer']['invoice_customers_company'];
else
    $ClientCompany='';
if($condition='')
	$condition = '';
if($order['customer']['invoice_jobno'])
        $ClientJobNumber=$order['customer']['invoice_jobno'];
else
    $ClientJobNumber='';

//====================================//


if($order['info']['invoice_id_vat']!=0)
{
	$inv_type = 2; //vat
}
else
{
	$inv_type = 1; //Sarvice Tax
}


$inv_type;
$cst = $_GET['cst'];
$msme_uam_no='DL08E0023359';/*@300420201804*/


//====================================//

$html = <<<HTML

<!DOCTYPE html>
<html lang="en">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahatta Multimedia Tax Invoice</title>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="top_bar_parent" >
        <div class="top_bar"></div>
    </div>

        <div id="container">
            <!-- <header> -->
            <div id="navbar-brand" style="padding-left:30px;"><img src="images/logo_mahatta_multimedia.png" height="50" alt="Invoice">
                <div class="social_icon" style="padding-right:30px;">
                    <ul>
                        <li><img src="images/telephone.png" alt="telephone" width="20px"></li>
                        <li style="color:#ababaf; font-size:medium;">+91 11 41470000</li>
                    </ul>
                    <ul>
                        <li><img src="images/mail.png" alt="telephone" width="20px"></li>
                        <li style="color:#ababaf;font-size:medium;">info@indipicture.in</li>
                    </ul>
                    <ul>
                        <li><img src="images/Internet.png" alt="telephone" width="20px"></li>
                        <li style="color:#ababaf;font-size:medium;">www.indiapicture.in</li>
                    </ul>
                </div>
            </div>

            <!-------end----- <header> -->
                
            <!-----------Tax Invoice -->
                
                <div class="tx_inv">
                    <div class="tax_invoice">
                        <h3 style="padding-top: 42px;" align="center">TAX INVOICE</h3>
                    </div>
                </div>

            
            <!-- --------------------ORIGINAL FOR RECIPIENT----------------------->
            
            <div style="font-weight: bold;padding-top: 20px; padding-left: 95px;">
                <h4>ORIGINAL FOR RECIPIENT</h4>
            </div>

            <div style="width: 800px; height: 365px;padding-left: 95px;">
                <table border="1" cellspacing="0">

                    <tbody>
                        <tr>
                            <td style="font-weight: bold;font-size:large; padding: 1px;" align="right">Invoice No:</td>
                            <td style="padding: 1px;">$financial_year</td>
                            <td></td>
                        </tr>

                        <tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">Invoice Date:</td>
                            <td style="padding: 1px;">$InvDate</td>
                            <td align="left"><span  style="font-weight: bold; padding: 1px;">Job no:</span>$ClientJobNumber</td>
                        </tr>
HTML;

if($ClientPoNumber!=''){
                        
$html.= <<<HTML

                        <tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">
                                PO Number:
                            </td>
                            <td style="padding: 1px;">
                                $ClientPoNumber
                            </td>
                            <td style="font-weight: bold; padding: 1px;" >
                                PO Date:
HTML;
if($order['customer']['po_date']!='0000-00-00'){
$html.= <<<HTML
$po_date
HTML;
}                                
$html.= <<<HTML
							</td>                        
                        </tr>
HTML;
}                       
$html.= <<<HTML
                        <tr>
                            <td style="font-weight: bold; padding: 1px; width: 130px;" align="right">
                                GSTIN:
                            </td>
                            <td style="font-weight: bold; padding: 1px;">
                                07AAECM4064D1ZQ
                            </td>
                            <td style="padding: 1px;">
                                PAN No. Is: AAECM4064D
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">
                                HSN / SAC:
                            </td>
HTML;

$tbl_invoice_tax_type=$order['info']['tbl_invoice_tax_type'];
$invoice_region=$order['info']['invoice_region'];  
                           
if(($invoice_region==18 && $tbl_invoice_tax_type==1) || ($invoice_region==18 && $tbl_invoice_tax_type==2)){
    $hsn_sac_no="49119100";
}else if(($invoice_region==18 && $tbl_invoice_tax_type==11) || ($invoice_region==18 && $tbl_invoice_tax_type==22)){
    $hsn_sac_no="39203090";
}else{
    $hsn_sac_no="997339";
}
$html.= <<<HTML

                            <td style="font-weight: bold; padding: 1px;">
HTML;
$html.= <<<HTML
                                $hsn_sac_no

                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">
                                Description of Service :
                            </td>
                            <td style="font-weight: bold; padding: 1px;">
                                Licensing services for the right to use<br>
                                other intellectual property products and<br>
                                other resources N.E.C.

                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">
                                MSME UAM No. :
                            </td>
                            <td style="font-weight: bold; padding: 1px;">
                                 $msme_uam_no

                            </td>
                            <td>
                     
                </td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td style="font-weight: bold; background-color:#c4c4c6;  padding: 1px;">
                                CUSTOMER DETAILS

                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">
                                Customer GST No. :
                            </td>
HTML;

$cus_gst_no=$order['info']['customer_gstno'];
$firs_two=substr($cus_gst_no,2,-3);
if($order['info']['customer_gstno']){
   $cus_gst_no= $order['info']['customer_gstno'];
}
else{
    $cus_gst_no= "Not Register";
}
$html.= <<<HTML

                            <td style="padding: 1px;">
                                $cus_gst_no

                            </td>
                            <td align="left" style="padding: 1px;">
                                PAN NO: $firs_two
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">
                                Place of Supply :
                            </td>
                            <td style="padding: 1px;">:
HTML;

if($ClientState=='International-State'){

$html.= <<<HTML

$ClientCountry

HTML;

}else{ 

$html.= <<<HTML

$ClientState
HTML;

}


$html.= <<<HTML
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">
                                Company Name :
                            </td>
                            <td style="padding: 1px;">
                             $ClientCompany
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">
                                Contact Person :
                            </td>
                            <td style="padding: 1px;">
                            $contact_person
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; height: 100px; padding: 1px;" align="right">
                                Address :
                            </td>
                            <td style="padding: 1px;">
                                 
 $ClientAddress $ClientCity-$ClientPostcode,

HTML;

if($ClientState=='International-State'){

$html.= <<<HTML
$ClientState
HTML;
}else{ 

$html.= <<<HTML
$ClientCountry
HTML;
}
$html.= <<<HTML
 , $ClientCountry
                            </td>
                            <td>

                            </td>
                        </tr>
HTML;
if ($tbl_invoice_tax_type != 20){
$html.= <<<HTML
                <tr>
                <td style="font-weight: bold; padding: 1px;" align="right">
                    State
                </td>
                <td style="padding: 1px;"> 
                :$ClientState
                </td>
                <td></td>
                </tr>
HTML;
}
$html.= <<<HTML
                        <tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">
                                Contact Details:
                            </td>
                            <td style="padding: 1px;">
                                $tbl_client_detail_name, $tbl_client_detail_name_email
                            </td>
                            <td>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- --------------end----------ORIGINAL FOR RECIPIENT----------------------- -->
HTML;
if($irn){
$html.= <<<HTML
             
<div style="padding: 150px 95px; position:absolute;"><strong>IRN : </strong>$irn</div>   

            <!-- ----------------------- Transaction----------------------- -->
HTML;
}

if($order['info']['invoice_date'] <= '2009-04-01')
{
    if($order['info']['tbl_invoice_tax_type']!=1){

$html.= <<<HTML
                <br><br><br><br><br><br><br><br><br><br><br><br><br>
               <div style="padding-left: 95px;">
                   <strong>TIN NO - 07920353725 and PAN No. Is : AAECM4064D</strong>
               </div>
               <br><br>
HTML;
} else{
$html.= <<<HTML
                <br><br><br><br><br><br><br><br><br><br><br><br>
                <div style="padding-left: 95px;">
                   <strong> 
                        WE REQUEST YOU NOT TO DEDUCT TAX AT SOURCE AS WE HAVE REQUISITE CERTIFICATE 
                        UNDER SECTION<br />
                        197 OF THE INCOME TAX ACT, 1961. <br>
                        OUR PAN - AAECM4064D<!--SERVICE TAX REGISTRATION NO - AAECM4064DST001 -->
                        <br>
                        <!--<li>Service Tax Category - Photography Services </li>-->
                    </strong>

HTML;
}} else{
        if($order['info']['tbl_invoice_tax_type']!=1){
$html.= <<<HTML
                <br><br><br><br><br><br><br><br><br><br><br><br>
                   <h4 style="padding-left: 95px;">TAX PAID ON REVERSE CHARGES: NO </h4><br>
HTML;
}else{
$html.= <<<HTML
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
HTML;    
}
}
$html.= <<<HTML

HTML;
if($order['info']['tbl_invoice_tax_type']==1){
$html.= <<<HTML
HTML;
}
$html.= <<<HTML

                    <h4 style="padding-left: 95px;"><span style="background-color:#c4c4c6">* Payment Terms: -  $ClientCompany agrees to make the payment by
                           $invoice_due_date.</span> </h4>

HTML;
if ($ClientCountry !='india' || $ClientCountry !='India' || $ClientCountry !='INDIA'){
    if ($order['info']['tbl_invoice_tax_type']=='20'){
$html.= <<<HTML
                    <B style="padding-left: 95px;">* NOTE : - SUPPLY MEANT FOR EXPORT UNDER LUT WITHOUT PAYMENT OF IGST </B>
                    </div>

<!--------------------------------------END MESSAGES UNDER LAWS----------------------------------------------------------------->


HTML;
}}
$html.= <<<HTML

<!-- ---------------------foooter---------------------- -->
               <div style=" position: absolute; padding-top: 100px;"><img src="images/footer_bar.png" width="100%" height="1px" alt="bottom_Line"></div>
                   <div style="padding: 0px 0px 0px 50px; position: absolute; padding-top:105px;">
                       <table>
                           <tbody>
                               <tr>
                                   <td>
                                       <div>
                                           <h3 style="color: #4b110b;text-align: center;">Mahatta
                                               Multimedia,<br> Pvt. Ltd.</h3>
                                           <p style="color: #808184;text-align: center;font-size: x-small;">
                                               Building No.17, Street No.8,
                                               Sarvapriya Vihar,<br> New Delhi
                                               110016 (INDIA)  <span style="color: #4b110b;font-size: x-small;"><br>CIN </span>
                                               U74300DL2005PTC135060
                                            </p>
   
                                       </div>
                                   </td>
                                   <td>
                                       <div  align="left">
                                           <p style="color: #808184;font-size: xx-small;padding-right:42px;">Our Initiatives:</p>
                                           <img src="images/IP_color_logo.png" alt="IP" width="100px">
                                       </div>
                                   </td>
                                   <td>
                                       <div class="IPB_logo" align="left">
                                           <img src="images/IPB_color_logo.png" alt="IPB" width="100px">
   
                                       </div>
                                   </td>
                                   <td>
                                       <div class="Shutter_stock_logo" align="right">
                                           <p style="color: #808184;font-size: xx-small;padding-right:22px;">Our Representation:</p>
                                           <img src="images/shutterstock_logo.png" alt="IPB" width="100px">
                                       </div>
                                   </td>
                               </tr>
                           </tbody>
                       </table>
                   </div>
   
<!-- ------------end---------foooter---------------------- -->

   <br><br><br><br><br>
   
               <div style="padding:0px 0 0px 95px; margin-top: 85px; font-weight: bold; position:relative;"><h4>Transaction Summary</h4></div>
   
               <div style="width: 500px; padding-left: 95px;">
                   <table  border="1" cellspacing="0">
             
   
                       <tbody>
                           <tr>
                               <td style="font-weight: bold; padding: 5px;">
                                   S.No.
                               </td>
                               <td style="font-weight: bold; padding: 5px;">
                                   Description
                               </td>
                               <td style="font-weight: bold; padding: 5px;">
                                   Qty.
                               </td>
                               <td style="font-weight: bold; padding: 5px;">
                                   Rate (Rs.)
                               </td>
HTML;
if($disp_quotation['dis_amt']>0){
$html.= <<<HTML
                            <td style="font-weight: bold; padding: 5px;">Discount</td>
HTML;
if($condition==3){
$html.= <<<HTML
                            <td style="font-weight: bold; padding: 5px;">Cashback</td>
                            <td style="font-weight: bold; padding: 5px;">Handling Charges</td>                       
HTML;
}
$html.= <<<HTML
HTML;
}
$html.= <<<HTML

                               <td style="font-weight: bold; padding: 5px;">
                                   Price (Rs.)
                               </td>
                           </tr>
HTML;

//echo "<pre>"; print_r($order['invoice_details']); die;

for($i=0; $i<sizeof($order['invoice_details']);$i++)
    {
        $InvSno = $i+1;
        $InvDesc = strtoupper(stripslashes( $order['invoice_details'][$i]['invoice_details_description'] ));
        $InvQty = stripslashes( $order['invoice_details'][$i]['invoice_qty'] );
        $InvRate = stripslashes( $order['invoice_details'][$i]['invoice_rate'] );

        $InvRate = substr($InvRate,0,-3);        

        $InvAmount = stripslashes( $order['invoice_details'][$i]['invoice_amount'] );
        $rf_image_size = stripslashes( $order['invoice_details'][$i]['rf_image_size'] );

        $Collection = $order['invoice_details'][$i]['collection'];
        $image_type = $order['invoice_details'][$i]['image_type'];
        
        $image_Rate = $order['invoice_details'][$i]['invoice_rate'];
        $dis_Amt = $order['invoice_details'][$i]['discounted_amount'];
        $cb_Amt = $order['invoice_details'][$i]['cashbacked_amount'];
        $hc_Amt = $order['invoice_details'][$i]['handlingchared_amount'];
        //////
        $all_Discount=$all_Discount + $order['invoice_details'][$i]['discounted_amount'];
        $all_CashBack=$all_CashBack + $order['invoice_details'][$i]['cashbacked_amount'];
        //$all_Handling=$all_Handling + $order->invoice_details[$i]['handlingchared_amount'];
        $all_FinalPrices=$all_FinalPrices + $order['invoice_details'][$i]['final_img_price'];
        //////
        $final_Price = $image_Rate-($dis_Amt);

        $total_Final_price = $total_Final_price + $final_Price;
        $total_Final_price = round($total_Final_price,2);
        $final_Price = round($final_Price,2);
        $photographer_id = $order['invoice_details'][$i]['photographer_id'];
        $image_id = $order['invoice_details'][$i]['image_id'];
    
$html.= <<<HTML


                           <tr>
                               <td align="center">
                                   $InvSno
                               </td>
                               <td style="padding: 5px;">
                                   <span style="font-weight: bold;">
HTML;
 if($order['info']['invoice_id_vat']!=0){
$html.= <<<HTML
                                Sale of Image
HTML;
 }else{
$html.= <<<HTML
                                <u>License fee:</u><br>
HTML;
 }
$html.= <<<HTML
                                    </span>
                                   <span style="font-weight: bold;">Image ID:</span> $image_id <br>
                                   <span style="font-weight: bold;">Image Caption: </span>$InvDesc<br>

                                   <!--<span style="font-weight: bold;">Collection:</span> $Collection,--> 
                                   <span
                                       style="font-weight: bold;">Image Type:</span> $image_type,
HTML;
if($rf_image_size!=''){
$html.= <<<HTML

                                    <span style="font-weight: bold;">File Size: </span> $rf_image_size<br>

HTML;
}
$html.= <<<HTML
                                   <span style="font-weight: bold;">Model Release:</span>
HTML;

$tep_get_images_model_release_name=tep_get_images_model_release_name($order['invoice_details'][$i]['invoice_mrelease']);

$html.= <<<HTML
                                    $tep_get_images_model_release_name,



                                    <span
                                       style="font-weight: bold;">Property Release:</span>

HTML;

$tep_get_images_property_release_name=tep_get_images_property_release_name($order['invoice_details'][$i]['invoice_mrelease']);

$html.= <<<HTML
                                    $tep_get_images_property_release_name,

                                        <br>
                                        <span style="font-weight: bold;">Image Usage Given Below: -</span> <br>
HTML;

if(tep_get_image_usage($order['invoice_details'][$i]['image_usage'])!='0'){
$tep_get_image_usage=tep_get_image_usage($order['invoice_details'][$i]['image_usage']);
$html.= <<<HTML
                                <span style="font-weight: bold;">Usage:</span> $tep_get_image_usage
HTML;
}
if($order['invoice_details'][$i]['specific_use']!='') {
    $specific_use = $order['invoice_details'][$i]['specific_use'];
$html.= <<<HTML

                                <br>
                                        <span style="font-weight: bold;">Specific Use : </span>$specific_use
HTML;
}
if($order['invoice_details'][$i]['size']!='0'){
    $size=$order['invoice_details'][$i]['size'];
$html.= <<<HTML
                                <br>
                                        <span style="font-weight: bold;">Size : </span>$size
HTML;
}
if($order['invoice_details'][$i]['circulation']!='0'){
	$circulation= tep_get_image_circulation($order['invoice_details'][$i]['circulation']);
$html.= <<<HTML
                                <br>
                                        <span style="font-weight: bold;">Print run/ Circulation : </span>$circulation
HTML;
}
if($order['invoice_details'][$i]['placement']!='0'){
    $placement=$order['invoice_details'][$i]['placement'];
$html.= <<<HTML
                                <br>
                                        <span style="font-weight: bold;">Placement : </span>$placement
HTML;
}
if($order['invoice_details'][$i]['duration']!='0'){
    $duration=$order['invoice_details'][$i]['duration'];
$html.= <<<HTML
                                <br>
                                        <span style="font-weight: bold;">Duration : </span>$duration
HTML;
}
if($order['invoice_details'][$i]['start_date']!='0000-00-00'){
    $start_date=$order['invoice_details'][$i]['start_date'];
    $end_date=$order['invoice_details'][$i]['end_date'];
$html.= <<<HTML
                                <br>
                                        <span style="font-weight: bold;">Start Date : </span>$start_date
                                <br>
                                        <span style="font-weight: bold;">End Date : </span>$end_date
HTML;
}
if($order['invoice_details'][$i]['territory']!=''){
    $territory=$order['invoice_details'][$i]['territory'];
$html.= <<<HTML
                                <br>
                                        <span style="font-weight: bold;">Territory : </span>$territory
HTML;
}
if($order['invoice_details'][$i]['end_client']!=''){
    $end_client=$order['invoice_details'][$i]['end_client'];
$html.= <<<HTML
                                <br>
                                        <span style="font-weight: bold;">End Client : </span>$end_client
HTML;
}
$html.= <<<HTML

                               </td>
                               <td align="center">$InvQty</td>
                               <td align="center">$InvRate</td>
HTML;
if($disp_quotation['dis_amt']>0){
$html.= <<<HTML
                            <td>$dis_Amt</td>
HTML;
if($condition==3){
$html.= <<<HTML
                            <td style="font-weight: bold;">$cb_Amt</td>
                            <td style="font-weight: bold;">$hc_Amt</td>                       
HTML;
}
HTML;
}
$html.= <<<HTML
                            <td align="center">$final_Price</td>
                           </tr>
HTML;
$InvSno = '';
$InvDesc = '';
$InvQty = '';
$InvRate = '';
$InvAmount = '';
}
$html.= <<<HTML
                       </tbody>
                   </table>
               </div>
   
               
        <div class="total" style="margin: 10px 60px 0 0;">
            <table>
               <tbody>

                    <tr>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td>
                       
                       </td>
                       <td style="font-weight: bold;" align="right">
                           Sub Total 
HTML;
if($order['info']['invoice_vat']!=0){
$html.= <<<HTML
                        of License Fee
HTML;
}
$total_Final_price=number_format((float)$total_Final_price, 2, '.', '');
$html.= <<<HTML
                            
                        (Rs.): $total_Final_price
                       </td>
                   </tr>
HTML;

//<------------------GST TAX START----------------->
if($current_in>=$date_in){

    if($order['info']['invoice_orders_tax_text_cgst']!=0){
        $CGSTVAL= number_format((float)$order['info']['invoice_orders_tax_text_cgst'], 2, '.', '');
        $SGSTVAL= number_format((float)$order['info']['invoice_orders_tax_text_sgst'], 2, '.', '');
        $CGST= number_format((float)$order['info']['invoice_orders_cgst'], 2, '.', '');
        $SGST= number_format((float)$order['info']['invoice_orders_sgst'], 2, '.', '');
$html.= <<<HTML
                   <tr>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td style="font-weight: bold;" align="right">
                           CGST ($CGSTVAL) %: $CGST
                       </td>
                   </tr>
                   <tr>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td style="font-weight: bold;" align="right">
                           SGST ($SGSTVAL) %: $SGST
                       </td>
                   </tr>

HTML;
}
if($order['info']['invoice_orders_tax_text_igst']!=0){
        $IGSTVAL=$order['info']['invoice_orders_tax_text_igst'];
        $IGST=$order['info']['invoice_orders_igst'];
$html.= <<<HTML
                   <tr>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td style="font-weight: bold;" align="right">
                           IGST ($IGSTVAL) %: $IGST
                       </td>
                   </tr>

HTML;
}
if($order['info']['invoice_orders_tax_text_utgst']!=0){
        $UTGSTVAL=$order['info']['invoice_orders_tax_text_utgst'];
        $UTGST=$order['info']['invoice_orders_utgst'];
$html.= <<<HTML
                   <tr>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td style="font-weight: bold;" align="right">
                           UTGST ($UTGSTVAL) %: $UTGST
                       </td>
                   </tr>

HTML;
}
if($order['info']['invoice_orders_tax_text_cgst']==0 && $order['info']['invoice_orders_tax_text_sgst']==0 && $order['info']['invoice_orders_tax_text_igst']==0 && $order['info']['invoice_orders_tax_text_utgst']==0){
        $IGSTVAL=$order['info']['invoice_orders_tax_text_igst'];
        $IGST=$order['info']['invoice_orders_igst'];
$html.= <<<HTML
                   <tr>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td style="font-weight: bold;" align="right">
                           IGST ($IGSTVAL) %: $IGST
                       </td>
                   </tr>

HTML;
}
//<----------------------GST TAX END -------------------->
}
else{
if($order['info']['invoice_orders_tax_text']!=0){
        $servicetaxVal=$order['info']['invoice_orders_tax'];
        $krishikalyancessVal=$order['info']['krishi_kalyan_cess_hidden'];
        $swacchbharatcessVal=$order['info']['swachh_bharat_cess_hidden'];
$html.= <<<HTML
                   <tr>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td style="font-weight: bold;" align="right">
                           Service Tax ($servicetaxVal) %: 
HTML;
$st = (($total_Final_price) * ($order['info']['invoice_orders_tax_text'] /100));
$html.= <<<HTML
$st
                       </td>
                   </tr>
                   <tr>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td style="font-weight: bold;" align="right">
                           Krishi kalyan Cess ($krishikalyancessVal) %: 
HTML;
$sbc = (($total_Final_price) * ($order['info']['krishi_kalyan_cess_hidden'] /100));
$html.= <<<HTML
$sbc
                       </td>
                   </tr>
                   <tr>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td style="font-weight: bold;" align="right">
                           Swachh Bharat Cess ($swacchbharatcessVal) %: 
HTML;
$sbc = (($total_Final_price) * ($order['info']['swachh_bharat_cess_hidden'] /100));
$html.= <<<HTML
$sbc
                       </td>
                   </tr>

HTML;
}    
if($order['info']['invoice_vat']!=0){
    $invoice_vat=$order['info']['invoice_vat'];
    if($cst!=0){
        $cstVal = 'VAT @';
    }
    else{
        $cstVal = 'CST @';   
    }
$html.= <<<HTML
                <tr>
                       <td>
                       </td>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td style="font-weight: bold;" align="right">

                    $cstVal  $invoice_vat %: 
HTML;
$after_VAT_tax = (($total_Final_price) * ($order['info']['invoice_vat'] /100));
$html.= <<<HTML
$after_VAT_tax
                       </td>
                   </tr>
HTML;
}


}
$html.= <<<HTML
                   <tr>
                       <td></td>
                       <td></td>
                       <td style="font-weight: bold;"></td>

                       <td style="font-weight: bold;" align="right">Grand Total (Rs.):
HTML;
    $grandTotal = number_format((float)$order['info']['invoice_orders_total'],2, '.', '');
$html.= <<<HTML

                           $grandTotal
                           
                       </td>
                       </tr>
                       <tr>
                       <td></td>
                       <td></td>
                       <td></td>

                       <td style="font-weight: bold; line-height: 50px;" align="right">
                          For Mahatta Multimedia Pvt. Ltd.
                       </td>
                       </tr>
            </tbody>
           </table>
       </div>      
HTML;
if ($qrCode) {
$html.= <<<HTML
           <img style="margin-left: 90px;" src="data:image/png;base64,$qrCode" height=175 width=175>
           <div style="margin: 80px 105px 20p 90px;">
HTML;
}else{
$html.= <<<HTML
            <div style="margin: 220px 105px 20p 90px;">
HTML;
}
$html.= <<<HTML
           <table> 
                <tbody>
                    <tr>
                        <td style="line-height: 50px;">
                           Receiver's Signature
                       </td>
                       <td align="right" style="line-height: 50px;">
                          
                           <p>Authorised Signatory</p>
                           
                       </td>
                   </tr>
                </tbody>
           </table>
        </div>
            <!-- --------------end---------- Transaction----------------------- -->
   
   
   
   
            <!-- ------------------------ mkt. and cust.care----------------------- -->
   
               <div style="padding:0px 95px 0 95px;">
                   <p><span style="font-weight: bold;">Sales Person:</span> - 
                   $invoice_sales_person,


                    Contact No- $invoice_sales_person_contact,<br>
                       E-mail: -$invoice_sales_person_email </p>
                   <p><span style="font-weight: bold;">Client Servicing:</span> - $invoice_client_service_name, Contact No- $invoice_client_service_contact,<br>
                       E-mail: -$invoice_client_service_email
                   </p>
               </div>
   
               <!-- --------------------terms and condition--------------------- -->
            
                   <div style="padding:0px 95px 0 95px;" >
                   <p >• ON <span style="font-weight: bold;">IMAGE USAGE </span> </p>
   
                   <p>• I have read and agree to the terms and conditions as stated in the EULA <a href="https://indiapicture.in/license" target="_blank">Click Here</a>.
                   </p>
                   <p>• Once the High-Resolution images are delivered the image is considered licensed, &nbsp;&nbsp;&nbsp;&nbsp;irrespective of the
                       usage and  it entitles the client to pay for the same. </p>
                   <p>• The license fee is for non-exclusive usage of the image. </p>
                   <p>• Rights Managed  (RM)  images are licensed for specific usage as described  in  the  image &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp; details. It cannot be used for any other usage. </p>
                   <p>• Royalty Free (RF) images may be used for any usage for the particular client identified. RF &nbsp;&nbsp;  images
                       once delivered will not be cancelled.
                   </p>
               </div>
   
             
                   <div style="padding:30px 95px 0 95px;" >
                   <p><span style="font-weight: bold;">&nbsp;&nbsp;&nbsp;FOR PAYMENT </span> </p>
   
                   <p>• Payments must be cleared for all images for which high resolution images have been &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;     delivered. </p>
                   <p>• In case of payment by cheque, please make the cheque in favor of "Mahatta Multimedia Pvt. &nbsp;&nbsp; Ltd."
                   </p>
                   <p>• In case of any disputes, they will be subject to Jurisdiction of Delhi Courts. </p>
                   <p>• India Picture reserves the right to review and change any of the above terms and conditions &nbsp;&nbsp;&nbsp; without
                       any prior notice. This includes any changes in licensing fees also. </p>
               </div>
               <!-- -----------end---------terms and condition--------------------- -->


                <div style="padding:30px 0 0 95px; font-weight: bold;color: #18446d;font-family:Ubuntu, Helvetica, Arial, sans-serif;"><h4>Please find below  Bank details for NEFT/IMPS.</h4></div><br>
   
               <div style="width: 500px; height: 120px; padding-left: 95px;font-family:Ubuntu, Helvetica, Arial, sans-serif;">
                   <table  border="1" cellspacing="0">
             
   
                       <tbody>
                           <tr>
                               <td style="font-weight: bold;">
                                   Company Name
                               </td>
                               <td style="font-weight: bold;">
                                   Mahatta Multimedia Pvt. Ltd.
                               </td>
                            
                           </tr>
                           <tr>
                               <td style="font-weight: bold;">
                                   Bank Name
                               </td>
                               <td>
                                   HDFC Bank Ltd.
                               </td>
                            
                           </tr>
                           <tr>
                               <td style="font-weight: bold;">
                                   Branch Address
                               </td>
                               <td>
                                   C-72, Shivalik, New Delhi-110017
                               </td>
                            
                           </tr>
                           <tr>
                               <td style="font-weight: bold;">
                                   A/c No.
                               </td>
                               <td>
                                   00322320002453
                               </td>
                            
                           </tr>
                           <tr>
                               <td style="font-weight: bold;">
                                   RTGS/NEFT/IFSC Code
                               </td>
                               <td>
                                   HDFC0004026 
                               </td>
                            
                           </tr>
                       
                        
                       </tbody>
                   </table>
               </div>
               </br></br></br>

		<div style="width: 500px; height: 120px; padding-left: 95px;font-family:Ubuntu, Helvetica, Arial, sans-serif;">
                   <table  border="1" cellspacing="0">


                       <tbody>
                           <tr>
                               <td style="font-weight: bold;">
                                   Company Name
                               </td>
                               <td style="font-weight: bold;">
                                   Mahatta Multimedia Pvt. Ltd.
                               </td>

                           </tr>
                           <tr>
                               <td style="font-weight: bold;">
                                   Bank Name
                               </td>
                               <td>
                                   HDFC Bank Ltd.
                               </td>

                           </tr>
                           <tr>
                               <td style="font-weight: bold;">
                                   Branch Address
                               </td>
                               <td>
                                   Andheri East Ahura Centre  Mumbai
                               </td>

                           </tr>
                           <tr>
                               <td style="font-weight: bold;">
                                   A/c No.
                               </td>
                               <td>
                                   05432000006075
                               </td>

                           </tr>
                           <tr>
                               <td style="font-weight: bold;">
                                   RTGS/NEFT/IFSC Code
                               </td>
                               <td>
                                   HDFC0000543
                               </td>

                           </tr>


                       </tbody>
                   </table>
	       </div>
		<div style="padding-left: 95px;padding-bottom: 0px;font-family:Ubuntu, Helvetica, Arial, sans-serif;">
                <h4>You can also pay using your Credit/Debit Card or Net Banking. </h4>
            </div>

HTML;

$data = array(
'orderid'=>$invoice_id,
'item_name'=>$invoice_id,
'net_amount'=>$grandTotal,
'total_price'=>$grandTotal,
'customers_id'=>$customers_id,
'payoption'=>'CCAVENUE',
'type'=>'OFFLINE',
);
$encryptedData=base64_encode(serialize($data));

$html.= <<<HTML
               <div style="padding-left: 95px;padding-bottom: 0px;padding-top: 15px;">
                 <h4><a href="http://admin.indiapicture.in/ccavenue_checkout_pdf.php?values=$encryptedData" style="text-decoration: none;color: #fa0808;font-family:Ubuntu, Helvetica, Arial, sans-serif; cursor: pointer;">Click here to Pay Online(CC Avenue)</a> </h4>
            </div>
           </div>
       </body>
       </html>
HTML;

$dompdf->loadHtml($html);

// set paper size and orientation
//$size=array(0,0,750,1000);
//$dompdf->setPaper($size);
$dompdf->setPaper('A4', 'portrait');  

// render html as pdf
$dompdf->render();

// output the pdf to browser
//$dompdf->stream(tep_get_invoice_type($order['info']['invoice_type'])."_". $_REQUEST['invoice_id']);
$dompdf->stream(tep_get_invoice_type($order['info']['invoice_type'])."_". $_REQUEST['invoice_id'],array('Attachment'=>0));
?>
