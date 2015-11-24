<?php

class Paypal {

	protected static $_sandbox = false;

	protected $_settings = array (
		'live' => array (
			'username' => '',
			'password' => '',
			'signature' => '',
			// Do not change below this line
			'signature_endpoint' => 'https://api-3t.paypal.com/nvp',
			'certificate_endpoint' => 'https://api.paypal.com/nvp',
			'redirect' => 'https://www.paypal.com/webscr'
		),
		
		'sandbox' => array (
			'username' => '',
			'password' => '',
			'signature' => '',
			// Do not change below this line
			'signature_endpoint' => 'https://api-3t.sandbox.paypal.com/nvp',
			'certificate_endpoint' => 'https://api.sandbox.paypal.com/nvp',
			'redirect' => 'https://www.sandbox.paypal.com/webscr'
		)
	);

	protected $_SSLcertificate = './Cert/cacert.pem';

	protected $_PaypalCertificate = '';

	protected $_log = false;

	protected $_logParams = array();

	protected $_errors = array();

	protected $_paypalVersion = "82.0";
	
	protected $_itemParams = array(
		'cost' => 'AMT', //Item cost 
		'name' => 'NAME', //Item name
		'desc' => 'DESC', //Item description
		'amount' => 'QTY', //Amount of items of this type
		'tax' => 'TAXAMT', // Tax amount
		'number' => 'NUMBER', // Item number
		
		//Following parameters are available for Express Checkout only
		'url' => 'ITEMURL', //Item URL
		'category' => 'ITEMCATEGORY', // Indicates type of goods: 'Digital' or 'Physical' (default)
		'weight' => 'ITEMWEIGHTVALUE', //Item weight
		'weight_unit' => 'ITEMWEIGHTUNIT' //Weight unit
	);
	
	protected $_paymentOptions = array(
		'cost' => 'AMT', //Total cost of transaction
		'currency' => 'CURRENCYCODE', //Transaction currency, default is USD 
		'item_cost' => 'ITEMAMT', //Total cost of items in transaction, without shipping, handling or tax 
		'shipping' => 'SHIPPINGAMT', //Shipping cost
		'insurance' => 'INSURANCEAMT', //Insurance cost
		'handling' => 'HANDLINGAMT', //Handling cost
		'tax' => 'TAXAMT', //Total tax amount
		'desc' => 'DESC', //Transaction description
		'custom' => 'CUSTOM', //Custom parameter - free-text
		'invoice' => 'INVNUM', //Your own invoice or tracking number
		'ipn_url' => 'NOTIFYURL', //IPN notification URL for this transaction
		
        // Shipping address fields
        'shipping_name' => 'SHIPTONAME',
        'shipping_address' => 'SHIPTOSTREET',
        'shipping_address_2' => 'SHIPTOSTREET2',
        'shipping_city' => 'SHIPTOCITY',
        'shipping_state' => 'SHIPTOSTATE',
        'shipping_country_code' => 'SHIPTOCOUNTRYCODE',
        'shipping_country_name' => 'SHIPTOCOUNTRYNAME',
        'shipping_zipcode' => 'SHIPTOZIP',
        'shipping_phone' => 'SHIPTOPHONENUM'	
	);
    
    protected $_expressCheckoutOptions = array(
        'cancel' => 'CANCELURL', //URL to which customer is returned if he does not approve Paypal payment. - Required -
		'return' => 'RETURNURL', //URL to which customer is returned after approving Paypal payment. - Required -
		'allowed_method' => 'PAYMENTREQUEST_0_ALLOWEDPAYMENTMETHOD', //Allowed payment method. Use 'InstantPaymentOnly' to force instant payments
		'payment_action' => 'PAYMENTREQUEST_0_PAYMENTACTION', //Transaction payment action. Default is 'Sale', other values include 'Authorization' and 'Order'
		'payment_id' => 'PAYMENTREQUEST_0_PAYMENTREQUESTID', //Unique identifier of a payment request - required for parallel payments
		'no_shipping' => 'NOSHIPPING', // Shipping fields on checkout form: 0 - Show, 1 - Don't show, 2 - get address from Paypal account
        'locale' => 'LOCALECODE', // Set the locale of the Paypal checkout page (2 or 5 letter code)
		'confirm_shipping' => 'REQCONFIRMSHIPPING', // Require Paypal confirmed address: 0 - no, 1 - yes
		'allow_note' => 'ALLOWNOTE', // Allow buyer to leave a note for the merchant: 0 - no, 1 - yes (default)
        'email' => 'EMAIL', // Buyer Email - will be used to prefill the login field in the Paypal screen
        'landing_page' => 'LANDINGPAGE', // 'Billing' | 'Login' - type of Paypal page to display
		'solution_type' => 'SOLUTIONTYPE' // 'Sole' | 'Mark' - 'Sole' allows checking out without creating a Paypal account
    );
 
	protected $_recurringPaymentsOptions = array(
		'name' => 'SUBSCRIBERNAME', // Subscriber name (optional)
		'start_date' => 'PROFILESTARTDATE', // Profile start date in UTC/GMT (required)
		'profile_reference' => 'PROFILEREFERENCE', // Merchant unique identifier (optional)
		'desc' => 'DESC', // Profile description (required)
		'max_failed' => 'MAXFAILEDPAYMENTS', // Number of failed payments before profile is suspended (An IPN will be sent, optional)
		'autobill' => 'AUTOBILLOUTAMT', // Auto bill outstanding failed payments on next billing cycle (optional)

		'period' => 'BILLINGPERIOD', // Billing period interval: 'Day','Week','Month','SemiMonth','Year' (required)
		'frequency' => 'BILLINGFREQUENCY', // Billing period frequnecy. Frequency x period equaly one billing cycle and cannot exceed 1 year (required)
		'total_cycles' => 'TOTALBILLINGCYCLES', // Number of cycles to bill. Use '0' to continue indefinitely (optional)
		'cost' => 'AMT', // Billing amount per payment

		/* Trial period parameters, same function as above parameters but apply to subscription trial period */
		'trial_period' => 'TRIALBILLINGPERIOD', // Trial period interval: 'Day','Week,'Month','SemiMonth' (optional)
		'trial_frequency' => 'TRIALBILLINGFREQUENCY', // Trial billing frequency (optional)
		'trial_total_cycles' => 'TRIALTOTALBILLINGCYCLES', // Trial period total payment cycles
		'trial_cost' => 'TRIALAMT', // Trial payment amount
		/* End Trial parameters */

		/* Credit-card parameters - for updating profiles using Direct Payments only */
		'card_type' => 'CREDITCARDTYPE', // Types include: 'Visa','MasterCard','Discover','Amex','Maestro'
		'card_number' => 'ACCT', // Credit card number 
		'expiration' => 'EXPDATE', // Credit Card expiration - Digits only (MMYYYY)
		'cvv' => 'CVV2', // CVV / CVC security code

		'start_date', // Issue date for Maestro cards only
		'issue_number', // Issue number of Maestro card
		/* End Credit card parameters */

		'shipping' => 'SHIPPINGAMT', // Shipping amount per payment
		'tax' => 'TAXAMT', // Tax amount per payment
		'currency' => 'CURRENCYCODE', // Currency of payment amounts (3-character code, optional)
		'init_amount' => 'INITAMT', // Initial, non recurring amount at the start of profile. Use for setup fees and the like (optional)
		'email' => 'EMAIL', // Email address of buyer (required)
		'token' => 'TOKEN', // Express Checkout token (required if using Express Checkout)
		'payer_id' => 'PAYERID' // Paypal user identifier (required if using Express Checkout)
	);
	
	protected $_recurringPaymentDetails = array(
		'profile_id' => 'PROFILEID',
		'correlation_id' => 'CORRELATIONID',
		'status' => 'STATUS',
		'timestamp' => 'TIMESTAMP',
		'email' => 'EMAIL',
		'first_name' => 'FIRSTNAME',
		'last_name' => 'LASTNAME',
	
		// Billing cycle details
		'next_billing_date' => 'NEXTBILLINGDATE',
		'num_cycles_completed' => 'NUMCYCLESCOMPLETED',
		'num_cycles_remaining' => 'NUMCYCLESREMAINING',
		'outstanding_balance' => 'OUTSTANDINGBALANCE',
		'failed_payments' => 'FAILEDPAYMENTCOUNT',
		'last_payment_date' => 'LASTPAYMENTDATE',
		'last_payment_amount' => 'LASTPAYMENTAMT',
		'final_payment_date' => 'FINALPAYMENTDUEDATE',
		// Regular cycle payment details
		'regular_amount_paid' => 'REGULARAMTPAID',
		'regular_billing_period' => 'REGULARBILLINGPERIOD',
		'regular_billing_frequency' => 'REGULARBILLINGFREQUENCY',
		'regular_total_billing_cycles' => 'REGULARTOTALBILLINGCYCLES',
		'regular_currency_code' => 'REGULARCURRENCYCODE',
		'regular_shipping_amount' => 'REGULARSHIPPINGAMT',
		'regular_tax_amount' => 'REGULARTAXAMT',
		// Additional Trial payment details
		'trial_tax_amount' => 'TRIALTAXAMT',
		'trial_shipping_amount' => 'TRIALSHIPPINGAMT',
		'trial_currency_code' => 'TRIALCURRENCYCODE',
		'trial_amount_paid' => 'TRIALAMTPAID',
		//Total amounts collected so far
		'aggregate_amount' => 'AGGREGATEAMT', // Scheduled payments
		'aggregate_optional_amount' => 'AGGREGATEOPTIONALAMT', // Optional payments
		
		// Shipping Address
		'address_status' => 'ADDRESSSTATUS',
		'shipping_name' => 'SHIPTONAME',
		'shipping_street' => 'SHIPTOSTREET',
		'shipping_street2' => 'SHIPTOSTREET2',
		'shipping_city' => 'SHIPTOCITY',
		'shipping_state' => 'SHIPTOSTATE',
		'shipping_zip' => 'SHIPTOZIP',
		'shipping_country' => 'SHIPTOCOUNTRY',
		'shipping_country_code' => 'SHIPTOCOUNTRYCODE',
		'shipping_country_name' => 'SHIPTOCOUNTRYNAME',
		'shipping_address_status' => 'SHIPADDRESSSTATUS',
		'shipping_address_owner' => 'SHIPADDRESSOWNER'
	);


	protected $_directPaymentOptions = array(
		'card_type' => 'CREDITCARDTYPE', //Credit card type. Acceptable values - 'Visa','MasterCard','Discover','Amex','Maestro','Solo'
		'card_number' => 'ACCT', //Credit card number
		'expiry_date' => 'EXPDATE', //Credit card expiration date. The format should be MMYYYY. 
		'cvv' => 'CVV2', //Card verification value
		'first_name' => 'FIRSTNAME', //First name of card holder
		'last_name' => 'LASTNAME', //Last name of card holder
		'street' => 'STREET', //Street address
		'street2' => 'STREET2', // Street address 2 (optional)
		'city' => 'CITY', //City
		'state' => 'STATE', //State (if country is US)
		'zipcode' => 'ZIP',//Zipcode
		'country' => 'COUNTRYCODE'//Two letter country code
	);
	
 
    protected $_checkoutDetailsParams = array(
        'status' => 'CHECKOUTSTATUS',
        'timestamp' => 'TIMESTAMP',
        'correlation_id' => 'CORRELATIONID',
        'payer_id' => 'PAYERID',
        'payer_status' => 'PAYERSTATUS',
        'address_status' => 'ADDRESSSTATUS',
        'business' => 'BUSINESS'
    );
    

	protected $_checkoutDetails = null;

	public static function sandbox($yes = false) {
		self::$_sandbox = $yes;
	}
	
	protected function getOption($key) {
		$env = self::$_sandbox ? 'sandbox' : 'live';
		if($key == 'endpoint') {
			$key = isset($this -> _settings[$env]['signature']) ?
					('signature_' . $key)
				  : ('certificate_' . $key);
		}
		return isset($this -> _settings[$env][$key]) ? $this -> _settings[$env][$key] : false;
	}
	

	public function setLiveCredentials($credentials = array()) {
		$this -> _settings['live'] = array_merge($this -> _settings['live'],$credentials);
	}
	
	public function getCheckoutUrl($options = array(),$items = array()) {
		$result = $this -> getExpressCheckoutToken($options,$items);
		if(is_string($result) && !empty($result)) {
			return $this -> getOption('redirect') . '?cmd=_express-checkout&token=' . urlencode($result)
				. (isset($options['useraction']) ? ('&useraction=' . $options['useraction']) : '');
		} else {
			return $result;
		}
	}
	public function getExpressCheckoutToken($options = array(),$items = array()) {
		
		$errors = $this -> checkCheckoutErrors($options,$items);
		if(!empty($errors)) {
			$this -> _errors = $errors;
			return false;
		}
		
		$nvp = $this ->_buildExpressCheckoutNVP($options, $items);
		
		$nvpstr = implode('&',$nvp);
	    $result = $this -> apiCall("SetExpressCheckout", $nvpstr);
		if(is_array($result) && strtolower($result['ACK']) == "success") {		
			return $result["TOKEN"];
		} else {
			return false;
		}
	}
    
 
    protected function _buildExpressCheckoutNVP($options = array(),$items = array()) {
        $nvp = array();
        	
		if(!empty($items)) {
			if(isset($items['cost']) || isset($items['subscription_description'])) {
				$items = array($items);			
			} 
			$cost = 0;
			$tax = 0;
			$subscriptions = 0;
			foreach($items as $n => $item) {
				$amount = isset($item['amount']) ? (int) $item['amount'] : 1;
				foreach($this -> _itemParams as $key => $paypalKey) {
					if(isset($item[$key])) {
						$nvp[] = "L_PAYMENTREQUEST_0_" . $paypalKey . $n . "=" . urlencode($item[$key]);
					}
				}
				if(!isset($item['amount'])) {
					$nvp[] = "L_PAYMENTREQUEST_0_QTY" . $n . "=" . $amount;
				}
				$cost += isset($item['cost']) ? ($item['cost'] * $amount) : 0;
				if(isset($item['tax'])) {
					$tax += $item['tax'] * $amount;
				}
				if(isset($item['subscription_description'])) {
					
					$nvp[] = 'L_BILLINGAGREEMENTDESCRIPTION' . $subscriptions . '=' . urlencode($item['subscription_description']);
					$nvp[] = 'L_BILLINGTYPE' . $subscriptions .'=RecurringPayments';
					$subscriptions++;
				}
			}
			$additionalCosts = 0;
			if(!isset($options['tax']) && $tax > 0) {
				$options['tax'] = $tax;
			}
			
			foreach(array('shipping','tax','insurance','handling') as $key) {
				if(isset($options[$key])) {
					$additionalCosts += $options[$key];
				}
			}
			
			if(!isset($options['cost']) && isset($cost)) {
				$nvp[] = "PAYMENTREQUEST_0_AMT=" . ($cost + $additionalCosts);
			}

			//Auto add ITEMAMT if required and available
			if(!isset($options['item_cost']) && $additionalCosts > 0) {
				$nvp[] = "PAYMENTREQUEST_0_ITEMAMT=" . $cost;
			}
			
		}
		foreach($this -> _paymentOptions as $key => $paypalKey) {
			if(isset($options[$key]) && $options[$key] !== '') {
				$paypalKey = 'PAYMENTREQUEST_0_' . $paypalKey;
				$nvp[] = $paypalKey . '=' . urlencode($options[$key]);
			}
		}
        foreach($this -> _expressCheckoutOptions as $key => $paypalKey) {
            if(isset($options[$key]) && $options[$key] !== '') {
				$nvp[] = $paypalKey . '=' . urlencode($options[$key]);
			}
        }
        return $nvp;
    }
	
	protected function checkCheckoutErrors($options = array(),$items = array()) {
		$errors = array();
		if(!isset($options['return'])) {
			$errors['return'] = 'Return URL must be provided';
		}
		if(!isset($options['cancel'])) {
			$errors['cancel'] = 'Cancellation URL must be provided';
		}
		if(empty($items) && !isset($options['cost'])) {
			$errors['items'] = 'No items or cost provided - cannot determine transaction cost';
		}
		return $errors;
	}

	/**
	 * Get checkout details from checkout token
	 *
	 * @param string $token Optionally taken from $_GET array
     * @param bool $extraParams Add $_checkoutDetailsParams to returned data
	 * @return array / boolean Checkout details or request failure
	 */
	public function getCheckoutDetails( $token = null, $extraParams = false) {
		if(empty($token) && isset($_GET['token'])) {
			$token = $_GET['token'];
		}
	    $nvpstr = "TOKEN=" . $token;
	    $result = $this -> apiCall("GetExpressCheckoutDetails",$nvpstr);
	    if(is_array($result)) {
	    	$data = array();
	    	foreach(
                $this -> _paymentOptions + 
                $this -> _expressCheckoutOptions + 
                $this -> _directPaymentOptions + 
                $this -> _checkoutDetailsParams as 
                    $key => $paypalKey) {
				if(isset($result[$paypalKey])) {
					$data[$key] = $result[$paypalKey];
				} else if(isset($result['PAYMENTREQUEST_0' . $paypalKey])) {
                    $data[$key] = $result['PAYMENTREQUEST_0' . $paypalKey];
                }
			}
			$i = 0;
			$items = array();
			while(isset($result['L_PAYMENTREQUEST_0_AMT' . $i])) {
				foreach($this -> _itemParams as $key => $paypalKey) {
					if(isset($result['L_PAYMENTREQUEST_0_' . $paypalKey . $i])) {
						$items[$i][$key] = $result['L_PAYMENTREQUEST_0_' . $paypalKey . $i]; 
					}
				}
				$i++;
			}
			$data['items'] = $items;
			$this -> _checkoutDetails = $data;
			return $data;
	    }
		return $result;
	}
	
	/**
	 * Confirm checkout payment amount
	 * - Uses payment confirmation token and Payer ID
	 * - If getCheckoutDetails() is called prior to calling this method, some 
     *   details such as 'cost','currency' and $items will be filled out from 
     *   that data if not provided.
     * 
	 * @param array $options An array of optional parameters
	 *   - 'token' => Token returned from Paypal after user confirms payment
	 *   - 'payer_id' => Payer ID returned from Paypal after user confirms payment
	 * @param array $items
	 * @return string / boolean Transaction ID or Confirmation failure
	 */
	public function confirmCheckoutPayment($options = array(),$items = array()) {	   
		$token = isset($options['token']) ? $options['token'] : $_GET['token'];
		$payerID = isset($options['payer_id']) ? $options['payer_id'] : $_GET['PayerID'];
        
        foreach(array('cost','currency','shipping','tax','insurance','handling','item_cost') as $key) {
            if(!isset($options[$key]) && is_array($this -> _checkoutDetails) && isset($this -> _checkoutDetails[$key])) {
                $options[$key] = $this -> _checkoutDetails[$key];
            }
        }
        if(empty($items) && is_array($this -> _checkoutDetails) && isset($this -> _checkoutDetails['items'])) {
            $items = $this -> _checkoutDetails['items'];
        }
        
        if(empty($items) && !isset($options['cost'])) {
			return array('cost' => 'No items or cost provided - cannot determine transaction cost');
		}
        
		$options['payment_action'] = isset($options['payment_action']) ? $options['payment_action'] : 'Sale';
		$nvp = $this ->_buildExpressCheckoutNVP($options, $items);
		
		$nvpstr  = 'TOKEN=' . $token . '&PAYERID=' . $payerID . '&IPADDRESS=' . urlencode($_SERVER['SERVER_NAME'])
                . '&' . implode('&',$nvp); 
		
		$result = $this -> apiCall("DoExpressCheckoutPayment",$nvpstr);
		if(is_array($result) && "success" == strtolower($result["ACK"])) {
			return $result['PAYMENTINFO_0_TRANSACTIONID'];
		} else {
			return false;
		}
	}
	
	/**
	 * Create recurring payments profile
	 * - Uses payment confirmation token and Payer ID. Those can be passed or they will be taken automatically
	 *   from the GET array.
	 * 
	 * @param array $data Recurring profile data
	 *   - 'cost' => Billing amount for each billing cycle on payment date. Does not include shipping or tax
	 *   - 'shipping' => Shipping amount for each billing cycle on payment date.
	 *   - 'tax' => Tax amount for each billing cycle on payment date.
	 *   - 'currency' => Currency of payment amounts
	 *   - 'start_date' => Payments start date in UTC/GMT format. Example: "2011-03-05T03:00:00"
	 *   - 'desc' => Description of billing agreement. Must be the same value used when acquiring the checkout token
	 *   - 'period' => Recurring interval period. Acceptable values include: 
	 *       * 'Day'
	 *       * 'Week'
	 *       * 'SemiMonth' (1st and 15th each month)
	 *       * 'Month'
	 *       * 'Year'
	 *   - 'frequency' => Number of periods that make up one billing cycle (up to 1 year). For example, if billing period is 'Month', frequency can be 12 or less. If we want to bill every two months, frequency will be 2 and period will be 'Month'
	 *     Similarly, for billing period 'Week' frequency can be 52 or less. 
	 *     For 'SemiMonth' frequency must be 1
	 *   - 'total_cycles' => Total billing cycles for profile. Default is 0 which continues indefinitely
	 *   - 'token' => Token returned from Paypal after user confirms payment (optional, taken from $_GET array)
	 *   - 'payer_id' => Payer ID returned from Paypal after user confirms payment (optional, taken from $_GET array)
	 *
	 * 
	 * @return string / boolean Profile ID or Confirmation failure
	 */
	public function createRecurringProfile($data = array()) {
		$nvp = array();
		foreach(array('token' => 'token','payer_id' => 'PayerID') as $key => $paypalKey) {
			if(!isset($data[$key]) && isset($_GET[$paypalKey])) {
				$data[$key] = $_GET[$paypalKey];
			}
		}
		
		foreach( ($this -> _recurringPaymentsOptions + $this -> _directPaymentOptions) as $key => $paypalKey) {
			if(isset($data[$key])) {
				$nvp[] = $paypalKey . '=' . urlencode($data[$key]);
			}
		}
		
		$nvpstr = implode('&',$nvp);
		$result = $this -> apiCall("CreateRecurringPaymentsProfile",$nvpstr);
		if(is_array($result) && "success" == strtolower($result["ACK"])) {
			return $result['PROFILEID'];
		} else {
			return false;
		}
	}
	
	/**
	 * Get recurring profile details
	 * 
	 * @param string $profileId 
	 * @param boolean $paramFormat Pass true to reformat Paypal parameter names to an easier to read format (optional)
	 * @return array / boolean Details array on success, boolean false on failure
	 */
	public function getRecurringProfile($profileId,$paramFormat = true) {
		$nvpstr = 'PROFILEID=' . urlencode($profileId);
		$result = $this -> apiCall("GetRecurringPaymentsProfileDetails",$nvpstr);
		if(is_array($result) && $paramFormat) {
			
			$reformat = $this -> _recurringPaymentDetails + $this -> _recurringPaymentsOptions;
			$reformat = array_flip($reformat);
			$reformat['REGULARAMT'] = 'cost';
			foreach($result as $key => $val) {
				if(isset($reformat[$key])) {
					$result[$reformat[$key]] = $val;
					unset($result[$key]);
				} 						
			}
		}
		return $result;
	}
	
	/**
	 * Change recurring profile status
	 * 
	 * Recurring profiles can be changed from active status to suspended and vice-versa. Active and suspended 
	 * profiles can be cancelled. Cancelled profiles cannot be changed further.
	 * 
	 * @param string $profileId
	 * @param string $action Possible values: 'Cancel','Suspend','Reactivate'
	 * @param string $note Reason for change (appears in Paypal profile, optional)
	 * @return boolean True on success, false on failure. Use getErrors() to see failure reasons
	 */
	public function changeRecurringProfileStatus($profileId,$action,$note = null) {
		$nvp = array(
			'PROFILEID=' . urlencode($profileId),
			'ACTION=' . urlencode($action)
		);
		if(!empty($note)) {
			$nvp[] = 'NOTE=' . urlencode($note);
		}
		$nvpstr = implode('&',$nvp);
		$result = $this -> apiCall("ManageRecurringPaymentsProfileStatus",$nvpstr);
		if(is_array($result) && $result['ACK'] == 'Success') {
			return true;
		}
		return false;
	}
	
	/**
	 * Change recurring profile details
	 * @see createRecurringProfile() for more details on the different parameters that can be controlled through the $data array
	 * Also @see Paypal API reference for detailed information on which parameters can be changed - 
	 * https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_nvp_r_UpdateRecurringPaymentsProfile
	 * @param string $profileId Recurring profile identifier
	 * @param array $data Recurring profile changes, in the same format as in createRecurringProfile
	 * @return boolean Success of update operation
	 */
	public function updateRecurringProfile($profileId,$data = array()) {
		$nvp = array(
			'PROFILEID=' . urlencode($profileId)
		);
		
		foreach($this -> _recurringPaymentsOptions as $key => $paypalKey) {
			if(isset($data[$key])) {
				$nvp[] = $paypalKey . '=' . urlencode($data[$key]);
			}
		}
		
		$nvpstr = implode('&',$nvp);
		$result = $this -> apiCall("UpdateRecurringPaymentsProfile",$nvpstr);
		if(is_array($result) && $result['ACK'] == 'Success') {
			return true;
		}
		return false;
	}

	/**
	 * Perform direct Payment (Website payments pro)
	 * 
	 * Payment amount can be passed either through the $data 'cost' parameter
	 * or calculated from the cost total of the items passed through the $items parameter, if provided
	 * @see $_paymentOptions and $_directPaymentOptions for more details.
	 * 
	 * @param array $data Order information, usually passed from the $_POST array 
	 * @param array $items Optional cart items to display in the Paypal charge (formatted the same as with the Express Checkout methods)
	 * @return string / boolean : Transaction ID / Payment failure
	 */
	public function directPayment(array $data,$items = array()) {

		$nvp = array();
		if(isset($data['expiry_month']) && isset($data['expiry_year'])) {
			$data['expiry_date'] = $data['expiry_month'] . $data['expiry_year'];
		}
				
		if(!empty($items)) {
			$cost = 0;
			$tax = 0;
			if(isset($items['cost'])) {
				$items = array($items);
			}
			foreach($items as $n => $item) {
				$amount = isset($item['amount']) ? (int) $item['amount'] : 1;
				foreach($this -> _itemParams as $key => $paypalKey) {
					if(isset($item[$key])) {
						$nvp[] = "&L_" . $paypalKey . $n . "=" . urlencode($item[$key]);
					}
				}
				if(!isset($item['amount'])) {
					$nvp[] = "L_QTY" . $n . "=" . $amount;
				}
				$cost += $item['cost'] * $amount;
				if(isset($item['tax'])) {
					$tax += $item['tax'] * $amount;
				}
			}
		}
		
		if(!isset($data['tax']) && $tax > 0) {
			$data['tax'] = $tax;
		}
		
		$params = array_merge($this -> _directPaymentOptions,$this -> _paymentOptions);
		foreach($params as $key => $paypalKey){
			if(isset($data[$key]) && !empty($data[$key])) {
				$nvp[] = $paypalKey . '=' . urlencode($data[$key]);
			}
		}
		$nvp = "IPADDRESS=" . $this -> getRemoteAddr() . '&' . implode('&',$nvp);
		
		$additionalCosts = 0;
		
		foreach(array('shipping','tax','insurance','handling') as $key) {
			if(isset($data[$key])) {
				$additionalCosts += $data[$key];
			}
		}
		//Auto add ITEMAMT if required and available
		if(!isset($data['item_cost']) && $additionalCosts > 0) {
			$nvp .= "&ITEMAMT=" . number_format($cost,2,'.',',');
		}
		
		if(!isset($data['cost']) && isset($cost)) {
			$nvp .= '&AMT=' . number_format($cost + $additionalCosts,2,'.',',');
		}
		
		$result = $this -> apiCall("DoDirectPayment",$nvp);
		
		if(strtolower($result['ACK']) == 'success') {
			return $result['TRANSACTIONID'];
		} else {
			return false;
		}
	}

	/**
	 * Refund Paypal transaction
	 * 
	 * Optional parameters: ($options)
	 * - 'invoice_id' => Invoice or tracking number (for documentation purposes only)
	 * - 'refund_type' => One of several refund types. 'Full' is used by default
	 *     * 'Full' - full refund
	 *     * 'Partial' - partial refund (specify amount using 'amt' - see below)
	 *     * 'ExternalDispute' - External dispute resolution
	 *     * 'Other' - Other type of refund
	 * - 'amt' => Amount of refund in case 'Partial' refund type is used. It will be in the currency specified by 'currency'
	 * - 'currency' => The currency to use for the 'amt' field with partial refunds
	 * - 'note' => Custom note about the refund (for documentation purposes)
	 * - 'source' => Source of funds for sending the refund.
	 *     * 'any' - Use any available fund source
	 *     * 'default' - Use default funding source, as defined in merchant configuration
	 *     * 'instant' - Use merchant's balance as funding source
	 *     * 'eCheck' - Use an eCheck to fund the refund amount. Uses Paypal balance if available
	 * 
	 * @param string $transactionId Identifier of original transaction
	 * @param array $options Additional options (*see above)
	 *
	 * @return string / boolean Refund transaction ID or false on failure
	 */
	public function refund($transactionId,$options = array()) {
		$nvp = array();
		$nvp[] = 'TRANSACTIONID=' . $transactionId;
		$paypalKeys = array(
			'invoice_id' => 'INVOICEID', 'refund_type' => 'REFUNDTYPE', 'amt' => 'AMT', 'currency' => 'CURRENCYCODE',
			'note' => 'NOTE', 'source' => 'REFUNDSOURCE'
		);
		foreach($paypalKeys as $key => $paypalKey) {
			if(isset($options[$key])) {
				$nvp[] = $paypalKey . '=' . $options[$key];
			}
		}
		$nvpstr = implode('&',$nvp);
		$result = $this -> apiCall("RefundTransaction",$nvpstr);
		if(is_array($result) && strtolower($result['ACK']) == 'success') {
			return $result['REFUNDTRANSACTIONID'];
		} else {
			return false;
		}
	}
	
	/**
	 * Perform mass payment API call
	 *
	 * Receives an array of payments to send in the same API call.
	 * Each member of the $payments array is an array with the following properties:
	 * - 'email' : PayPal address of payment recipient
	 * - 'amount' : Amount to pay this recipient
	 * - 'note' : Note included in payment notification Email (* optional)
	 *
	 * This method returns the Correlation ID of the mass-payment. To get the individual transaction ID
	 * for each recipient, use the IPN confirmation for the mass-payment.
	 * @see confirmIpn()
	 *
	 * @param array $payments
	 * @param string $subject Mass Payment request Email subject
	 * @param string $currency Default USD
	 * @return string / boolean Correlation ID or Payment failure
	 */
	public function masspay($payments,$subject = null,$currency = 'USD') {
		if(is_array($payments) && !empty($payments)) {
			$subject = empty($subject) ? 'Paypal payment sent' : $subject;
			$nvp = array('RECEIVERTYPE=EmailAddress','EMAILSUBJECT=' . urlencode($subject),'CURRENCYCODE=' .$currency);
			$i = 0;
			foreach($payments as $payment) {
				if(isset($payment['email']) && isset($payment['amount'])) {
					$payParams = 'L_EMAIL' . $i . '=' . urlencode($payment['email']) . '&'
						       . 'L_AMT' . $i . '=' . urlencode($payment['amount']);
					if(isset($payment['note'])) {
						$payParams .= '&L_NOTE' . $i . '=' . urlencode($payment['note']);
					}
					$nvp[] = $payParams;
					$i++;
				}
			}
			
			$result = $this -> apiCall("MassPay",implode('&',$nvp));
			if(is_array($result) && strtolower($result['ACK']) == 'success') {
				return $result['CORRELATIONID'];
			} else {
				return false;
			}
		}
	}
	
	/**
	 * Format Paypal errors
	 *
	 * @param array $response Paypal response
	 * @return array
	 */
	protected function _formatErrors($response) {
		$errors = array();
		$i = 0;
		while(isset($response['L_LONGMESSAGE' . $i])) {
			$errors[$response['L_ERRORCODE' . $i]] = $response['L_LONGMESSAGE' . $i];
			$i++;
		}
		return $errors;
	}

	protected function getCertificateLocation($param = '_SSLcertificate') {
		$certificate = $this -> $param;
		if(strpos($certificate,'./') !== false || strpos($certificate,'../') !== false) {
			$certificate = dirname(__FILE__) . '/' . $certificate;
		}
		$certificate = realpath($certificate);
		if(!is_readable($certificate)) {
			if(!is_file($certificate)) {
				throw new Exception($param . ' file not found in ' . $certificate);
			} else {
				throw new Exception($param . ' file not readable - possible permission misconfiguration (group/owner) in ' . $certificate);
			}
		}
		return $certificate;
	}

	/**
	 * Make cURL request to Paypal API
	 *
	 * Returns formatted NVP as array on success or false on error
	 * 
	 * @param string $methodName
	 * @param string $nvpStr
	 * @return array / boolean
	 */
	public function apiCall($methodName,$nvpStr) {
		if(!function_exists('curl_init')) {
			throw new Exception('cURL extension not found');
		}
		$nvpreq = "METHOD=" . urlencode($methodName) . "&VERSION=" . urlencode($this -> _paypalVersion) . "&PWD=" 
			. urlencode($this -> getOption('password')) . "&USER=" . urlencode($this -> getOption('username'));
		$sig = $this -> getOption('signature');
		if(!empty($sig)) {
			$nvpreq .= "&SIGNATURE=" . urlencode($this -> getOption('signature'));
		}
		$nvpreq .= '&' . $nvpStr ;
		$certificate = $this -> getCertificateLocation('_SSLcertificate');
		
		$ch = curl_init();
		$curlOptions = array (
			CURLOPT_URL => $this -> getOption('endpoint'),
			CURLOPT_VERBOSE => 1,
			CURLOPT_SSL_VERIFYPEER => true,
			CURLOPT_SSL_VERIFYHOST => 2,
			CURLOPT_CAINFO => $certificate,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => $nvpreq
		);
		if(empty($sig)) {
			$ppCert = $this ->getCertificateLocation('_PaypalCertificate');
			$curlOptions[CURLOPT_SSLCERT] = $ppCert;
		}
		curl_setopt_array($ch,$curlOptions);
		$response = curl_exec($ch);
	
		if (curl_errno($ch)) {
			$this -> _errors += array (
				'curl_error_no' => curl_errno($ch),
				'curl_error_msg' => curl_error($ch)
			);
		} else  {
		  	curl_close($ch);
		}
		$nvpResponse = $this -> deformatNVP($response);
		if(is_array($nvpResponse) && isset($nvpResponse['ACK']) && strtolower($nvpResponse['ACK']) != 'success') {
			$this -> _errors += $this -> _formatErrors($nvpResponse);
		}
		$this -> _log($methodName,$nvpStr,$response);
		if(!empty($this -> _errors)) {
			return false;
		}
		return $nvpResponse;
	}
	
	/**
	 * Get client IP 
	 * - Resolves for reverse proxies (nginx for example)
	 */
	public function getRemoteAddr() {
		foreach(array('HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','HTTP_X_REAL_IP','REMOTE_ADDR') as $key) {
			if(isset($_SERVER[$key]) && !empty($_SERVER[$key])) {
				$ip = $_SERVER[$key];
				$ips = explode(',',$ip);
				$ip = reset($ips);
				break;
			}
		}
		return $ip;
	}

	/**
	 * Get errors array
	 *
	 * @return array Errors array
	 */
	public function getErrors() {
		return $this -> _errors;
	}

	/** 
	 * Enable request / response logging
	 *
     * Accepts a path parameter to the log files. 
	 * - A boolean true will log relative to the Paypal class
	 * - A boolean false will disable logging (default)
	 * 
	 * @param string / boolean $path
	 * @param array $params Additional logged parameters
	 */
	public function log($path = true,$params = array()) {
		$this -> _log = $path;
		if(is_array($params)) {
			$this -> _logParams = $params;
		}
	}

	/**
	 * Log PayPal request / response
	 * 
	 * @param string $method API Method name
	 * @param string $nvp NVP string
	 * @param string $response API response
	 */
	protected function _log($method,$nvp,$response) {
		if($this -> _log === true || is_string($this -> _log)) {
			if($this -> _log === true ) {
				$path = dirname(__FILE__) . '/logs';
				if(!is_dir($path)) {
					mkdir($path,0755);
				}
			} else {
				$path = $this -> _log;
			}
			if(is_dir($path)) {
				$file = $path . '/' . date('Y-m-d_H-i-s') . '_' . $method . '_' . substr(md5(uniqid()),0,8) . '.log';
				$log = 'Logged: ' . date('M j, Y - H:i:s') . "\n\n";
				
				foreach(array('ACCT','CVV2','EXPDATE') as $key) {
					$pos = stripos($nvp,$key);
					if($pos !== false) {
						$endPos = stripos($nvp,'&',$pos + 1);
						
						$search = substr($nvp,$pos,$endPos !== false ? $endPos - $pos : null);
						if($key == 'ACCT') {
							$parts = explode('=',$search);
							$number = end($parts);
							
							$last4 = substr($number,strlen($number) - 4);
							$replace = $key . '=' . str_pad($last4, strlen($number), '*', STR_PAD_LEFT);
						} else {
							$replace = $key . '=REDACTED';
						}
						$nvp = str_replace($search,$replace,$nvp);
					}
				}
				
				$log .= 'Method: ' . $method . "\n"
					. "Request: " . $nvp . "\nFormatted Request: ";
				$args = $this -> deformatNVP($nvp);
				$log .=	print_r($args,true) . "\n\n";
				if(!empty($response)) {
					$log .= "Response: " . $response . "\nFormatted Response: ";
					$args = $this -> deformatNVP($response);
					$log .= print_r($args,true) . "\n\n";
				}
				if(!empty($_POST)) {
					$log .= '$_POST: ' . print_r($_POST,true) . "\n\n";
				}
				if(!empty($_GET)) {
					$log .= '$_GET: ' . print_r($_GET,true) . "\n\n";
				}
                $user = array();
				$ip = $this -> getRemoteAddr();
                if(!empty($ip)) {
                    $user['IP'] = $ip;
                }
                if(isset($_SERVER['HTTP_USER_AGENT']) && !empty($_SERVER['HTTP_USER_AGENT'])) {
                    $user['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                }
                if(!empty($user)) {
                    $log .= 'User: ' . print_r($user,true) . "\n\n";
                }
				if(is_array($this -> _logParams) && !empty($this -> _logParams)) {
					$log .= 'Additional parameters: ' . print_r($this -> _logParams,true);
				}
				
				file_put_contents($file,$log);
			}
		}
	}

	/**
	 * Reverse NVP string to an associative array
	 *
	 * @param string $nvpstr
	 * @return array
	 */
	public function deformatNVP($nvpstr) {
	 	$nvpArray = array();
		$parts = explode('&',$nvpstr);
	
		foreach($parts as $part) {
			if(!empty($part)) {
				$nvp = explode('=',$part);
				$nvpArray[urldecode($nvp[0])] = urldecode($nvp[1]);
			}
		}
		
		return $nvpArray;
	}
	
	/**
	 * Confirm IPN transaction
	 * 
	 * @param array $request POST request array sent from Paypal
	 * @return mixed Transaction ID(s) or false on failure
	 */
	public function confirmIpn(array $request) {
		if(empty($request)) {
			return false;
		}
		
		$params = array(0 => 'cmd=_notify-validate');
		foreach($request as $key => $val) {
			$params[] = $key . '=' . rawurlencode($val);
		}
		$curl = curl_init();
		$curlOptions = array(
			CURLOPT_URL => $this -> getOption('redirect'),
			CURLOPT_VERBOSE => 1,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => implode('&',$params)
		);
		curl_setopt_array($curl,$curlOptions);
		$response = curl_exec($curl);
		$this -> _log('notify-validate',implode('&',$params),$response);
		if(stripos($response,'VERIFIED') !== false || self::$_sandbox === true) {
			//Mass payments can have multiple Transaction IDs
			if(isset($request['masspay_txn_id_1'])) {
				$ids = array();
				$i = 1;
				while(isset($request['masspay_txn_id_' . $i])) {
					$ids[] = $request['masspay_txn_id_' . $i];
					$i++;
				}
				return $ids;
			} else if(isset($request['recurring_payment_id'])) {
				return $request['recurring_payment_id'];
			} else if(isset($request['txn_id'])) {
				return $request['txn_id'];
			}
			return true;
		} 
		return false;
	}
}