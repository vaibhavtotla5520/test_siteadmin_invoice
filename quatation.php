<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
require_once 'autoload.inc.php';
require_once 'autoload.inc.php';
require_once 'all_func.php';

require_once 'database.php';

use Dompdf\Dompdf;
$dompdf = new Dompdf();

$dompdf->getOptions()->getChroot();

$invoice_id = $_REQUEST['invoice_id'];
$contactPerson = $_REQUEST['contact_person'];
$contactDetailName = $_REQUEST['contactDetailName'];
$clientDetailEmail = $_REQUEST['clientDetailEmail'];
$condition = $_REQUEST['condition'];
$cst = $_REQUEST['cst'];

//====================================//
//Class and database
$invoice = new invoice;
$connect = $invoice->connectivity();
//====================================//
if($invoice_id==''){
    $order = $invoice->quatationNot();
}else{
    $order = $invoice->quatation($invoice_id,$connect);
    $disp_quotation=$invoice->disp_quatation($invoice_id,$connect);
    $sql_qutation_detail=$invoice->sql_qutation_detail($invoice_id,$connect);
}
// echo "<pre>"; print_r($order); die;

$customers_id=$order['customer']['invoice_customers_id'];

$invoice_sales_person_contact=tep_get_sales_contactno_salesperson($order['customer']['invoice_sales_person']);
$invoice_sales_person=tep_get_sales_person($order['customer']['invoice_sales_person']);
$invoice_sales_person_email=tep_get_sales_email_salesperson($order['customer']['invoice_sales_person']);

$invoice_client_service_name=tep_get_client_service($order['customer']['invoice_client_service']);
$invoice_client_service_contact=tep_get_contactno_client_service($order['customer']['invoice_client_service']);
$invoice_client_service_email=tep_get_client_service_email($order['customer']['invoice_client_service']);

if($order['customer']['invoice_customers_name'])
	$ClientName=$order['customer']['invoice_customers_name'];
if($order['customer']['invoice_customers_address_line1'])
	$ClientAddress=$order['customer']['invoice_customers_address_line1'];
if($order['customer']['invoice_customers_address_line2'])
	$ClientAddress.=$order['customer']['invoice_customers_address_line2'];
else
	$ClientAddress.= '';

if($order['customer']['invoice_customers_city'])
	$ClientCity=$order['customer']['invoice_customers_city'];
if($order['customer']['invoice_customers_state'])
	$ClientState=$order['customer']['invoice_customers_state'];
if($order['customer']['invoice_customers_postcode'])
	$ClientPostcode=$order['customer']['invoice_customers_postcode'];
if($order['customer']['invoice_customers_country'])
	$ClientCountry=$order['customer']['invoice_customers_country'];
if($order['customer']['invoice_customers_telephone'])
	$ClientTelephone=$order['customer']['invoice_customers_telephone'];
if($order['customer']['invoice_customers_email_address'])
	$ClientEmail=$order['customer']['invoice_customers_email_address'];
if($order['customer']['invoice_jobno'])
        $ClientJobNumber=$order['customer']['invoice_jobno'];
else
    $ClientJobNumber='';
$companyName=$order['customer']['invoice_customers_company'];

$InvDate=$order['info']['invoice_date'];
$InvDate = date('d/m/Y',strtotime($InvDate));

$html = <<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahatta Multimedia Tax Invoice</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="top_bar_parent" >
        <div class="top_bar"></div>
    </div>
    <div class="main_cont" >

        <div id="container">
            <!-- <header> -->
            <div id="navbar-brand" style="padding-left:30px;"><img src="images/logo_mahatta_multimedia.png" height="50" alt="Invoice">
                <div class="social_icon" style="padding-right:30px;">
                    <ul>
                        <li><img src="images/telephone.png" alt="telephone" width="20px"><span ></span></li>
                        <li style="color:#ababaf; font-size:medium;">+91 11 41470000</li>
                    </ul>
                    <ul>
                        <li><img src="images/mail.png" alt="info" width="20px"></li>
                        <li style="color:#ababaf;font-size:medium;">info@indipicture.in</li>
                    </ul>
                    <ul>
                        <li><img src="images/Internet.png" alt="Inter." width="20px"></li>
                        <li style="color:#ababaf;font-size:medium;">www.indiapicture.in</li>
                    </ul>
                </div>
            </div>



            <!-------end----- <header> -->


                
                
            <!-----------Tax Invoice --
                
                <div class="tx_inv">
                    <div class="tax_invoice">
                        <h3 style="padding-top: 100px;" align="center">TAX INVOICE</h3>
                    </div>
                </div>

            
            -- --------------------ORIGINAL FOR RECIPIENT----------------------- -->
            
            <div style="font-weight: bold;padding-top: 60px; padding-left: 95px;">
                <h4>Quotation</h4>
            </div>
            <br>
            <div style="width: 800px; height: 365px;padding-left: 95px;">
                <table border="1" cellspacing="0">

                    <tbody>
                        <tr>
                            <td style="font-weight: bold;font-size:large; padding: 1px;" align="right">
                                Quotation#
                            </td>
                            <td style="padding: 1px;">
                                 $invoice_id
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">
                                Invoice Date:
                            </td>
                            <td style="padding: 1px;">
                                $InvDate
			    </td>
			</tr>

			<tr>
			<td align="right"><span  style="font-weight: bold; padding: 1px;">Job no:</span></td><td>$ClientJobNumber</td>
			</tr>

                        <tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">
                                GSTIN:
                            </td>
                            <td style="font-weight: bold; padding: 1px;">
                                07AAECM4064D1ZQ
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">
                                SAC:
                            </td>
                            <td style="font-weight: bold;">
                                997339
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">
                                Description of Service:
                            </td>
                            <td style="font-weight: bold; padding: 1px;">
                                Licensing services for the right to use<br>
                                other intellectual property products and<br>
                                other resources N.E.C.

                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">
                                MSME UAM No.:
                            </td>
                            <td style="font-weight: bold; padding: 1px;">
                                 DL08E0023359

                            </td>
                        </tr>
HTML;
if($order['customer']['po_number']!=''){
$po_number=$order['customer']['po_number'];
$html.= <<<HTML
                        <tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">
                                PO No.:
                            </td>
                            <td style="font-weight: bold; padding: 1px;">
                                $po_number 

                            </td>
                        </tr>
HTML;
if($order['customer']['po_date']!='0000-00-00'){
	$PoDate=$order['customer']['po_date'];
	$PoDate = date('d/m/Y',strtotime($PoDate));
$html.= <<<HTML
                        <tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">
                                PO Date:
                            </td>
                            <td>
                                <strong>$PoDate</strong>
                            </td>
                        </tr>
                            
HTML;
}
}
$html.= <<<HTML

HTML;
if($order['customer']['invoice_jobno']!=''){
	$invoice_jobno=$order['customer']['invoice_jobno'];
$html.= <<<HTML
						<tr>
							<td style="font-weight: bold; padding: 1px;" align="right">JOB No :</td>
							<td>$invoice_jobno</td>
						</tr>
HTML;
}
$html.= <<<HTML
                        <tr>
                            <td style="padding: 1px;">

                            </td>
                            <td style="font-weight: bold; padding: 1px; background-color:#c4c4c6">
                                CUSTOMER DETAILS

                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">
                                Customer GST No.:
                            </td>
                            <td style="padding: 1px;">
HTML;
if($order['customer']['customer_gst_no']!=''){
	$customer_gst = $order['customer']['customer_gst_no'];
}else{
	$customer_gst = 'Not Registered';
}

$html.= <<<HTML
                                $customer_gst

                            </td>
                        </tr>
 						<tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">
                                Company Name:
                            </td>
                            <td style="padding: 1px;">
                                 $companyName
                            </td>
                        </tr>                     
                        <tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">
                                Place of Supply:
                            </td>
                            <td style="padding: 1px;">
                                 $ClientState
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">
                                Contact Person :
                            </td>
                            <td style="padding: 1px;">
                            $contactPerson
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 1px; height: 100px;" align="right">
                                Address:
                            </td>
                            <td style="padding: 1px;">
                                 $ClientAddress, $ClientCity-$ClientPostcode, $ClientState, $ClientCountry
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">
                                State:
                            </td>
                            <td style="padding: 1px;">
                                 $ClientState
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 1px;" align="right">
                                Contact Details:
                            </td>
                            <td style="padding: 1px;">
                            $contactDetailName, $clientDetailEmail
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- --------------end----------ORIGINAL FOR RECIPIENT----------------------- -->
   
   
   
   
            <!-- ----------------------- Transaction----------------------- -->
   
            <div style="padding-top: 110px;padding-left: 95px; height: 185px;">
HTML;
if($order['info']['invoice_date'] <= '2009-04-01')
	{
		if($order['info']['tbl_invoice_tax_type']!=1){
$html.= <<<HTML
                <h4>PAN No. Is : AAECM4064D</h4>
                <br><br>
HTML;
}else{
$html.= <<<HTML
				<h4>WE REQUEST YOU NOT TO DEDUCT TAX AT SOURCE AS WE HAVE REQUISITE CERTIFICATE 
					UNDER SECTION<br /> 197 OF THE INCOME TAX ACT, 1961. <br>
					OUR PAN - AAECM4064D</h4>
HTML;
}
}
else{
	if($order['info']['tbl_invoice_tax_type']!=1){
$html.= <<<HTML
<br><br><br>
				<h4>PAN No. Is : AAECM4064D</h4>
                <br><br>
HTML;
}else{
$html.= <<<HTML
<br><br><br>
				<h4>PLEASE DEDUCT TDS NOT MORE THAN 2.06% AS WE ARE COVERED UNDER CONTRACTOR (I.E. UNDER SECTION 194C OF THE INCOME TAX ACT) AS WE SUPPLIED THE IMAGES AND WORKED ON COMMISSION BASIS.</h4>
                <br><br>
HTML;
}
}
$html.= <<<HTML
                <h4><span style="background-color:#c4c4c6">* Payment Terms: - $companyName agrees to make the payment by
                        .</span> </h4>
            </div>

<!-- ---------------start-------------testing---footer---------------------->

<div style="padding-top: 60px;"><img src="images/footer_bar.png" width="100%" height="1px" alt="bottom_Line"></div>
<div style=" height: 120px; padding: 10px 0px 0px 95px;">
    <table>
        <tbody >
            <tr>
                <td >
                    <div class="mm_address">
                        <h3 style="color: #4b110b;text-align: center;">Mahatta
                            Multimedia,<br> Pvt. Ltd.</h3>
                        <p style="color: #808184;text-align: center;font-size: x-small;">
                            Building No.17, Street No.8,
                            Sarvapriya Vihar, New Delhi
                            110016 (INDIA)  <span style="color: #4b110b;font-size: x-small;"><br>CIN </span>
                            U74300DL2005PTC135060</p>

                    </div>
                </td>
                <td>
                    <div class="IP_logo"  align="right">
                        <p style="color: #808184;font-size: xx-small;padding-right:42px;">Our Initiatives:</p>
                        <img src="images/IP_color_logo.png" alt="IP" width="100px">
                    </div>
                </td>
                <td>
                    <div class="IPB_logo" align="right">
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



<!-- ----------------------------testing---footer-------------------- -->


               <div style="padding:30px 0 0px 95px; font-weight: bold;"><h4>Transaction Summary</h4></div>
   
               <div style="width: 500px; padding-left: 95px;">
                   <table  border="1" cellspacing="0">
             
   
                       <tbody>
                           <tr>
                               <td style="font-weight: bold;">
                                   S.No.
                               </td>
                               <td style="font-weight: bold;">
                                   Description
                               </td>
                               <td style="font-weight: bold;">
                                   Qty.
                               </td>
                               <td style="font-weight: bold;">
                                   Rate (Rs.)
                               </td>
HTML;
if($disp_quotation['dis_amt']>0){
$html.= <<<HTML
                               <td>Discount</td>
HTML;
if($condition==3){
$html.= <<<HTML
                                <td>Cach Back</td>
                                <td>Handling Charges</td>
HTML;
}
}
$html.= <<<HTML
                               <td style="font-weight: bold;">
                                   Final Price (Rs.)
                               </td>
                           </tr>
HTML;
// echo "<pre>"; print_r($order['invoice_details']); die;
$InvSno = '';
$all_Discount=0;
$all_CashBack=0;
$all_Handling=0;
$all_FinalPrices=0;
$total_Final_price=0;
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
        $cash_back = $order['invoice_details'][$i]['cash_back'];
        $handling_charges = $order['invoice_details'][$i]['handling_charges'];

        $image_Rate = $order['invoice_details'][$i]['invoice_rate'];
        $dis_Amt =$order['invoice_details'][$i]['discounted_amount'];
        $cb_Amt =$order['invoice_details'][$i]['cashbacked_amount'];
        $hc_Amt =$order['invoice_details'][$i]['handlingchared_amount'];
        
        $final_Price = $image_Rate-($dis_Amt);

        /////////
        $all_Discount=$all_Discount + $order['invoice_details'][$i]['discounted_amount'];
        $all_CashBack=$all_CashBack + $order['invoice_details'][$i]['cashbacked_amount'];
        $all_Handling=$all_Handling + $order['invoice_details'][$i]['handlingchared_amount'];
        $all_FinalPrices=$all_FinalPrices + $order['invoice_details'][$i]['final_img_price'];
        
        //////////
        $total_Final_price = $total_Final_price + $final_Price;

        // //////
        // $all_Discount=$all_Discount + $order['invoice_details'][$i]['discounted_amount'];
        // $all_CashBack=$all_CashBack + $order['invoice_details'][$i]['cashbacked_amount'];
        // //$all_Handling=$all_Handling + $order->invoice_details[$i]['handlingchared_amount'];
        // $all_FinalPrices=$all_FinalPrices + $order['invoice_details'][$i]['final_img_price'];
        // //////
        // $final_Price = $image_Rate-($dis_Amt);

        // $total_Final_price = $total_Final_price + $final_Price;
        // $total_Final_price = round($total_Final_price,2);
        // $final_Price = round($final_Price,2);
        // $photographer_id = $order['invoice_details'][$i]['photographer_id'];
        $image_id = $order['invoice_details'][$i]['image_id'];

$html.= <<<HTML
                           <tr>
                               <td align="center" style="padding: 5px;">
                                   $InvSno
                               </td>
                               <td style="padding: 5px;">
                                   <span style="font-weight: bold;"> License fee</span><br>
                                   <span style="font-weight: bold;">Image ID:</span> $image_id<br>
                                   <span style="font-weight: bold;">Image Caption: </span>$InvDesc<br>
                                  <!-- <span style="font-weight: bold;">Collection:</span> $Collection,--> <span
                                       style="font-weight: bold;">Image Type:</span> $image_type,
HTML;
if($rf_image_size!=''){
$html.= <<<HTML
                                        <span style="font-weight: bold;">File Size: </span> $rf_image_size
HTML;
}
$html.= <<<HTML
                                        <br>
HTML;
$tep_get_images_model_release_name=tep_get_images_model_release_name($order['invoice_details'][$i]['invoice_mrelease']);
$html.= <<<HTML
                                   <span style="font-weight: bold;">Model Release:</span> $tep_get_images_model_release_name,
HTML;
$tep_get_images_property_release_name=tep_get_images_property_release_name($order['invoice_details'][$i]['invoice_mrelease']);
$html.= <<<HTML
                                   <span style="font-weight: bold;">Property Release:</span> $tep_get_images_property_release_name<br>
HTML;
if($image_type=="RM"){
$html.= <<<HTML
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
    $circulation=$order['invoice_details'][$i]['circulation'];
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
}
$html.= <<<HTML
                               </td>
                               <td align="center" style="padding: 5px;">
                                   $InvQty
                               </td>
                               <td align="right" style="padding: 5px;">
                                   $InvRate
                               </td>
HTML;
if($disp_quotation['dis_amt']>0){
$html.= <<<HTML
                               <td>$dis_Amt</td>
HTML;
if($condition==3){
$html.= <<<HTML
                                <td>$cash_back</td>
                                <td>$handling_charges</td>
HTML;
}
}
$html.= <<<HTML
                               <td align="right" style="padding: 5px;">
                                   $final_Price
                               </td>
                           </tr>
HTML;
}
$html.= <<<HTML
                       </tbody>
                   </table>
               </div>
   
               
               
               <div class="total" style="padding: 20px 60px 0 0;">
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
$html.=<<<HTML
of License Fee
HTML;
}
$html.= <<<HTML
                            (Rs.): $total_Final_price
                       </td>
                   </tr>
HTML;
if($order['info']['invoice_orders_tax_text_cgst']==0 && $order['info']['invoice_orders_tax_text_igst']==0 && $order['info']['invoice_orders_tax_text_utgst']==0 && $order['info']['invoice_orders_tax_text_cgst']!=0 && $order['info']['invoice_orders_tax_text_igst']!=0){
              if($order['info']['invoice_orders_tax_text']!=0){

                $invoice_orders_tax_text=$order['info']['invoice_orders_tax_text'];
                $st =round((($total_Final_price) * ($order['info']['invoice_orders_tax_text'] /100)),2);

                $krishi_kalyan_cess_hidden=$order['info']['krishi_kalyan_cess_hidden'];
                $kes=(($total_Final_price) *($order['info']['krishi_kalyan_cess_hidden'])/100);

                $swachh_bharat_cess_hidden=$order['info']['swachh_bharat_cess_hidden'];
                $sbc=(($total_Final_price) *($order['info']['swachh_bharat_cess_hidden'])/100);
$html.= <<<HTML

   
                   <tr>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td style="font-weight: bold;" align="right">
                           Service Tax ($invoice_orders_tax_text) %: $st
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
                           Krishi kalyan cess ($krishi_kalyan_cess_hidden) %: $kes
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
                           Swachh Bharat Cess ($swachh_bharat_cess_hidden) %: $sbc
                       </td>
                   </tr>
HTML;
}
if($order['info']['invoice_vat']!=0){
    if($cst!=0)
        {
            $cstVal='VAT @';
        } else 
        {
            $cstVal='CST @';
        }

    $invoice_vat=$order['info']['invoice_vat'];
    $after_VAT_tax=(($total_Final_price) * ($order['info']['invoice_vat'] /100));
$html.= <<<HTML
                    <tr>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td style="font-weight: bold;" align="right">
                           $cstVal $invoice_vat %: $after_VAT_tax
                       </td>
                   </tr>

HTML;
}
}
else{
    if($order['info']['tbl_invoice_tax_type']==1 || $order['info']['tbl_invoice_tax_type']==11 || $order['info']['tbl_invoice_tax_type']==10 ){
        $invoice_orders_tax_text_cgst=$order['info']['invoice_orders_tax_text_cgst'];
        $CGST =round((($total_Final_price) * ($order['info']['invoice_orders_tax_text_cgst'] /100)),2);
$html.= <<<HTML
                    <tr>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td style="font-weight: bold;" align="right">
                           CGST ($invoice_orders_tax_text_cgst) %: $CGST
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
                           SGST ($invoice_orders_tax_text_cgst) %: $CGST
                       </td>
                   </tr>

HTML;
}
elseif($order['info']['tbl_invoice_tax_type']==2 || $order['info']['tbl_invoice_tax_type']==22 || $order['info']['tbl_invoice_tax_type']==20){
    $invoice_orders_tax_text_igst=$order['info']['invoice_orders_tax_text_igst'];
    $IGST =round((($total_Final_price) * ($order['info']['invoice_orders_tax_text_igst'] /100)),2);
$html.= <<<HTML
                    
                    <tr>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td style="font-weight: bold;" align="right">
                           IGST ($invoice_orders_tax_text_igst) %: $IGST
                       </td>
                   </tr>

HTML;
}
elseif($order['info']['tbl_invoice_tax_type']==3 || $order['info']['tbl_invoice_tax_type']==7){
    $invoice_orders_tax_text_utgst=$order['info']['invoice_orders_tax_text_utgst'];
    $UIGST =(($total_Final_price) * ($order['info']['invoice_orders_tax_text_utgst'] /100));
$html.= <<<HTML
                    <tr>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td style="font-weight: bold;" align="right">
                           UIGST ($invoice_orders_tax_text_utgst) %: $UIGST
                       </td>
                   </tr>
HTML;
    }
}
$html.= <<<HTML

                   <tr>
                       <td>
                           
                       </td>
                       <td>
                           
                       </td>
                       <td style="font-weight: bold;">
                           
                       </td>
                       <td style="font-weight: bold;" align="right">
HTML;
$invoice_orders_total=number_format($order['info']['invoice_orders_total']);
$html.= <<<HTML
                           Grand Total (Rs.):$invoice_orders_total
                           
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
       <div style="margin: 220px 105px 20p 90px;">
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


                     $invoice_sales_person_contact,<br>
                       E-mail: -$invoice_sales_person_email </p>
                   <p><span style="font-weight: bold;">Client Servicing:</span> - $invoice_client_service_name, $invoice_client_service_contact,<br>
                       E-mail: -$invoice_client_service_email
                   </p>
               </div>
   
               <!-- --------------------terms and condition--------------------- -->
            
                   <div style="padding:30px 95px 0 95px;" >
                   <p >• ON <span style="font-weight: bold;">IMAGE USAGE </span> </p>
   
                   <p>• I have read and agree to the terms and conditions as stated in the EULA <a href="https://indiapicture.in/license">Click Here</a>.
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
   
                <!-- <h4><span style="background-color:#c4c4c6">* Payment Terms: - agrees to make the payment by
                        03/09/2021.</span> </h4> -->

   
               
               <!-- ---------------------foooter---------------------- -->
               <!-- <div style="padding-top: 30px;"><img src="images/footer_bar.png" width="100%" height="1px" alt="bottom_Line"></div>
                   <div style=" height: 170px; padding: 10px 0px 0px 95px;">
                       <table>
                           <tbody >
                               <tr>
                                   <td >
                                       <div class="mm_address">
                                           <h3 style="color: #4b110b;text-align: center;">Mahatta
                                               Multimedia,<br> Pvt. Ltd.</h3>
                                           <p style="color: #808184;text-align: center;font-size: x-small;">
                                               Building No.17, Street No.8,
                                               Sarvapriya Vihar, New Delhi
                                               110016 (INDIA)  <span style="color: #4b110b;font-size: x-small;"><br>CIN </span>
                                               U74300DL2005PTC135060</p>
   
                                       </div>
                                   </td>
                                   <td>
                                       <div class="IP_logo"  align="right">
                                           <p style="color: #808184;font-size: xx-small;padding-right:42px;">Our Initiatives:</p>
                                           <img src="images/IP_color_logo.png" alt="IP" width="100px">
                                       </div>
                                   </td>
                                   <td>
                                       <div class="IPB_logo" align="right">
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
    -->
               <!-- ------------end---------foooter---------------------- -->
   
               </div>
           </div>
       </body>
       </html>
HTML;

$dompdf->loadHtml($html);

// set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// render html as pdf
$dompdf->render();

// output the pdf to browser
// $dompdf->stream();
$dompdf->stream('quatation_'.$_REQUEST['invoice_id'],array('Attachment'=>0),array('Attachment'=>0));
?>
