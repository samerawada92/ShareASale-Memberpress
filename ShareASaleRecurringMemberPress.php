<?php
// ShareASale Recurring Transaction Tracking For MemberPress
function shareASaleTrackRecurring($txn){

	global $wpdb;
	$amount = $txn->amount;
	$amount = round( floatval($amount), 2 );
	$trans_user_id = $txn->user_id;
	$trans_num = $txn->trans_num;

	// Get user's First Transaction & Date From Database
	$transactions = $wpdb->get_results('SELECT * FROM wp_mepr_transactions WHERE user_id='.$trans_user_id) ;
	$count_trans = 0;
	$created_at = [];
	$db_trans_num = [];

	foreach ($transactions as $trans) {
		$count_trans++;
		array_push($created_at, $trans->created_at);
		array_push($db_trans_num, $trans->trans_num);
	}

	$first_transaction_number = $db_trans_num[0]; //This is the transaction that must exist in ShareaSale. Initially created in the frontend on first purchase.

	$date = $created_at[0];
	$date = str_replace("-", "/", $date);
	$date_index = strpos($date, "/");
	$date_part_one = substr($date, 0, $date_index);
	$date_part_two = substr($date, $date_index, $date_index+2);
	$date_formatted = $date_part_two . "/" . $date_part_one;
	$date_formatted = substr($date_formatted, 1); //This is the Formatted Date of the first Transaction

	// Begin API CALL ------
	$myMerchantID = '80230';
	$APIToken = "XWk5nd6t8YCdrh7s";
	$APISecretKey = "FRk9ei8b7NZqbu9jXWk5nd6t8YCdrh7s";
	$myTimeStamp = gmdate(DATE_RFC1123);

	$APIVersion = 2.8;
	// $actionVerb = "bannerList";
	$actionVerb = "reference";
	$sig = $APIToken.':'.$myTimeStamp.':'.$actionVerb.':'.$APISecretKey;

	$sigHash = hash("sha256",$sig);

	$myHeaders = array("x-ShareASale-Date: $myTimeStamp","x-ShareASale-Authentication: $sigHash");

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://api.shareasale.com/w.cfm?merchantId=$myMerchantID&token=$APIToken&version=$APIVersion&action=$actionVerb&date=$date_formatted&ordernumber=$first_transaction_number&transtype=sale&amount=$amount&tracking=$trans_user_id
");
	curl_setopt($ch, CURLOPT_HTTPHEADER,$myHeaders);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, 0);

	$returnResult = curl_exec($ch);

	if ($returnResult) {
		//parse HTTP Body to determine result of request
		if (stripos($returnResult,"Error Code ")) {
			// error occurred
			trigger_error($returnResult,E_USER_ERROR);
		}
		else{
			// success
			// if ($count_trans > 1) {
				echo $returnResult;
			// }
		}
	}

	else{
		// connection error
		trigger_error(curl_error($ch),E_USER_ERROR);
	}

	curl_close($ch);

}
add_action('mepr-txn-status-complete', 'shareASaleTrackRecurring', 30, 1);
