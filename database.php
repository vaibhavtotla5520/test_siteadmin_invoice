<?php
Class invoice{
	function connectivity(){
		//$conn = new mysqli("indiapicture.ci18uyfr1mrf.ap-south-1.rds.amazonaws.com","indiapicture","!9Waha77a!nd!a","indiapicture");
		$conn = new mysqli("indiapicture.ci18uyfr1mrf.ap-south-1.rds.amazonaws.com","indiapicturedev1","wH7bJ4yJsrqjNc1R","indiapicture_dev1");
		if ($conn -> connect_errno) {
		  echo "Failed to connect to MySQL: " . $conn -> connect_error;
		  exit();
		}
		return $conn;
	}

	function quatation($invoice_id,$conn){
		$invoice_totals=0;
		$photographer_comm_totals=0;
		$ip_comm_totals=0;
		$invoice_amount_totals = 0;
		$customerBillGst = '';
		$customerCustGst = '';

		$sql = "SELECT * FROM tbl_invoice WHERE invoice_id='$invoice_id'";
		if($result = mysqli_query($conn, $sql)) {
			$invoice_record = mysqli_fetch_array($result);

			$customers_id = $invoice_record['invoice_customers_id'];

			$sqlBillGst = "SELECT customer_gst_no FROM tbl_billing_customers WHERE customers_id='$customers_id'";
			if($resultGst = mysqli_query($conn, $sqlBillGst)) {
				$dispBillGst = mysqli_fetch_array($resultGst);
				$customerBillGst = $dispBillGst['customer_gst_no'];
			}

			$sqlCustGst = "SELECT customer_gst_no FROM tbl_customers WHERE customers_id='".$customers_id."'";
			if($resultCustGst = mysqli_query($conn, $sqlCustGst)) {
				$dispCustGst = mysqli_fetch_array($resultCustGst);
				$customerCustGst = $dispCustGst['customer_gst_no'];
			}

			if(isset($invoice_record['customer_gstno']) && ($invoice_record['customer_gstno']<>'')){
				$customer_gst_no = $invoice_record['customer_gstno'];
			}
			elseif(isset($customerCustGst) && ($customerCustGst<>'')){
				$customer_gst_no = $customerCustGst;
			}
			else{ 
				$customer_gst_no = $customerBillGst;
			}



				$info = array('invoice_id' => $invoice_record['invoice_id'],
							'invoice_region' => $invoice_record['invoice_region'],
							'financial_year' => $invoice_record['financial_year'],
							'business_type' => $invoice_record['business_type'],
							'invoice_orders_amount' => $invoice_record['invoice_orders_amount'],
							'invoice_orders_tax_text' => $invoice_record['invoice_orders_tax_text'],
							'invoice_orders_tax' => $invoice_record['invoice_orders_tax'],
							'invoice_orders_discount_text' => $invoice_record['invoice_orders_discount_text'],
							'orders_amount_distotals' => $invoice_record['orders_amount_distotals'],
							'orders_amount_afterdistotals' => $invoice_record['orders_amount_afterdistotals'],

							'invoice_education_cess_hidden' => $invoice_record['invoice_education_cess_hidden'],
							'order_education_cess' => $invoice_record['order_education_cess'],
							'invoice_high_education_cess_hidden' => $invoice_record['invoice_high_education_cess_hidden'],
							'order_high_education_cess' => $invoice_record['order_high_education_cess'],
							'swachh_bharat_cess' => $invoice_record["swachh_bharat_cess"],
							'swachh_bharat_cess_hidden' => $invoice_record["swachh_bharat_cess_hidden"],
							'krishi_kalyan_cess' => $invoice_record["krishi_kalyan_cess"],
							'krishi_kalyan_cess_hidden' => $invoice_record["krishi_kalyan_cess_hidden"],
							'invoice_orders_tax_text_cgst' => $invoice_record["invoice_orders_tax_text_cgst"],
							'invoice_orders_cgst' => $invoice_record["invoice_orders_cgst"],
							'invoice_orders_tax_text_sgst' => $invoice_record["invoice_orders_tax_text_sgst"],
							'invoice_orders_sgst' => $invoice_record["invoice_orders_sgst"],
							'invoice_orders_tax_text_igst' => $invoice_record["invoice_orders_tax_text_igst"],
							'invoice_orders_igst' => $invoice_record["invoice_orders_igst"],
							'invoice_orders_tax_text_utgst' => $invoice_record["invoice_orders_tax_text_utgst"],
							'invoice_orders_utgst' => $invoice_record["invoice_orders_utgst"],
							'invoice_orders_total' => $invoice_record['invoice_orders_total'],
							'photographer_amount' => $invoice_record['photographer_amount'],
							'photographer_tax' => $invoice_record['photographer_tax'],
							'photographer_total' => $invoice_record['photographer_total'],
							'ip_amount' => $invoice_record['ip_amount'],
							'ip_tax' => $invoice_record['ip_tax'],
							'ip_total' => $invoice_record['ip_total'],
							'discount' => $invoice_record['discount'],
							'discounted_amount' => $invoice_record['discounted_amount'],
							'cash_back' => $invoice_record['cash_back'],
							'cashbacked_amount' => $invoice_record['cashbacked_amount'],
							'handling_charges' => $invoice_record['handling_charges'],
							'handlingchared_amount' => $invoice_record['handlingchared_amount'],
							'tbl_invoice_tax_type' => $invoice_record['tbl_invoice_tax_type'],
							'invoice_vat' => $invoice_record['invoice_vat'],
							'invoice_vat_taxvalue' => $invoice_record['invoice_vat_taxvalue'],
							'invoice_date' => $invoice_record['invoice_date'],
							'invoice_due_date' => $invoice_record['invoice_due_date'],
							'invoice_terms' => $invoice_record['invoice_terms'],
							'invoice_images_photographers' => $invoice_record['invoice_images_photographers'],
							'invoice_status' => $invoice_record['invoice_status'],
							'invoice_type' => $invoice_record['invoice_type'],
							'invoice_comments' => $invoice_record['invoice_comments'],
							'invoice_createdby' => $invoice_record['invoice_createdby'],
							'invoice_created_date' => $invoice_record['invoice_created_date'],
							'invoice_updatedby' => $invoice_record['invoice_updatedby'],
							'invoice_updated_date' => $invoice_record['invoice_updated_date'],
							'tbl_invoice_tax_type' => $invoice_record['tbl_invoice_tax_type'],
							'customer_gstno' => $customer_gst_no);



				$customer = array('invoice_customers_id' => $invoice_record['invoice_customers_id'],
				'invoice_customers_name' => $invoice_record['invoice_customers_name'],
				'invoice_customers_company' => $invoice_record['invoice_customers_company'],
				'invoice_customers_address_line1' => $invoice_record['invoice_customers_address_line1'],
				'invoice_customers_address_line2' => $invoice_record['invoice_customers_address_line2'],
				'invoice_customers_city' => $invoice_record['invoice_customers_city'],
				'invoice_customers_postcode' => $invoice_record['invoice_customers_postcode'],
				'invoice_customers_state' => $invoice_record['invoice_customers_state'],
				'invoice_customers_country' => $invoice_record['invoice_customers_country'],
				'invoice_customers_telephone' => $invoice_record['invoice_customers_telephone'],
				'invoice_sales_person' => $invoice_record['invoice_sales_person'],
				'invoice_client_service' => $invoice_record['invoice_client_service'],
				'account_person' => $invoice_record['account_person'],
				'account_detail' => $invoice_record['account_detail'],
				'payment_mode' => $invoice_record['payment_mode'],
				'other_contacts' => $invoice_record['other_contacts'],
				'po_number' => $invoice_record['po_number'],
				'customer_gst_no' => $customer_gst_no,
				'po_date' =>  $invoice_record['po_date'],
				'invoice_jobno' =>  $invoice_record['invoice_jobno'],
				'invoice_payment_terms' => $invoice_record['invoice_payment_terms'],
				'invoice_payment_recived_date' => $invoice_record['invoice_payment_recived_date'],

				'invoice_customers_email_address' => $invoice_record['invoice_customers_email_address']);	
			}


			$index = 0;
			$sql1 = "SELECT * FROM tbl_invoice_details WHERE invoice_id='$invoice_id' ORDER BY invoice_details_id ASC";
			if($result = mysqli_query($conn, $sql1)){
				while($invoice_row = mysqli_fetch_array($result)){

					$invoice_details[$index] = array('invoice_details_id' => $invoice_row['invoice_details_id'],
					'invoice_id' => $invoice_row['invoice_id'],
					'invoice_details_description' => $invoice_row['invoice_details_description'],
					'invoice_qty' => $invoice_row['invoice_qty'],
					'invoice_rate' => $invoice_row['invoice_rate'],
					'invoice_amount' => $invoice_row['invoice_amount'],
					'photographer_id' => $invoice_row['photographer_id'],
					'photographer_commission' => $invoice_row['photographer_commission'],
					'indiapicture_commission' => $invoice_row['indiapicture_commission'],
					'invoice_details_createdby' => $invoice_row['invoice_details_createdby'],
					'invoice_details_created_date' => $invoice_row['invoice_details_created_date'],
					'invoice_details_updatedby' => $invoice_row['invoice_details_updatedby'],
					'image_id' => $invoice_row['image_id'],
					'collection' => $invoice_row['collection'],
					'image_type' => $invoice_row['image_type'],
					'rf_image_size' => $invoice_row['rf_image_size'],
					'invoice_mrelease' => $invoice_row['invoice_mrelease'],
					'invoice_prelease' => $invoice_row['invoice_prelease'],
					'image_usage' => $invoice_row['image_usage'],
					'specific_use' => $invoice_row['specific_use'],
					'size' => $invoice_row['size'],
					'circulation' => $invoice_row['circulation'],
					'placement' => $invoice_row['placement'],
					'duration' => $invoice_row['duration'],
					'start_date' => $invoice_row['start_date'],
					'end_date' => $invoice_row['end_date'],
					'territory' => $invoice_row['territory'],
					'end_client' => $invoice_row['end_client'],
					'discount'   => $invoice_row['discount'],
					'cash_back' => $invoice_row['cash_back'],
					'handling_charges' => $invoice_row['handling_charges'],
					'discounted_amount'  => $invoice_row['discounted_amount'],
					'cashbacked_amount' => $invoice_row['cashbacked_amount'],
					'handlingchared_amount' => $invoice_row['handlingchared_amount'],
					'handling_type' => $invoice_row['handling_type'],
					'handling_type_charge' => $invoice_row['handling_type_charge'],
					'handling_type_amount' => $invoice_row['handling_type_amount'],
					'final_img_price' => $invoice_row['final_img_price'],
					'invoice_details_updated_date ' => $invoice_row['invoice_details_updated_date']);

					$invoice_totals += $invoice_row['invoice_amount'];
					$photographer_comm_totals += $invoice_row['photographer_commission'];
					$ip_comm_totals += $invoice_row['indiapicture_commission'];
					$index++;
				}
			}

			return array('info'=>$info, 'invoice_totals'=> $invoice_totals, 'photographer_comm_totals'=>$photographer_comm_totals, 'ip_comm_totals'=>$ip_comm_totals,  'invoice_details'=>$invoice_details, 'customer'=>$customer,'invoice_amount_totals'=>$invoice_amount_totals);
	}

	function disp_quatation($invoice_id,$conn){
		$sql_quotation_details = "SELECT sum(discounted_amount) as dis_amt FROM tbl_invoice_details WHERE invoice_id = '$invoice_id'";
		$result_quotation_details = mysqli_query($conn,$sql_quotation_details);
		return $disp_quotation = mysqli_fetch_array($result_quotation_details);
	}

	function sql_qutation_detail($invoice_id,$conn){
		$sql_quotation_details = "SELECT * FROM tbl_invoice_details WHERE invoice_id = '$invoice_id'";
		$result_quotation_details = mysqli_query($conn,$sql_quotation_details);
		return $quotation_detail = mysqli_fetch_array($result_quotation_details);
	}

	function quatationNot(){

		$info = array();
		$invoice_details = array();
		$customer = array();
		$invoice_amount_totals = 0;
		$photographer_comm_totals=0;
		$ip_comm_totals=0;

		return array('info'=>$info, 'invoice_details'=>$invoice_details, 'customer'=>$customer, 'invoice_amount_totals'=>$invoice_amount_totals, 'photographer_comm_totals'=>$photographer_comm_totals, 'ip_comm_totals'=>$ip_comm_totals);
	}

	function invoiceData($invoice_id,$financial_year,$conn){
		// $conn = new mysqli("indiapicture.ci18uyfr1mrf.ap-south-1.rds.amazonaws.com","indiapicture","!9Waha77a!nd!a","indiapicture");

		// // Check connection
		// if ($conn -> connect_errno) {
		//   echo "Failed to connect to MySQL: " . $conn -> connect_error;
		//   exit();
		// }


		$invoice_totals=0;
		$photographer_comm_totals=0;
		$ip_comm_totals=0;
		$invoice_amount_totals = 0;

		$sql = "SELECT * FROM tbl_invoice_final WHERE invoice_id='$invoice_id' AND financial_year='$financial_year'";
		if($result = mysqli_query($conn, $sql)) {
			$invoice_record = mysqli_fetch_array($result);
				$info = array('invoice_id' => $invoice_record['invoice_id'],
				'invoice_id_final' => $invoice_record['invoice_id_final'],
				'invoice_id_vat' => $invoice_record['invoice_id_vat'],
				'financial_year' => $invoice_record['financial_year'],
				'invoice_orders_amount' => $invoice_record['invoice_orders_amount'],
				'invoice_orders_tax_text' => $invoice_record['invoice_orders_tax_text'],
				'invoice_orders_tax' => $invoice_record['invoice_orders_tax'],
				'invoice_orders_discount_text' => $invoice_record['invoice_orders_discount_text'],
				'orders_amount_distotals' => $invoice_record['orders_amount_distotals'],
				'orders_amount_afterdistotals' => $invoice_record['orders_amount_afterdistotals'],
				'invoice_region'=>$invoice_record['invoice_region'],
				'invoice_education_cess_hidden' => $invoice_record['invoice_education_cess_hidden'],
				'order_education_cess' => $invoice_record['order_education_cess'],
				'invoice_high_education_cess_hidden' => $invoice_record['invoice_high_education_cess_hidden'],
				'order_high_education_cess' => $invoice_record['order_high_education_cess'],
				'swachh_bharat_cess' => $invoice_record['swachh_bharat_cess'],
				'swachh_bharat_cess_hidden' => $invoice_record['swachh_bharat_cess_hidden'],
				'krishi_kalyan_cess' => $invoice_record['krishi_kalyan_cess'],
				'krishi_kalyan_cess_hidden' => $invoice_record['krishi_kalyan_cess_hidden'],
				'invoice_orders_tax_text_cgst' => $invoice_record["invoice_orders_tax_text_cgst"],
				'invoice_orders_cgst' => $invoice_record["invoice_orders_cgst"],
				'invoice_orders_tax_text_sgst' => $invoice_record["invoice_orders_tax_text_sgst"],
				'invoice_orders_sgst' => $invoice_record["invoice_orders_sgst"],
				'invoice_orders_tax_text_igst' => $invoice_record["invoice_orders_tax_text_igst"],
				'invoice_orders_igst' => $invoice_record["invoice_orders_igst"],
				'invoice_orders_tax_text_utgst' => $invoice_record["invoice_orders_tax_text_utgst"],
				'invoice_orders_utgst' => $invoice_record["invoice_orders_utgst"],
						
				'invoice_orders_total' => $invoice_record['invoice_orders_total'],
				'photographer_amount' => $invoice_record['photographer_amount'],
				'photographer_tax' => $invoice_record['photographer_tax'],
				'photographer_total' => $invoice_record['photographer_total'],
				'ip_amount' => $invoice_record['ip_amount'],
				'ip_tax' => $invoice_record['ip_tax'],
				'ip_total' => $invoice_record['ip_total'],
				'discount' => $invoice_record['discount'],
				'discounted_amount' => $invoice_record['discounted_amount'],
				'cash_back' => $invoice_record['cash_back'],
				'cashbacked_amount' => $invoice_record['cashbacked_amount'],
				'handling_charges' => $invoice_record['handling_charges'],
				'handlingchared_amount' => $invoice_record['handlingchared_amount'],
				'tbl_invoice_tax_type' => $invoice_record['tbl_invoice_tax_type'],
				'customer_gstno' => $invoice_record['customer_gstno'],
				'invoice_vat' => $invoice_record['invoice_vat'],
				'invoice_vat_taxvalue' => $invoice_record['invoice_vat_taxvalue'],

				'invoice_date' => $invoice_record['invoice_date'],
				'invoice_due_date' => $invoice_record['invoice_due_date'],
				'invoice_terms' => $invoice_record['invoice_terms'],
				'invoice_images_photographers' => $invoice_record['invoice_images_photographers'],
				'invoice_status' => $invoice_record['invoice_status'],
				'invoice_type' => $invoice_record['invoice_type'],
				'invoice_comments' => $invoice_record['invoice_comments'],
				'invoice_createdby' => $invoice_record['invoice_createdby'],
				'invoice_created_date' => $invoice_record['invoice_created_date'],
				'invoice_updatedby' => $invoice_record['invoice_updatedby'],
				'invoice_updated_date' => $invoice_record['invoice_updated_date']);



				$customer = array('invoice_id_final' => $invoice_record['invoice_id_final'],
				'invoice_id_vat' => $invoice_record['invoice_id_vat'],
				'invoice_customers_id' => $invoice_record['invoice_customers_id'],
				'invoice_customers_name' => $invoice_record['invoice_customers_name'],
				'invoice_customers_company' => $invoice_record['invoice_customers_company'],
				'invoice_customers_address_line1' => $invoice_record['invoice_customers_address_line1'],
				'invoice_customers_address_line2' => $invoice_record['invoice_customers_address_line2'],
				'invoice_customers_city' => $invoice_record['invoice_customers_city'],
				'invoice_customers_postcode' => $invoice_record['invoice_customers_postcode'],
				'invoice_customers_state' => $invoice_record['invoice_customers_state'],
				'invoice_customers_country' => $invoice_record['invoice_customers_country'],
				'invoice_customers_telephone' => $invoice_record['invoice_customers_telephone'],
				'invoice_sales_person' => $invoice_record['invoice_sales_person'],
				'invoice_client_service' => $invoice_record['invoice_client_service'],
				'account_person' => $invoice_record['account_person'],
				'account_detail' => $invoice_record['account_detail'],
				'purchase_detail' => $invoice_record['purchase_detail'],
				'payment_mode' => $invoice_record['payment_mode'],
				'other_contacts' => $invoice_record['other_contacts'],
				'po_number' => $invoice_record['po_number'],
				'customer_gst_no' => '',
				'po_date' => $invoice_record['po_date'],
				'invoice_jobno' => $invoice_record['invoice_jobno'],
				'invoice_payment_terms' => $invoice_record['invoice_payment_terms'],
				'invoice_payment_recived_date' => $invoice_record['invoice_payment_recived_date'],
				'transaction_id' => $invoice_record['transaction_id'],

				'invoice_customers_email_address' => $invoice_record['invoice_customers_email_address']);
				
			}


			$index = 0;
			$sql1 = "SELECT * FROM tbl_invoice_details WHERE invoice_id='$invoice_id' ORDER BY invoice_details_id ASC";
			if($result = mysqli_query($conn, $sql1)){
				while($invoice_row = mysqli_fetch_array($result)){

					$invoice_details[$index] = array('invoice_details_id' => $invoice_row['invoice_details_id'],
					'invoice_id' => $invoice_row['invoice_id'],
					'invoice_details_description' => $invoice_row['invoice_details_description'],
					'invoice_qty' => $invoice_row['invoice_qty'],
					'invoice_rate' => $invoice_row['invoice_rate'],
					'invoice_amount' => $invoice_row['invoice_amount'],
					'photographer_id' => $invoice_row['photographer_id'],
					'photographer_commission' => $invoice_row['photographer_commission'],
					'indiapicture_commission' => $invoice_row['indiapicture_commission'],
					'invoice_details_createdby' => $invoice_row['invoice_details_createdby'],
					'invoice_details_created_date' => $invoice_row['invoice_details_created_date'],
					'invoice_details_updatedby' => $invoice_row['invoice_details_updatedby'],
					'image_id' => $invoice_row['image_id'],
					'collection' => $invoice_row['collection'],
					'image_type' => $invoice_row['image_type'],
					'rf_image_size' => $invoice_row['rf_image_size'],
					'invoice_mrelease' => $invoice_row['invoice_mrelease'],
					'invoice_prelease' => $invoice_row['invoice_prelease'],
					'image_usage' => $invoice_row['image_usage'],
					'specific_use' => $invoice_row['specific_use'],
					'size' => $invoice_row['size'],
					'circulation' => $invoice_row['circulation'],
					'placement' => $invoice_row['placement'],
					'duration' => $invoice_row['duration'],
					'start_date' => $invoice_row['start_date'],
					'end_date' => $invoice_row['end_date'],
					'territory' => $invoice_row['territory'],
					'end_client' => $invoice_row['end_client'],
					'discount'   => $invoice_row['discount'],
					'cash_back' => $invoice_row['cash_back'],
					'handling_charges' => $invoice_row['handling_charges'],
					'discounted_amount'  => $invoice_row['discounted_amount'],
					'cashbacked_amount' => $invoice_row['cashbacked_amount'],
					'handlingchared_amount' => $invoice_row['handlingchared_amount'],
					'handling_type' => $invoice_row['handling_type'],
					'handling_type_charge' => $invoice_row['handling_type_charge'],
					'handling_type_amount' => $invoice_row['handling_type_amount'],
					'final_img_price' => $invoice_row['final_img_price'],
					'invoice_details_updated_date ' => $invoice_row['invoice_details_updated_date']);

					$invoice_totals += $invoice_row['invoice_amount'];
					$photographer_comm_totals += $invoice_row['photographer_commission'];
					$ip_comm_totals += $invoice_row['indiapicture_commission'];
					$index++;
				}
			}

			return array('info'=>$info, 'invoice_totals'=> $invoice_totals, 'photographer_comm_totals'=>$photographer_comm_totals, 'ip_comm_totals'=>$ip_comm_totals,  'invoice_details'=>$invoice_details, 'customer'=>$customer,'invoice_amount_totals'=>$invoice_amount_totals);
	}

	function invoiceNot(){

		$info = array();
		$invoice_details = array();
		$customer = array();
		$invoice_amount_totals = 0;
		$photographer_comm_totals=0;
		$ip_comm_totals=0;

		return array('info'=>$info, 'invoice_details'=>$invoice_details, 'customer'=>$customer, 'invoice_amount_totals'=>$invoice_amount_totals, 'photographer_comm_totals'=>$photographer_comm_totals, 'ip_comm_totals'=>$ip_comm_totals);
	}

	function invoiceQrCode($financial_year,$conn){

		$sql = "SELECT * FROM tbl_e_invoice WHERE docNo='$financial_year'";
		$result_qr_details = mysqli_query($conn,$sql);
		return $qr_detail = mysqli_fetch_array($result_qr_details);
	}
}
?>


<?php


?>
