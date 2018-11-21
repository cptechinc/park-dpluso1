<?php
	use atk4\dsql\Query;
	use atk4\dsql\Expression;
	use Dplus\Base\QueryBuilder;
	use Dplus\ProcessWire\DplusWire;
	
/* =============================================================
	LOGIN FUNCTIONS
============================================================ */
	/**
	 * Returns if User is logged in
	 * @param  string $sessionID Session Identifier
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return bool              Is user logged in?
	 */
	function is_validlogin($sessionID, $debug = false) {
		$q = (new QueryBuilder())->table('logperm');
		$q->field($q->expr("IF(validlogin = 'Y', 1, 0)"));
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		
		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns Error Message for Session
	 * @param  string $sessionID Session Identifier
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return string            Error Message for Login / Session
	 */
	function get_loginerrormsg($sessionID, $debug = false) {
		$q = (new QueryBuilder())->table('logperm');
		$q->field('errormsg');
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns record for the session's Login
	 * @param  string $sessionID Session Identifier
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return array             Login Record
	 */
	function get_loginrecord($sessionID, $debug = false) {
		$q = (new QueryBuilder())->table('logperm');
		$q->field($q->expr("IF(restrictcustomers = 'Y', 1, 0) as restrictcustomers"));
		$q->field($q->expr("logperm.*"));
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			$sql->execute($q->params);
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

/* =============================================================
	LOGMPERM FUNCTIONS
============================================================ */
	/**
	 * Returns the Order Number / Quote Number created
	 * @param  string $sessionID Session Identifier
	 * @param  bool   $debug     Run in debug? IF so return SQL Query
	 * @return string            Dplus (Order / Quote) Number
	 */
	function get_createdordn($sessionID, $debug = false) {
		$q = (new QueryBuilder())->table('logperm');
		$q->field('ordernbr');
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

/* =============================================================
	PERMISSION FUNCTIONS
============================================================ */
	/**
	 * Returns if User has permission to function / menu / page
	 * // NOTE This is based by login ID
	 * @param  string $loginID       User Login ID
	 * @param  string $dplusfunction Dplus Function / Menu code
	 * @param  bool   $debug         Run in debug? IF so return SQL Query
	 * @return bool                  User has menu / function access ?
	 */
	function has_dpluspermission($loginID, $dplusfunction, $debug = false) {
		$q = (new QueryBuilder())->table('funcperm');
		$q->field($q->expr("IF(permission = 'Y', 1, 0)"));
		$q->where('loginid', $loginID);
		$q->where('function', $dplusfunction);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
/* =============================================================
	CUSTOMER FUNCTIONS
============================================================ */
	/**
	 * Returns if Customer Index has more than 0 Records
	 * @param  bool $debug Run in debug? IF so return SQL Query
	 * @return bool        Does custindex have more than 0 records?
	 */
	function is_custindexloaded($debug = false) {
		$q = (new QueryBuilder())->table('custindex');
		$q->field($q->expr("COUNT(*) > 0, 1, 0)"));
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns Customer Perm Record
	 * Used for getting fields like amount sold, last sale date specific to a salesrep, or even overall
	 * @param  Customer $customer   Customer object, with customer properties like shiptoid
	 * @param  string   $loginID    User Login ID if blank, will use current user's login
	 * @param  bool     $debug      Run in debug? IF so return SQL Query
	 * @return array                Custperm Record
	 */
	function get_custperm(Customer $customer, $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);

		$q = (new QueryBuilder())->table('custperm');
		$q->where('loginid', $user->get_custpermloginid());
		$q->where('custid', $customer->custid);
		if ($customer->has_shipto()) {
			$q->where('shiptoid', $customer->shiptoid);
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

	/**
	 * Returns the number of records in the custperm table
	 * @param  string   $userID User Login ID
	 * @param  bool     $debug  Run in debug? IF so return SQL Query
	 * @return int              Number of custperm records
	 */
	function count_custperm($userID = '', $debug = false) {
		$q = (new QueryBuilder())->table('custperm');
		$q->field('COUNT(*)');
		if (!empty($userID)) {
			$q->where('loginid', $userID);
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	/**
	 * Returns if Customer / Shipto have a custperm record?
	 * @param  string $custID   Customer ID
	 * @param  string $shiptoID Customer Shipto ID
	 * @param  bool   $debug    Run in debug? IF so return SQL Query
	 * @return bool             Does Customer / Shipto have a custperm record?
	 */
	function has_custperm($custID, $shiptoID = '', $debug = false) {
		$q = (new QueryBuilder())->table('custperm');
		$q->field('COUNT(*)');
		$q->where('custid', $custID);
		if (!empty($shiptoID)) {
			$q->where('shiptoid', $shiptoID);
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return boolval($sql->fetchColumn());
		}
	}

	/**
	 * Insert custperm record
	 * @param  Customer $customer Customer Object with properties needed such as salesper1, custid, shiptoid
	 * @param  string   $loginID  User Login ID, if blank, will use current User ID
	 * @param  bool     $debug    Run in debug? If so, return Query
	 * @return string             SQL Query
	 */
	function insert_custperm(Customer $customer, $loginID, $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$q = (new QueryBuilder())->table('custperm');
		$q->mode('insert');
		$q->set('loginid', $loginID);
		$q->set('custid', $customer->custid);
		$q->set('salesper1', $customer->splogin1);

		if (!empty($customer->shiptoid)) {
			$q->set('shiptoid', $customer->shiptoid);
		}

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return DplusWire::wire('dplusdatabase')->lastInsertId();
		}
	}
	
	/**
	 * Change Customer ID in the custperm table
	 * @param  string $originalcustID Current Customer ID
	 * @param  string $newcustID      New Customer ID
	 * @param  bool   $debug          Run in debug? If so, return Query
	 * @return bool                   Was CustID changed?
	 */
	function change_custpermcustid($originalcustID, $newcustID, $debug = false) {
		$q = (new QueryBuilder())->table('custperm');
		$q->mode('update');
		$q->set('custid', $newcustID);
		$q->where('custid', $originalcustID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		
		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			$sql->execute($q->params);
			return $sql->rowCount() > 0 ? true : false;
		}
	}
	
	/**
	 * Returns if User has access to Customer
	 * @param  string $custID   Customer ID
	 * @param  string $shiptoID Customer Shipto ID
	 * @param  string $loginID  User Login
	 * @param  bool   $debug    Run in debug? If so, return Query
	 * @return bool             Does user have access to customer?
	 */
	function can_accesscustomer($custID, $shiptoID = '', $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep'] && DplusWire::wire('pages')->get('/config/')->restrict_allowedcustomers) {
			$custquery = (new QueryBuilder())->table('custperm')->where('custid', $custID);
			if (!empty($shiptoID)) {
				$custquery->where('shiptoid', $shiptoID );
			}

			$q = (new QueryBuilder())->table($custquery, 'customerperm');
			$q->field($q->expr('COUNT(*)'));
			$q->where('loginid', 'in', [$loginID, DplusWire::wire('config')->sharedaccounts]);
			$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

			if ($debug) {
				return $q->generate_sqlquery($q->params);
			} else {
				$sql->execute($q->params);
				return boolval($sql->fetchColumn());
			}
		} else {
			return true;
		}
	}
	
	/**
	 * Returns Customer custindex record
	 * @param  string   $custID   Customer ID
	 * @param  bool     $shiptoID Customer Shipto ID
	 * @param  bool     $debug    Run in debug? If so, return Query
	 * @return Customer           Customer Index record as Customer Class
	 */
	function get_customer($custID, $shiptoID = false, $debug = false) {
		$q = (new QueryBuilder())->table('custindex');
		$q->where('custid', $custID);

		if ($shiptoID) {
			$q->where('shiptoid', $shiptoID);
			$q->where('source', Contact::$types['customer-shipto']);
		} else {
			$q->where('source', Contact::$types['customer']);
		}

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'Customer');
			return $sql->fetch();
		}
	}
	
	/**
	 * Returns the Customer Name
	 * @param  string $custID   Customer ID
	 * @param  string $shiptoID Customer Shipto ID
	 * @param  bool   $debug    Run in debug? If so, return Query
	 * @return string           Customer Name
	 */
	function get_customershiptoname($custID, $shiptoID = '', $debug = false) {
		$q = (new QueryBuilder())->table('custindex');
		$q->field('name');
		$q->where('custid', $custID);
		if (!empty($shiptoID)) {
			$q->where('shiptoid', $shiptoID);
		}
		$q->limit(1);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns the number of shiptos for that customer
	 * filtering by loginID by providing it or defaulting to current user
	 * @param  string $custID  Customer ID
	 * @param  string $loginID LoginID to filter access to customer's shiptos
	 * @param  bool   $debug   Run in debug? If true, the SQL Query will be returned
	 * @return int             Shipto count | SQL Query
	 */
	function count_shiptos($custID, $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$SHARED_ACCOUNTS = DplusWire::wire('config')->sharedaccounts;

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep'] && DplusWire::wire('pages')->get('/config/')->restrict_allowedcustomers) {
			$custquery = (new QueryBuilder())->table('custperm')->where('custid', $custID)->where('shiptoid', '!=', '');
			$q = (new QueryBuilder())->table($custquery, 'custpermcust');
			$q->where('loginid', [$loginID, $SHARED_ACCOUNTS]);
		} else {
			$q = (new QueryBuilder())->table('custperm');
			$q->where('custid', $custID);
		}
		$q->field('COUNT(*)');
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	/**
	 * Returns an array of Shiptos (Customer objects) that the User has access to
	 * LoginID can be provided or it will default to the current user
	 * @param  string $custID  Customer ID
	 * @param  string $loginID Provided LoginID, if blank, it will default to current user
	 * @param  bool   $debug   Run in debug?
	 * @return array           Shiptos that the User has access to
	 */
	function get_customershiptos($custID, $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$SHARED_ACCOUNTS = DplusWire::wire('config')->sharedaccounts;
		$q = (new QueryBuilder())->table('custindex');

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep'] && DplusWire::wire('pages')->get('/config/')->restrict_allowedcustomers) {
			$custquery = (new QueryBuilder())->table('custperm')->where('custid', $custID)->where('shiptoid', '!=', '');
			$permquery = (new QueryBuilder())->table($custquery, 'custpermcust');
			$permquery->field('custid, shiptoid');
			$permquery->where('loginid', [$loginID, $SHARED_ACCOUNTS]);
			$q->where('(custid, shiptoid)','in', $permquery);
		} else {
			$q->where('custid', $custID);
		}
		$q->group('custid, shiptoid');
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'Customer');
			return $sql->fetchAll();
		}
	}

	/**
	 * Returns an array of shiptos (custperm array) that the user has access to
	 * @param  string $custID  Customer ID
	 * @param  int    $limit   How many records to return?
	 * @param  string $loginID User Login ID, if blank will use current user
	 * @param  bool   $debug   Run in debug? If so, will return SQL Query
	 * @return array           Custperm Shipto records
	 */
	function get_topxsellingshiptos($custID, $limit, $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);

		$q = (new QueryBuilder())->table('custperm');
		$q->where('loginid', $user->get_custpermloginid());
		$q->where('custid', $custID);
		$q->where('shiptoid', '!=', '');
		$q->limit($limit);
		$q->order('amountsold DESC');
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	/**
	 * Counts the number of Contacts the loginID can access
	 * @param  string $custID  Customer ID
	 * @param  string $loginID User Login ID if blank, will default to current user
	 * @param  bool   $debug   Run in debug? If true will return SQL Query
	 * @return int             Number of contacts for that Customer
	 */
	function count_customercontacts($custID, $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);

		$q = (new QueryBuilder())->table('custindex');
		$q->field('COUNT(*)');

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep'] && DplusWire::wire('pages')->get('/config/')->restrict_allowedcustomers) {
			$custquery = (new QueryBuilder())->table('custperm')->where('custid', $custID);
			$permquery = (new QueryBuilder())->table($custquery, 'custpermcust');
			$permquery->field('custid, shiptoid');
			$permquery->where('loginid', [$loginID, DplusWire::wire('config')->sharedaccounts]);
			$q->where('(custid, shiptoid)','in', $permquery);
		} else {
			$q->where('custid', $custID);
		}

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns the Contacts the loginID can access
	 * @param  string $custID  Customer ID
	 * @param  string $loginID User Login ID if blank, will default to current user
	 * @param  bool   $debug   Run in debug? If true will return SQL Query
	 * @return array             array of contacts for that Customer
	 */
	function get_customercontacts($custID, $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$SHARED_ACCOUNTS = DplusWire::wire('config')->sharedaccounts;

		$q = (new QueryBuilder())->table('custindex');

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep'] && DplusWire::wire('pages')->get('/config/')->restrict_allowedcustomers) {
			$custquery = (new QueryBuilder())->table('custperm')->where('custid', $custID);
			$permquery = (new QueryBuilder())->table($custquery, 'custpermcust');
			$permquery->field('custid, shiptoid');
			$permquery->where('loginid', [$loginID, $SHARED_ACCOUNTS]);
			$q->where('(custid, shiptoid)','in', $permquery);
		} else {
			$q->where('custid', $custID);
		}

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'Contact');
			return $sql->fetchAll();
		}
	}
	
	/**
	 * Returns if User can Access Customer Contact
	 * @param  string $custID    Customer ID
	 * @param  string $shiptoID  Customer Shipto ID
	 * @param  string $contactID Customer (Shipto) Contact ID
	 * @param  string $loginID   User Login ID
	 * @param  bool   $debug     Run in debug? If true will return SQL Query
	 * @return bool              Can User Access Contact?
	 */
	function can_accesscustomercontact($custID, $shiptoID, $contactID, $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$SHARED_ACCOUNTS = DplusWire::wire('config')->sharedaccounts;

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep'] && DplusWire::wire('pages')->get('/config/')->restrict_allowedcustomers) {
			$custquery = (new QueryBuilder())->table('custperm')->where('custid', $custID);
			$permquery = (new QueryBuilder())->table($custquery, 'custpermcust')->field('custid, shiptoid');
			$permquery->where('loginid', 'in', [$loginID, $SHARED_ACCOUNTS]);
			$q = (new QueryBuilder())->table('custindex');
			$q->field($q->expr('COUNT(*)'));
			$q->where('(custid, shiptoid)','in', $permquery);
			$q->where('shiptoid', $shiptoID);
			$q->where('contact', $contactID);
			$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

			if ($debug) {
				return $q->generate_sqlquery($q->params);
			} else {
				$sql->execute($q->params);
				return boolval($sql->fetchColumn());
			}
		} else {
			return 1;
		}
	}
	
	/**
	 * Returns instance of the Contact Class with contact data
	 * @param  string $custID    Customer ID
	 * @param  string $shiptoID  Customer Shipto ID
	 * @param  string $contactID Customer (Shipto) Contact ID
	 * @param  bool   $debug     Run in debug? If true will return SQL Query
	 * @return Contact          Customer Contact
	 */
	function get_customercontact($custID, $shiptoID = '', $contactID = '', $debug = false) {
		$q = (new QueryBuilder())->table('custindex');
		$q->limit(1);
		$q->where('custid', $custID);
		$q->where('shiptoid', $shiptoID);
		if (!empty($contactID)) {
			$q->where('contact', $contactID);
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'Contact');
			return $sql->fetch();
		}
	}

	/**
	 * Gets the primary contact for that Customer Shipto.
	 * ** NOTE each Customer and Customer Shipto may have one Primary buyer
	 * @param  string  $custID   Customer ID
	 * @param  bool $shiptoID Shipto ID ** optional
	 * @param  bool $debug    Determines if query will execute and if SQL is returned or Contact object
	 * @return Contact            Or SQL QUERY
	 */
	function get_primarybuyercontact($custID, $shiptoID = false, $debug = false) {
		$q = (new QueryBuilder())->table('custindex');
		$q->limit(1);
		$q->where('custid', $custID);
		if (!empty($shiptoID)) {
			$q->where('shiptoid', $shiptoID);
		}
		$q->where('buyingcontact', 'P');
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'Contact');
			return $sql->fetch();
		}
	}

	/**
	 * Get End Users and Buyers [array of objects (Contact)] for a Customer that a User has access to
	 * @param  string $loginID  User LoginID, if blank, will use current user ID
	 * @param  string $custID   Customer ID
	 * @param  string $shiptoID Customer Shipto ID
	 * @param  bool   $debug    Run in debug? If so, will return SQL Query
	 * @return array            array of objects (Contact)
	 */
	function get_customerbuyersendusers($custID, $shiptoID = '', $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$SHARED_ACCOUNTS = DplusWire::wire('config')->sharedaccounts;
		$q = (new QueryBuilder())->table('custindex');

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep'] && DplusWire::wire('pages')->get('/config/')->restrict_allowedcustomers)  {
			$custquery = (new QueryBuilder())->table('custperm')->where('custid', $custID);
			if (!empty($shiptoID)) {
				$custquery->where('shiptoid', $shiptoID);
			}
			$permquery = (new QueryBuilder())->table($custquery, 'custpermcust');
			$permquery->field('custid, shiptoid');
			$permquery->where('loginid', [$loginID, $SHARED_ACCOUNTS]);
			$q->where('(custid, shiptoid)','in', $permquery);
		} else {
			$q->where('custid', $custID);
			if (!empty($shiptoID)) {
				$q->where('shiptoid', $shiptoID);
			}
		}
		$q->where('buyingcontact', '!=', 'N');
		$q->where('certcontact', 'Y');
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'Contact');
			return $sql->fetchAll();
		}
	}
	/**
	 * Returns the results of a search of a Customer's End Users and Buyers and the results
	 * are filtered to the contacts the User can see
	 * @param  string $custID   Customer ID
	 * @param  string $shiptoID Customer Shipto ID
	 * @param  string $query    Search Query
	 * @param  string $loginID  User Login ID, if blank, it will use current user
	 * @param  bool   $debug    Run in Debug?
	 * @return array            Contact objects
	 */
	function search_customerbuyersendusers($custID, $shiptoID = '', $query, $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$SHARED_ACCOUNTS = DplusWire::wire('config')->sharedaccounts;
		$search = QueryBuilder::generate_searchkeyword($query);
		$q = (new QueryBuilder())->table('custindex');

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep'] && DplusWire::wire('pages')->get('/config/')->restrict_allowedcustomers) {
			$custquery = (new QueryBuilder())->table('custperm')->where('custid', $custID);
			if (!empty($shiptoID)) {
				$custquery->where('shiptoid', $shiptoID);
			}
			$permquery = (new QueryBuilder())->table($custquery, 'custpermcust');
			$permquery->field('custid, shiptoid');
			$permquery->where('loginid', [$loginID, $SHARED_ACCOUNTS]);
			$q->where('(custid, shiptoid)','in', $permquery);
		} else {
			$q->where('custid', $custID);
			if (!empty($shiptoID)) {
				$q->where('shiptoid', $shiptoID);
			}
		}
		$fieldstring = implode(", ' ', ", array_keys(Contact::generate_classarray()));
		$q->where('buyingcontact', '!=', 'N');
		$q->where('certcontact', 'Y');
		$q->where($q->expr("UCASE(REPLACE(CONCAT($fieldstring), '-', '')) LIKE []", [$search]));
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'Contact');
			return $sql->fetchAll();
		}
	}

	function edit_customercontact($custID, $shipID, $contactID, $contact, $debug = false) {
		$originalcontact = get_customercontact($custID, $shipID, $contactID, false);
		$q = (new QueryBuilder())->table('custindex');
		$q->mode('update');
		$q->generate_setdifferencesquery($originalcontact->_toArray(), $contact->_toArray());
		$q->where('custid', $custID);
		$q->where('shiptoid', $shipID);
		$q->where('contact', $contactID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			$sql->execute($q->params);
			$success = $sql->rowCount();
			if ($success) {
				return array("error" => false, "sql" => $q->generate_sqlquery($q->params));
			} else {
				return array("error" => true, "sql" => $q->generate_sqlquery($q->params));
			}
		}
	}

	function get_customersalesperson($custID, $shipID, $debug) {
		$sql = DplusWire::wire('dplusdatabase')->prepare("SELECT splogin1 FROM custindex WHERE custid = :custID AND shiptoid = :shipID LIMIT 1");
		$switching = array(':custID' => $custID, ':shipID' => $shipID);
		$withquotes = array(true, true);

		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchColumn();
		}
	}
/* =============================================================
	CUST INDEX FUNCTIONS
============================================================ */
	/**
	 * Returns Distinct Customer Index Records that the user has access to
	 * @param  int    $limit   Number of Records to return
	 * @param  int    $page    Page Number to start from
	 * @param  string $loginID User Login ID, if blank, will use current user
	 * @param  bool   $debug   Run in debug? If so, will return SQL Query
	 * @return array           Distinct Customer Index Records
	 */
	function get_distinctcustindexpaged($limit = 10, $page = 1, $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$SHARED_ACCOUNTS = DplusWire::wire('config')->sharedaccounts;

		$q = (new QueryBuilder())->table('custindex');

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep'] && DplusWire::wire('pages')->get('/config/')->restrict_allowedcustomers) {
			$custpermquery = (new QueryBuilder())->table('custperm');
			$custpermquery->field($q->expr('DISTINCT(custid)'));
			$custpermquery->where('loginid', 'in', [$loginID, $SHARED_ACCOUNTS]);

			$q->where('custid','in', $custpermquery);
		}
		$q->limit($limit, $q->generate_offset($page, $limit));
		$q->group('custid');

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'Customer');
			return $sql->fetchAll();
		}
	}

	function count_distinctcustindex($loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$SHARED_ACCOUNTS = DplusWire::wire('config')->sharedaccounts;
		$q = (new QueryBuilder())->table('custindex');
		$q->field($q->expr('COUNT(DISTINCT(custid))'));

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep'] && DplusWire::wire('pages')->get('/config/')->restrict_allowedcustomers) {
			$custpermquery = (new QueryBuilder())->table('custperm');
			$custpermquery->field($q->expr('DISTINCT(custid)'));
			$custpermquery->where('loginid', 'in', [$loginID, $SHARED_ACCOUNTS]);
			$q->where('custid','in', $custpermquery);
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns Customer Index records that match the Query
	 * @param  string $keyword Query String to match
	 * @param  int    $limit   Number of records to return
	 * @param  int    $page    Page to start from
	 * @param  string $orderby Order By string
	 * @param  string $loginID User Login ID, if blank, will use current user
	 * @param  bool   $debug   Run in debug? If so, will return SQL Query
	 * @return array           Customer Index records that match the Query
	 */
	function search_custindexpaged($keyword, $limit = 10, $page = 1, $orderby, $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$SHARED_ACCOUNTS = DplusWire::wire('config')->sharedaccounts;

		$search = '%'.str_replace(' ', '%', str_replace('-', '', addslashes($keyword))).'%';
		$q = (new QueryBuilder())->table('custindex');

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep'] && DplusWire::wire('pages')->get('/config/')->restrict_allowedcustomers) {
			$permquery = (new QueryBuilder())->table('custperm');
			$permquery->field('custid, shiptoid');
			$permquery->where('loginid', [$loginID, $SHARED_ACCOUNTS]);
			$q->where('(custid, shiptoid)','in', $permquery);
		}
		$fieldstring = implode(", ' ', ", array_keys(Contact::generate_classarray()));

		$q->where($q->expr("UCASE(REPLACE(CONCAT($fieldstring), '-', '')) LIKE UCASE([])", [$search]));
		$q->limit($limit, $q->generate_offset($page, $limit));

		if (DplusWire::wire('config')->cptechcustomer == 'stempf') {
			if (!empty($orderbystring)) {
				$q->order($q->generate_orderby($orderbystring));
			} else {
				$q->order($q->expr('custid <> []', [$search]));
			}
			$q->group('custid, shiptoid');
		} elseif (DplusWire::wire('config')->cptechcustomer == 'stat') {
			if (!empty($orderbystring)) {
				$q->order($q->generate_orderby($orderbystring));
			}
			$q->group('custid');
		} else {
			if (!empty($orderbystring)) {
				$q->order($q->generate_orderby($orderbystring));
			} else {
				$q->order($q->expr('custid <> []', [$search]));
			}
		}



		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'Customer');
			return $sql->fetchAll();
		}
	}

	/**
	 * Returns the Number of custindex records that match the search
	 * and filters it by user permissions
	 * @param  string $query   Search Query
	 * @param  string $loginID User Login ID, if blank, will use current User
	 * @param  bool   $debug   Run in debug? If so, Return SQL Query
	 * @return int             Number of custindex records that match the search | SQL Query
	 */
	function count_searchcustindex($query, $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$SHARED_ACCOUNTS = DplusWire::wire('config')->sharedaccounts;
		$search = QueryBuilder::generate_searchkeyword($query);
		$groupedcustindexquery = (new QueryBuilder())->table('custindex')->group('custid, shiptoid');

		$q = new QueryBuilder();
		$q->field($q->expr('COUNT(*)'));

		// CHECK if Users has restrictions by Application Config, then User permissions
		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep'] && DplusWire::wire('pages')->get('/config/')->restrict_allowedcustomers) {
			$custpermquery = (new QueryBuilder())->table('custperm')->field('custid, shiptoid')->where('loginid', [$loginID, $SHARED_ACCOUNTS]);

			if (DplusWire::wire('config')->cptechcustomer == 'stempf') {
				$q->table($groupedcustindexquery, 'custgrouped');
			} else {
				$q->table('custindex');
			}

			$q->where('(custid, shiptoid)','in', $custpermquery);
		} else {
			if (DplusWire::wire('config')->cptechcustomer == 'stempf') {
				$q->table($groupedcustindexquery, 'custgrouped');
			} else {
				$q->table('custindex');
			}
		}
		$fieldstring = implode(", ' ', ", array_keys(Contact::generate_classarray()));

		$q->where($q->expr("UCASE(REPLACE(CONCAT($fieldstring), '-', '')) LIKE UCASE([])", [$search]));

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Get the X number of Top Selling Customers
	 * @param  int    $limit    [description]
	 * @param  string $loginID  User Login ID either provided, or current User
	 * @param  bool   $debug    Run in debug? If true, return SQL Query
	 * @return array            Top Selling Customers
	 */
	function get_topxsellingcustomers($limit, $loginID = '',  $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$login = $user->get_custpermloginid();
		$q = (new QueryBuilder())->table('custperm');
		$q->where('loginid', $login);
		$q->where('shiptoid', '');
		$q->limit($limit);
		$q->order('amountsold DESC');
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	/**
	 * Inserts record into custindex table
	 * @param  Contact $contact The Contact object you will add
	 * @param  bool    $debug   Run in debug?
	 * @return string           Returns SQL Query
	 * @uses get_maxcustindexrecnbr()
	 */
	function insert_customerindexrecord(Contact $contact, $debug = false) {
		$contact->set('recno', get_maxcustindexrecnbr() + 1);
		$properties = array_keys($contact->_toArray());
		$q = (new QueryBuilder())->table('custindex');
		$q->mode('insert');

		foreach ($properties as $property) {
			if (!empty($contact->$property)) {
				$q->set($property, $contact->$property);
			}
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			$sql->execute($q->params);
			return $q->generate_sqlquery($q->params);
		}
	}

	/**
	 * Updates the contact record in the custindex table
	 * @param  Contact $contact Contact to update
	 * @param  bool    $debug   Run in debug
	 * @return string           SQL Query
	 */
	function update_contact(Contact $contact, $debug = false) {
		$originalcontact = Contact::load($contact->custid, $contact->shiptoid, $contact->contact);
		$properties = array_keys($contact->_toArray());
		$q = (new QueryBuilder())->table('custindex');
		$q->mode('update');
		foreach ($properties as $property) {
			if ($contact->$property != $originalcontact->$property) {
				$q->set($property, $contact->$property);
			}
		}
		$q->where('custid', $contact->custid);
		$q->where('shiptoid', $contact->shiptoid);
		$q->where('contact', $contact->contact);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			if ($contact->has_changes()) {
				$sql->execute($q->params);
			}
			return $q->generate_sqlquery($q->params);
		}
	}

	/**
	 * Updates the contact Name / ID in the custindex table for that contact
	 * @param  Contact $contact   Customer Contact
	 * @param  string  $contactID New Contact Name / ID
	 * @param  bool    $debug     Run in Debug?
	 * @return string             SQL Query
	 */
	function change_contactid(Contact $contact, $contactID, $debug = false) {
		$originalcontact = Contact::load($contact->custid, $contact->shiptoid, $contact->contact);
		$q = (new QueryBuilder())->table('custindex');
		$q->mode('update');
		$q->set('contact', $contactID);
		$q->where('custid', $contact->custid);
		$q->where('shiptoid', $contact->shiptoid);
		$q->where('contact', $contact->contact);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		$contact->set('contact', $contactID);

		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			if ($contact->has_changes()) {
				$sql->execute($q->params);
			}
			return $q->generate_sqlquery($q->params);
		}
	}

	/**
	 * Get the last record number (recno) from the custindex table
	 * @param  bool   $debug Run in debug?
	 * @return string        Record Number
	 */
	function get_maxcustindexrecnbr($debug = false) {
		$q = (new QueryBuilder())->table('custindex');
		$q->field($q->expr('MAX(recno)'));
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			$sql->execute();
			return $sql->fetchColumn();
		}
	}
	/**
	 * Change custindex Customer ID
	 * // NOTE Usually used for new customers, once dplus custid is provided
	 * @param  string $originalcustID Current Customer ID
	 * @param  string $newcustID      new Customer ID (Provided by Dplus)
	 * @param  bool   $debug          Run in debug?
	 * @return string                 SQL Query
	 */
	function change_custindexcustid($originalcustID, $newcustID, $debug = false) {
		$q = (new QueryBuilder())->table('custindex');
		$q->mode('update');
		$q->set('custid', $newcustID);
		$q->where('custid', substr($originalcustID, 0, 6));
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			$sql->execute($q->params);
			return $q->generate_sqlquery();
		}
	}

/* =============================================================
	SALES ORDERS FUNCTIONS
============================================================ */
	/**
	 * Counts the Number of Sales Orders in oe_head that match the filter criteria
	 * @param  bool   $filter      Array of filters and the values to filter for
	 * @param  bool   $filtertypes Array of filter properties
	 * @param  bool   $debug       Run in debug? If so, return SQL query
	 * @return int                 Number of Sales Orders that match the filter criteria
	 */
	function count_salesorders($filter = false, $filtertypes = false, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');
		$q->field($q->expr('COUNT(*)'));
		
		if (isset($filter['salesperson'])) {
			$salespeople = $filter['salesperson'];
			$ordersquery = (new QueryBuilder())->table('oe_head');
			$ordersquery->field('ordernumber');
			$ordersquery->where(
				$ordersquery
				->orExpr()
				->where('salesperson_1', $salespeople)
				->where('salesperson_2', $salespeople)
				->where('salesperson_3', $salespeople)
			);
			$q->where('ordernumber', $ordersquery);
			unset($filter['salesperson']);
		}
		
		if (!empty($filter)) {
			$q->generate_filters($filter, $filtertypes);
		}
		
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	/**
	 * Returns an array of SalesOrder that match the filter criteria
	 * @param  int    $limit       Number of Records to Return
	 * @param  int    $page        Page Number
	 * @param  string $sortrule    Sort (ASC)ENDING | (DESC)ENDING
	 * @param  bool   $filter      Array of filters and their values
	 * @param  bool   $filtertypes Array of filter properties
	 * @param  bool   $useclass    Return records as SalesOrder class?
	 * @param  bool   $debug       Run in Debug? If so, return SQL Query
	 * @return array               Sales Orders that match the filter criteria
	 */
	function get_salesorders($limit = 10, $page = 1, $sortrule, $filter = false, $filtertypes = false, $useclass = false, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');
		
		if (isset($filter['salesperson'])) {
			$salespeople = $filter['salesperson'];
			$ordersquery = (new QueryBuilder())->table('oe_head');
			$ordersquery->field('ordernumber');
			$ordersquery->where(
				$ordersquery
				->orExpr()
				->where('salesperson_1', $salespeople)
				->where('salesperson_2', $salespeople)
				->where('salesperson_3', $salespeople)
			);
			$q->where('ordernumber', $ordersquery);
			unset($filter['salesperson']);
		}
		
		if (!empty($filter)) {
			$q->generate_filters($filter, $filtertypes);
		}
		$q->limit($limit, $q->generate_offset($page, $limit));
		$q->order('order_date' . $sortrule);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			if ($useclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'SalesOrder');
				return $sql->fetchAll();
			}
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	
	/**
	 * Returns an array of SalesOrder that match the filter criteria
	 * @param  int    $limit       Number of Records to Return
	 * @param  int    $page        Page Number
	 * @param  string $sortrule    Sort (ASC)ENDING | (DESC)ENDING
	 * @param  string $orderby     Column / Property to sort on
	 * @param  bool   $filter      Array of filters and their values
	 * @param  bool   $filtertypes Array of filter properties
	 * @param  bool   $useclass    Return records as SalesOrder class?
	 * @param  bool   $debug       Run in Debug? If so, return SQL Query
	 * @return array               Sales Orders that match the filter criteria
	 */
	function get_salesorders_orderby($limit = 10, $page = 1, $sortrule, $orderby, $filter = false, $filtertypes = false, $useclass = false, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');
		
		if (isset($filter['salesperson'])) {
			$ordersquery = (new QueryBuilder())->table('oe_head');
			$ordersquery->field('ordernumber');
			$ordersquery->where(
				$ordersquery
				->orExpr()
				->where('salesperson_1', $filter['salesperson'])
				->where('salesperson_2', $filter['salesperson'])
				->where('salesperson_3', $filter['salesperson'])
			);
			$q->where('ordernumber', $ordersquery);
			unset($filter['salesperson']);
		}
		
		if (!empty($filter)) {
			$q->generate_filters($filter, $filtertypes);
		}
		$q->limit($limit, $q->generate_offset($page, $limit));
		$q->order($orderby .' '. $sortrule);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			if ($useclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'SalesOrder');
				return $sql->fetchAll();
			}
			return $sql->fetchAll();
		}
	}

	/**
	 * Returns the Customer ID from a specific Sales Order
	 * @param  string $ordn  Sales Order Number
	 * @param  bool   $debug Run in debug? If so, return SQL Query
	 * @return string        Customer ID
	 */
	function get_custidfromsalesorder($ordn, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');
		$q->field('custid');
		$q->where('ordernumber', "$ordn");
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns the Customer Shipto ID from a specific Sales Order
	 * @param  string $ordn  Sales Order Number
	 * @param  bool   $debug Run in debug? If so, return SQL Query
	 * @return string        Customer ID
	 */
	function get_shiptoidfromsalesorder($ordn, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');
		$q->field('shiptoid');
		$q->where('ordernumber', $ordn);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns the Max Order Total for Sales Orders that
	 * @param  string $custID      Customer ID, if blank will not filter to one customer
	 * @param  string $shipID      Customer Shipto Id
	 * @param  bool   $filter      Array of filters and their values
	 * @param  bool   $filtertypes Array of filter properties
	 * @param  bool   $debug       Run in debug? If so return SQL Query
	 * @return float               Max Sales Order Total
	 */
	function get_maxsalesordertotal($custID = '', $shipID = '', $filter, $filtertypes, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');
		$q->field($q->expr('MAX(total_order)'));
		
		if (isset($filter['salesperson'])) {
			$ordersquery = (new QueryBuilder())->table('oe_head');
			$ordersquery->field('ordernumber');
			$ordersquery->where(
				$ordersquery
				->orExpr()
				->where('salesperson_1', $filter['salesperson'])
				->where('salesperson_2', $filter['salesperson'])
				->where('salesperson_3', $filter['salesperson'])
			);
			$q->where('ordernumber', $ordersquery);
			unset($filter['salesperson']);
		}
		
		if (!empty($custID)) {
			$q->where('custid', $custID);

			if (!(empty($shipID))) {
				$q->where('shiptoid', $shipID);
			}
		}

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns the Min Order Total for Sales Orders that
	 * @param  string $custID      Customer ID, if blank will not filter to one customer
	 * @param  string $shipID      Customer Shipto ID
	 * @param  bool   $filter      Array of filters and their values
	 * @param  bool   $filtertypes Array of filter properties
	 * @param  bool   $debug       Run in debug? If so return SQL Query
	 * @return float               Min Sales Order Total
	 */
	function get_minsalesordertotal($custID = '', $shipID = '', $filter, $filtertypes, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');
		$q->field($q->expr('MIN(total_order)'));
		
		if (isset($filter['salesperson'])) {
			$ordersquery = (new QueryBuilder())->table('oe_head');
			$ordersquery->field('ordernumber');
			$ordersquery->where(
				$ordersquery
				->orExpr()
				->where('salesperson_1', $filter['salesperson'])
				->where('salesperson_2', $filter['salesperson'])
				->where('salesperson_3', $filter['salesperson'])
			);
			$q->where('ordernumber', $ordersquery);
			unset($filter['salesperson']);
		}
		
		if (!empty($custID)) {
			$q->where('custid', $custID);

			if (!(empty($shipID))) {
				$q->where('shiptoid', $shipID);
			}
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns the Min Order Date for Sales Orders that meets the filter criteria
	 * @param  string $custID      Customer ID, if blank will not filter to one customer
	 * @param  string $shipID      Customer Shipto ID
	 * @param  string $field       Which Sales Order Date Property
	 * @param  bool   $filter      Array of filters and their values
	 * @param  bool   $filtertypes Array of filter properties
	 * @param  bool   $debug       Run in debug? If so return SQL Query
	 * @return string              Min Sales Order Date
	 */
	function get_minsalesorderdate($field, $custID = false, $shipID = false, $filter, $filtertypes, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');
		$q->field($q->expr("MIN($field)"));
		
		if (isset($filter['salesperson'])) {
			$ordersquery = (new QueryBuilder())->table('oe_head');
			$ordersquery->field('ordernumber');
			$ordersquery->where(
				$ordersquery
				->orExpr()
				->where('salesperson_1', $filter['salesperson'])
				->where('salesperson_2', $filter['salesperson'])
				->where('salesperson_3', $filter['salesperson'])
			);
			$q->where('ordernumber', $ordersquery);
			unset($filter['salesperson']);
		}
		
		if (!empty($custID)) {
			$q->where('custid', $custID);

			if (!(empty($shipID))) {
				$q->where('shiptoid', $shipID);
			}
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	/**
	 * Returns an array of SalesOrderDetail for an Order
	 * @param  string $sessionID Session Identifier
	 * @param  string $ordn      Sales Order Number
	 * @param  bool   $useclass  Use Class? Or return as array
	 * @param  bool   $debug     Run in debug? If so return SQL Query
	 * @return array             Sales Order Details
	 */
	function get_orderdetails($sessionID, $ordn, $useclass = false, $debug) {
		$q = (new QueryBuilder())->table('ordrdet');
		$q->where('sessionid', $sessionID);
		$q->where('orderno', $ordn);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			if ($useclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'SalesOrderDetail');
				return $sql->fetchAll();
			}
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	/**
	 * Returns the order number locked by this session
	 * @param  string $sessionID Session Identifier
	 * @param  bool   $debug     Run in debug? If so return SQL Query
	 * @return string            Order Number
	 */
	function get_lockedordn($sessionID, $debug = false) {
		$q = (new QueryBuilder())->table('orddocs');
		$q->field('ordernumber');
		$q->where('sessionid', $sessionID);
		$q->limit(1);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	function get_orderdocs($sessionID, $ordn, $debug = false) {
		$q = (new QueryBuilder())->table('orddocs');
		$q->where('sessionid', $sessionID);
		$q->where('orderno', $ordn);
		$q->where('itemnbr', '');
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

/* =============================================================
	SALES HISTORY FUNCTIONS
============================================================ */
	/**
	 * Returns if Sales Order is Sales History
	 * @param  string $ordn  Sales Order Number
	 * @param  bool   $debug Run in debug? IF so, return SQL query
	 * @return bool          Is Sales Order in Sales History?
	 */
	function is_ordersaleshistory($ordn, $debug = false) {
		$q = (new QueryBuilder())->table('saleshist');
		$q->field('COUNT(*)');
		$q->where('ordernumber', $ordn);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	/**
	 * Returns the Customer ID from a Sales History Order
	 * @param  string $ordn  Sales Order Number
	 * @param  bool   $debug Run in debug? IF so, return SQL query
	 * @return string        Sales History Order Customer ID
	 */
	function get_custidfromsaleshistory($ordn, $debug = false) {
		$q = (new QueryBuilder())->table('saleshist');
		$q->field('custid');
		$q->where('ordernumber', $ordn);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	/**
	 * Returns the Min Date $field from the Sales History Table
	 * @param  string $field        Order Date Column
	 * @param  string $custID       Customer ID
	 * @param  string $shipID       Customer Shipto ID 
	 * @param  array  $filter       Array that contains the column and the values to filter for
	 * @param  array  $filtertypes  Array that contains the filterable columns as keys, and the rules needed
	 * @param  bool   $debug        Run in debug? If so, return SQL Query
	 * @return float                Min Sales Order Date
	 */
	function get_minsaleshistoryorderdate($field, $custID = '', $shipID = '', $filter = array(), $filtertypes = array(), $debug = false) {
		$q = (new QueryBuilder())->table('saleshist');
		$q->field($q->expr("MIN(STR_TO_DATE(CAST($field as CHAR(12)), '%Y%m%d'))"));
		if ($custID) {
			$q->where('custid', $custID);
		}
		if ($shipID) {
			$q->where('shiptoid', $shipID);
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	/**
	 * Returns the Max Sales Order Total from the Sales History Table
	 * @param  string $custID       Customer ID
	 * @param  string $shipID       Customer Shipto ID 
	 * @param  array  $filter       Array that contains the column and the values to filter for
	 * @param  array  $filtertypes  Array that contains the filterable columns as keys, and the rules needed
	 * @param  bool   $debug        Run in debug? If so, return SQL Query
	 * @return float                Max Sales Order Total
	 */
	function get_maxsaleshistoryordertotal($custID = '', $shipID = '', $filter = array(), $filtertypes = array(), $debug = false) {
		$q = (new QueryBuilder())->table('saleshist');
		$q->field($q->expr("MAX(total_order)"));
		
		if (!empty($custID)) {
			$q->where('custid', $custID);
			if (!empty($shipID)) {
				$q->where('shiptoid', $shipID);
			}
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	/**
	 * Returns the Min Sales Order Total from the Sales History Table
	 * @param  string $custID       Customer ID
	 * @param  string $shipID       Customer Shipto ID 
	 * @param  array  $filter       Array that contains the column and the values to filter for
	 * @param  array  $filtertypes  Array that contains the filterable columns as keys, and the rules needed
	 * @param  bool   $debug        Run in debug? If so, return SQL Query
	 * @return float                Min Sales Order Total
	 */
	function get_minsaleshistoryordertotal($custID = '', $shipID = '', $filter = array(), $filtertypes = array(), $debug = false) {
		$q = (new QueryBuilder())->table('saleshist');
		$q->field($q->expr("MIN(total_order)"));
		if (!empty($custID)) {
			$q->where('custid', $custID);
			if (!empty($shipID)) {
				$q->where('shiptoid', $shipID);
			}
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns the number of Orders in Sales History that meets
	 * the filtered criteria for the User provided
	 * @param  array   $filter      Array that contains the column and the values to filter for
	 * ex. array(
	 * 	'ordertotal' => array (123.64, 465.78)
	 * )
	 * @param  array   $filterable  Array that contains the filterable columns as keys, and the rules needed
	 * ex. array(
	 * 	'ordertotal' => array(
	 * 		'querytype' => 'between',
	 * 		'datatype' => 'numeric',
	 * 		'label' => 'Order Total'
	 * 	),
	 * 	'orderdate' => array(
	 * 		'querytype' => 'between',
	 * 		'datatype' => 'date',
	 * 		'date-format' => 'Ymd',
	 * 		'label' => 'order-date'
	 * 	)
	 * )
	 * @param  bool    $debug       Run in debug? If so, return SQL Query
	 * @return int                  Number of Orders that meet filter requirements
	 */
	function count_saleshistory($filter = false, $filterable = false, $debug = false) {
		$q = (new QueryBuilder())->table('saleshist');
		$q->field('COUNT(*)');

		if (isset($filter['salesperson'])) {
			$ordersquery = (new QueryBuilder())->table('saleshist');
			$ordersquery->field('ordernumber');
			$ordersquery->where(
				$ordersquery
				->orExpr()
				->where('salesperson_1', $filter['salesperson'])
				//->where('salesperson_2', $filter['salesperson'])
				//->where('salesperson_3', $filter['salesperson'])
			);
			$q->where('ordernumber', $ordersquery);
			unset($filter['salesperson']);
		}
		
		if (!empty($filter)) {
			$q->generate_filters($filter, $filterable);
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns an array of Sales History Records that meet the filter criteria
	 * for the User
	 * @param  int    $limit       Number of Records to return
	 * @param  int    $page        Page Number to start from
	 * @param  array  $filter      Array that contains the column and the values to filter for
	 * ex. array(
	 * 	'ordertotal' => array (123.64, 465.78)
	 * )
	 * @param  array   $filterable  Array that contains the filterable columns as keys, and the rules needed
	 * ex. array(
	 * 	'ordertotal' => array(
	 * 		'querytype' => 'between',
	 * 		'datatype' => 'numeric',
	 * 		'label' => 'Order Total'
	 * 	),
	 * 	'orderdate' => array(
	 * 		'querytype' => 'between',
	 * 		'datatype' => 'date',
	 * 		'date-format' => 'Ymd',
	 * 		'label' => 'order-date'
	 * 	)
	 * )
	 * @param  bool   $useclass      Return records as a SalesOrderHistory object? (or array)
	 * @param  bool   $debug         Run in debug?
	 * @return array                 array of SalesOrderHistory objects | array of sales history orders as arrays
	 */
	function get_saleshistory($limit = 10, $page = 1, $filter = false, $filterable = false, $useclass = false, $debug = false) {
		$q = (new QueryBuilder())->table('saleshist');

		if (isset($filter['salesperson'])) {
			$ordersquery = (new QueryBuilder())->table('saleshist');
			$ordersquery->field('ordernumber');
			$ordersquery->where(
				$ordersquery
				->orExpr()
				->where('salesperson_1', $filter['salesperson'])
				//->where('salesperson_2', $filter['salesperson'])
				//->where('salesperson_3', $filter['salesperson'])
			);
			$q->where('ordernumber', $ordersquery);
			unset($filter['salesperson']);
		}
		
		if (!empty($filter)) {
			$q->generate_filters($filter, $filterable);
		}
		$q->limit($limit, $q->generate_offset($page, $limit));
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			if ($useclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'SalesOrderHistory');
				return $sql->fetchAll();
			}
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	
	

	/**
	 * Returns an array of Sales History Records (sorted) that meet the filter criteria
	 * for the User
	 * @param  int    $limit       Number of Records to return
	 * @param  int    $page        Page Number to start from
	 * @param  string $sortrule    Sort Rule ASC | DESC
	 * @param  string $orderby     Column to sort on
	 * @param  array  $filter      Array that contains the column and the values to filter for
	 * ex. array(
	 * 	'ordertotal' => array (123.64, 465.78)
	 * )
	 * @param  array   $filterable  Array that contains the filterable columns as keys, and the rules needed
	 * ex. array(
	 * 	'ordertotal' => array(
	 * 		'querytype' => 'between',
	 * 		'datatype' => 'numeric',
	 * 		'label' => 'Order Total'
	 * 	),
	 * 	'orderdate' => array(
	 * 		'querytype' => 'between',
	 * 		'datatype' => 'date',
	 * 		'date-format' => 'Ymd',
	 * 		'label' => 'order-date'
	 * 	)
	 * )
	 * @param  bool   $useclass      Return records as a SalesOrderHistory object? (or array)
	 * @param  bool   $debug         Run in debug? If so return SQL Query
	 * @return array                 array of SalesOrderHistory objects | array of sales history orders as arrays
	 */
	function get_saleshistory_orderby($limit = 10, $page = 1, $sortrule = 'ASC', $orderby, $filter = false, $filterable = false, $useclass = true, $debug = false) {
		$q = (new QueryBuilder())->table('saleshist');
		
		if (isset($filter['salesperson'])) {
			$ordersquery = (new QueryBuilder())->table('saleshist');
			$ordersquery->field('ordernumber');
			$ordersquery->where(
				$ordersquery
				->orExpr()
				->where('salesperson_1', $filter['salesperson'])
				//->where('salesperson_2', $filter['salesperson'])
				//->where('salesperson_3', $filter['salesperson'])
			);
			$q->where('ordernumber', $ordersquery);
			unset($filter['salesperson']);
		}

		if (!empty($filter)) {
			$q->generate_filters($filter, $filterable);
		}
		$q->order($orderby .' '. $sortrule);
		$q->limit($limit, $q->generate_offset($page, $limit));

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			if ($useclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'SalesOrderHistory');
				return $sql->fetchAll();
			}
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	
	function get_saleshistoryorder($ordn, $debug = false) {
		$q = (new QueryBuilder())->table('saleshist');
		$q->where('ordernumber', $ordn);

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'SalesOrderHistory');
			return $sql->fetch();
		}
	}
/* =============================================================
	QUOTES FUNCTIONS
============================================================ */
	/**
	 * Returns the Number of Quotes that match filter
	 * @param  string  $sessionID   Session Identifier
	 * @param  array   $filter      Array that contains the column and the values to filter for
	 * @param  array   $filtertypes Array that contains the filterable columns as keys, and the rules needed
	 * @param  bool    $debug       Run in debug? If so return SQL Query
	 * @return int                  Number of Quotes 
	 */
	function count_quotes($sessionID, $filter = false, $filtertypes = false, $debug = false) {
		$q = (new QueryBuilder())->table('quothed');
		$expression = $q->expr('IF (COUNT(*) = 1, 1, IF(COUNT(DISTINCT(custid)) > 1, COUNT(*), 0)) as count');
		if (!empty($filter)) {
			$expression = $q->expr('COUNT(*)');
		}
		$q->field($expression);
		$q->where('sessionid', $sessionID);
		
		
		if (isset($filter['salesperson'])) {
			$quotesquery = (new QueryBuilder())->table('quothed');
			$quotesquery->field('quotnbr');
			$quotesquery->where(
				$quotesquery
				->orExpr()
				->where('sp1', $filter['salesperson'])
				->where('sp2', $filter['salesperson'])
				->where('sp3', $filter['salesperson'])
			);
			$q->where('quotnbr', $quotesquery);
			unset($filter['salesperson']);
		}
		
		if (!empty($filter)) {
			$q->generate_filters($filter, $filtertypes);
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	/**
	 * Returns the Max Quote Total
	 * @param  string  $sessionID   Session Identifier
	 * @param  string  $custID      Customer ID 
	 * @param  string  $shiptoID    Customer Shipto ID
	 * @param  array   $filter      Array that contains the column and the values to filter for
	 * @param  array   $filtertypes Array that contains the filterable columns as keys, and the rules needed
	 * @param  bool    $debug       Run in debug? If so return SQL Query
	 * @return float               Max Quote Total
	 */
	function get_maxquotetotal($sessionID, $custID = '', $shiptoID = '', $filter = false, $filtertypes = false, $debug = false) {
		$q = (new QueryBuilder())->table('quothed');
		$q->field($q->expr('MAX(ordertotal)'));
		$q->where('sessionid', $sessionID);
		
		if (isset($filter['salesperson'])) {
			$quotesquery = (new QueryBuilder())->table('quothed');
			$quotesquery->field('quotnbr');
			$quotesquery->where(
				$quotesquery
				->orExpr()
				->where('sp1', $filter['salesperson'])
				->where('sp2', $filter['salesperson'])
				->where('sp3', $filter['salesperson'])
			);
			$q->where('quotnbr', $quotesquery);
			unset($filter['salesperson']);
		}
		
		if (!empty($custID)) {
			$q->where('custid', $custID);
			if (!empty($shiptoID)) {
				$q->where('shiptoid', $shiptoID);
			}
		}

		
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	/**
	 * Returns the Min Quote Total
	 * @param  string  $sessionID   Session Identifier
	 * @param  string  $custID      Customer ID 
	 * @param  string  $shiptoID    Customer Shipto ID
	 * @param  array   $filter      Array that contains the column and the values to filter for
	 * @param  array   $filtertypes Array that contains the filterable columns as keys, and the rules needed
	 * @param  bool    $debug       Run in debug? If so return SQL Query
	 * @return float               Min Quote Total
	 */
	function get_minquotetotal($sessionID, $custID = '', $shiptoID = '', $filter = false, $filtertypes = false, $debug = false) {
		$q = (new QueryBuilder())->table('quothed');
		$q->field($q->expr('MIN(ordertotal)'));
		$q->where('sessionid', $sessionID);
		
		if (isset($filter['salesperson'])) {
			$quotesquery = (new QueryBuilder())->table('quothed');
			$quotesquery->field('quotnbr');
			$quotesquery->where(
				$quotesquery
				->orExpr()
				->where('sp1', $filter['salesperson'])
				->where('sp2', $filter['salesperson'])
				->where('sp3', $filter['salesperson'])
			);
			$q->where('quotnbr', $quotesquery);
			unset($filter['salesperson']);
		}
		
		if (!empty($custID)) {
			$q->where('custid', $custID);
			if (!empty($shiptoID)) {
				$q->where('shiptoid', $shiptoID);
			}
		}
		
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	/**
	 * Returns the Min Quote Date
	 * @param  string  $sessionID   Session Identifier
	 * @param  string  $custID      Customer ID 
	 * @param  string  $shiptoID    Customer Shipto ID
	 * @param  string  $field       Date Column
	 * @param  array   $filter      Array that contains the column and the values to filter for
	 * @param  array   $filtertypes Array that contains the filterable columns as keys, and the rules needed
	 * @param  bool    $debug       Run in debug? If so return SQL Query
	 * @return string               Min Quote Date
	 */
	function get_minquotedate($sessionID, $custID = '', $shiptoID = '', $field, $filter = false, $filtertypes = false, $debug = false) {
		$q = (new QueryBuilder())->table('quothed');
		$q->field($q->expr("MIN(STR_TO_DATE($field, '%m/%d/%Y'))"));
		$q->where('sessionid', $sessionID);
		
		if (isset($filter['salesperson'])) {
			$quotesquery = (new QueryBuilder())->table('quothed');
			$quotesquery->field('quotnbr');
			$quotesquery->where(
				$quotesquery
				->orExpr()
				->where('sp1', $filter['salesperson'])
				->where('sp2', $filter['salesperson'])
				->where('sp3', $filter['salesperson'])
			);
			$q->where('quotnbr', $quotesquery);
			unset($filter['salesperson']);
		}
		
		if (!empty($custID)) {
			$q->where('custid', $custID);
			if (!empty($shiptoID)) {
				$q->where('shiptoid', $shiptoID);
			}
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	/**
	 * Returns Customer ID from Quote
	 * @param  string $sessionID Session Identifier
	 * @param  string $qnbr      Quote Number
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return string            Customer ID from Quote
	 */
	function get_custidfromquote($sessionID, $qnbr, $debug = false) {
		$q = (new QueryBuilder())->table('quothed');
		$q->field('custid');
		$q->where('sessionid', $sessionID);
		$q->where('quotnbr', $qnbr);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	/**
	 * Returns Customer Shipto ID from Quote
	 * @param  string $sessionID Session Identifier
	 * @param  string $qnbr      Quote Number
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return string            Customer Shipto ID from Quote
	 */
	function get_shiptoidfromquote($sessionID, $qnbr, $debug = false) {
		$q = (new QueryBuilder())->table('quothed');
		$q->field('shiptoid');
		$q->where('sessionid', $sessionID);
		$q->where('quotnbr', $qnbr);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	/**
	 * Returns the Quotes that meet the filter criteria
	 * @param  string $sessionID   Session Identifier
	 * @param  int    $limit       Number of Quotes to Return
	 * @param  int    $page        Page to Generate offset for
	 * @param  array  $filter      Array that contains the column and the values to filter for
	 * @param  array  $filtertypes Array that contains the filterable columns as keys, and the rules needed
	 * @param  bool   $useclass    Return Quote as Quote | array
	 * @param  bool   $debug       Run in debug? If so, return SQL Query
	 * @return array               Quotes
	 */
	function get_quotes($sessionID, $limit, $page = 1, $filter = false, $filtertypes = false, $useclass = false, $debug = false) {
		$q = (new QueryBuilder())->table('quothed');
		$q->where('sessionid', $sessionID);
		
		if (isset($filter['salesperson'])) {
			$quotesquery = (new QueryBuilder())->table('quothed');
			$quotesquery->field('quotnbr');
			$quotesquery->where(
				$quotesquery
				->orExpr()
				->where('sp1', $filter['salesperson'])
				->where('sp2', $filter['salesperson'])
				->where('sp3', $filter['salesperson'])
			);
			$q->where('quotnbr', $quotesquery);
			unset($filter['salesperson']);
		}
		if (!empty($filter)) {
			$q->generate_filters($filter, $filtertypes);
		}
		$q->limit($limit, $q->generate_offset($page, $limit));
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			if ($useclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'Quote');
				return $sql->fetchAll();
			}
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	
	/**
	 * Returns the Quotes that meet the filter criteria, and Sorted by Quote Date
	 * @param  string $sessionID   Session Identifier
	 * @param  int    $limit       Number of Quotes to Return
	 * @param  int    $page        Page to Generate offset for
	 * @param  string $sortrule    Sort ASC | DESC
	 * @param  array  $filter      Array that contains the column and the values to filter for
	 * @param  array  $filtertypes Array that contains the filterable columns as keys, and the rules needed
	 * @param  bool   $useclass    Return Quote as Quote | array
	 * @param  bool   $debug       Run in debug? If so, return SQL Query
	 * @return array               Quotes
	 */
	function get_quotes_orderby_quotedate($sessionID, $limit = 10, $page = 1, $sortrule, $filter = false, $filtertypes = false, $useclass = false, $debug = false) {
		$q = (new QueryBuilder())->table('quothed');
		$q->field('quothed.*');
		$q->field($q->expr("STR_TO_DATE(quotdate, '%m/%d/%Y') as quotedate"));
		$q->where('sessionid', $sessionID);
		
		if (isset($filter['salesperson'])) {
			$quotesquery = (new QueryBuilder())->table('quothed');
			$quotesquery->field('quotnbr');
			$quotesquery->where(
				$quotesquery
				->orExpr()
				->where('sp1', $filter['salesperson'])
				->where('sp2', $filter['salesperson'])
				->where('sp3', $filter['salesperson'])
			);
			$q->where('quotnbr', $quotesquery);
			unset($filter['salesperson']);
		}
		
		if (!empty($filter)) {
			$q->generate_filters($filter, $filtertypes);
		}
		$q->limit($limit, $q->generate_offset($page, $limit));
		$q->order('quotedate', $sortrule);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			if ($useclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'Quote');
				return $sql->fetchAll();
			}
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	
	/**
	 * Returns the Quotes that meet the filter criteria, and Sorted by Review Date
	 * @param  string $sessionID   Session Identifier
	 * @param  int    $limit       Number of Quotes to Return
	 * @param  int    $page        Page to Generate offset for
	 * @param  string $sortrule    Sort ASC | DESC
	 * @param  array  $filter      Array that contains the column and the values to filter for
	 * @param  array  $filtertypes Array that contains the filterable columns as keys, and the rules needed
	 * @param  bool   $useclass    Return Quote as Quote | array
	 * @param  bool   $debug       Run in debug? If so, return SQL Query
	 * @return array               Quotes
	 */
	function get_quotes_orderby_revdate($sessionID, $limit = 10, $page = 1, $sortrule, $filter = false, $filtertypes = false, $useclass = false, $debug = false) {
		$q = (new QueryBuilder())->table('quothed');
		$q->field('quothed.*');
		$q->field($q->expr("STR_TO_DATE(revdate, '%m/%d/%Y') as reviewdate"));
		$q->where('sessionid', $sessionID);
		
		if (isset($filter['salesperson'])) {
			$quotesquery = (new QueryBuilder())->table('quothed');
			$quotesquery->field('quotnbr');
			$quotesquery->where(
				$quotesquery
				->orExpr()
				->where('sp1', $filter['salesperson'])
				->where('sp2', $filter['salesperson'])
				->where('sp3', $filter['salesperson'])
			);
			$q->where('quotnbr', $quotesquery);
			unset($filter['salesperson']);
		}
		
		if (!empty($filter)) {
			$q->generate_filters($filter, $filtertypes);
		}
		$q->limit($limit, $q->generate_offset($page, $limit));
		$q->order('reviewdate', $sortrule);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			if ($useclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'Quote');
				return $sql->fetchAll();
			}
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	/**
	 * Returns the Quotes that meet the filter criteria, and Sorted Expiration Date
	 * @param  string $sessionID   Session Identifier
	 * @param  int    $limit       Number of Quotes to Return
	 * @param  int    $page        Page to Generate offset for
	 * @param  string $sortrule    Sort ASC | DESC
	 * @param  array  $filter      Array that contains the column and the values to filter for
	 * @param  array  $filtertypes Array that contains the filterable columns as keys, and the rules needed
	 * @param  bool   $useclass    Return Quote as Quote | array
	 * @param  bool   $debug       Run in debug? If so, return SQL Query
	 * @return array               Quotes
	 */
	function get_quotes_orderby_expdate($sessionID, $limit = 10, $page = 1, $sortrule, $filter = false, $filtertypes = false, $useclass = false, $debug = false) {
		$q = (new QueryBuilder())->table('quothed');
		$q->field('quothed.*');
		$q->field($q->expr("STR_TO_DATE(expdate, '%m/%d/%Y') as expiredate"));
		
		if (isset($filter['salesperson'])) {
			$quotesquery = (new QueryBuilder())->table('quothed');
			$quotesquery->field('quotnbr');
			$quotesquery->where(
				$quotesquery
				->orExpr()
				->where('sp1', $filter['salesperson'])
				->where('sp2', $filter['salesperson'])
				->where('sp3', $filter['salesperson'])
			);
			$q->where('quotnbr', $quotesquery);
			unset($filter['salesperson']);
		}
		if (!empty($filter)) {
			$q->generate_filters($filter, $filtertypes);
		}
		$q->limit($limit, $q->generate_offset($page, $limit));
		$q->order('expiredate', $sortrule);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			if ($useclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'Quote');
				return $sql->fetchAll();
			}
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	
	/**
	 * Returns the Quotes that meet the filter criteria, and Sorted by $column
	 * @param  string $sessionID   Session Identifier
	 * @param  int    $limit       Number of Quotes to Return
	 * @param  int    $page        Page to Generate offset for
	 * @param  string $sortrule    Sort ASC | DESC
	 * @param  string $orderby     Column to Order By
	 * @param  array  $filter      Array that contains the column and the values to filter for
	 * @param  array  $filtertypes Array that contains the filterable columns as keys, and the rules needed
	 * @param  bool   $useclass    Return Quote as Quote | array
	 * @param  bool   $debug       Run in debug? If so, return SQL Query
	 * @return array               Quotes
	 */
	function get_quotes_orderby($sessionID, $limit = 10, $page = 1, $sortrule = 'ASC', $orderby, $filter = false, $filtertypes = false, $useclass = true, $debug = false) {
		$q = (new QueryBuilder())->table('quothed');
		$q->field('quothed.*');
		$q->where('sessionid', $sessionID);
		
		if (isset($filter['salesperson'])) {
			$quotesquery = (new QueryBuilder())->table('quothed');
			$quotesquery->field('quotnbr');
			$quotesquery->where(
				$quotesquery
				->orExpr()
				->where('sp1', $filter['salesperson'])
				->where('sp2', $filter['salesperson'])
				->where('sp3', $filter['salesperson'])
			);
			$q->where('quotnbr', $quotesquery);
			unset($filter['salesperson']);
		}
		if (!empty($filter)) {
			$q->generate_filters($filter, $filtertypes);
		}
		$q->limit($limit, $q->generate_offset($page, $limit));
		$q->order($orderby, $sortrule);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			if ($useclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'Quote');
				return $sql->fetchAll();
			}
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function get_quotehead($sessionID, $qnbr, $useclass = false, $debug = false) {
		$q = (new QueryBuilder())->table('quothed');
		$q->where('sessionid', $sessionID);
		$q->where('quotnbr', $qnbr);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			if ($useclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'Quote');
				return $sql->fetch();
			}
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}
	
	function count_quotedetails($sessionID, $qnbr, $debug = false) {
		$q = (new QueryBuilder())->table('quotdet');
		$q->field($q->expr('COUNT(*)'));
		$q->where('quotenbr', $qnbr);
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	function get_quotedetails($sessionID, $qnbr, $useclass = false, $debug) {
		$q = (new QueryBuilder())->table('quotdet');
		$q->where('sessionid', $sessionID);
		$q->where('quotenbr', $qnbr);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			if ($useclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'QuoteDetail');
				return $sql->fetchAll();
			}
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	
	function get_quotedetail($sessionID, $qnbr, $linenbr, $debug = false) {
		$q = (new QueryBuilder())->table('quotdet');
		$q->where('sessionid', $sessionID);
		$q->where('quotenbr', $qnbr);
		$q->where('linenbr', $linenbr);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'QuoteDetail');
			return $sql->fetch();
		}
	}

	function nextquotelinenbr($sessionID, $qnbr) {
		$sql = DplusWire::wire('dplusdatabase')->prepare("SELECT MAX(linenbr) FROM quotdet WHERE sessionid = :sessionID AND quotenbr = :qnbr ");
		$switching = array(':sessionID' => $sessionID, ':qnbr' => $qnbr); $withquotes = array(true, true);
		$sql->execute($switching);
		return intval($sql->fetchColumn()) + 1;
	}

	

	function edit_quotehead($sessionID, $qnbr, Quote $quote, $debug = false) {
		$originalquote = Quote::load($sessionID, $qnbr);
		$properties = array_keys($quote->_toArray());
		$q = (new QueryBuilder())->table('quothed');
		$q->mode('update');

		foreach ($properties as $property) {
			if ($quote->$property != $originalquote->$property) {
				$q->set($property, $quote->$property);
			}
		}
		$q->where('quotnbr', $quote->quotnbr);
		$q->where('sessionid', $quote->sessionid);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			if ($quote->has_changes()) {
				Processwire\wire('session')->execute = true;
				$sql->execute($q->params);
			}
			return $q->generate_sqlquery($q->params);
		}
	}

	function update_quotedetail($sessionID, QuoteDetail $detail, $debug = false) {
		$originaldetail = QuoteDetail::load($sessionID, $detail->quotenbr, $detail->linenbr);
		$properties = array_keys($detail->_toArray());
		$q = (new QueryBuilder())->table('quotdet');
		$q->mode('update');
		foreach ($properties as $property) {
			if ($detail->$property != $originaldetail->$property) {
				$q->set($property, $detail->$property);
			}
		}
		$q->where('quotenbr', $detail->quotenbr);
		$q->where('sessionid', $detail->sessionid);
		$q->where('linenbr', $detail->recno);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			if ($detail->has_changes()) {
				$sql->execute($q->params);
			}
			return $q->generate_sqlquery($q->params);
		}
	}

	function insert_quotedetail($sessionID, QuoteDetail $detail, $debug = false) {
		$properties = array_keys($detail->_toArray());
		$q = (new QueryBuilder())->table('quotdet');
		$q->mode('insert');
		foreach ($properties as $property) {
			if (!empty($detail->$property) || strlen($detail->$property)) {
				$q->set($property, $detail->$property);
			}
		}
		$q->where('quotenbr', $detail->quotenbr);
		$q->where('sessionid', $detail->sessionid);
		$q->where('recno', $detail->recno);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			if ($detail->has_changes()) {
				$sql->execute($q->params);
			}
			return $q->generate_sqlquery($q->params);
		}
	}

	function insert_orderlock($sessionID, $recnbr, $ordn, $userID, $date, $time, $debug) {
		$sql = DplusWire::wire('dplusdatabase')->prepare("INSERT INTO ordlock (sessionid, recno, date, time, ordernumber, userid) VALUES (:sessionID, :recnbr, :date, :time, :ordernumber, :userID)");
		$switching = array(':sessionID' => $sessionID, ':recnbr' => $recnbr, ':date' => $time, ':time' => $time, ':ordernumber' => $ordn, ':userID' => $userID);
		$withquotes = array(true, true, true, true, true, true);

		if ($debug) {
			return	returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		}
	}

	function remove_orderlock($sessionID, $ordn, $userID, $debug) {
		$sql = DplusWire::wire('dplusdatabase')->prepare("DELETE FROM ordlock WHERE sessionid = :sessionID AND ordernumber = :ordn AND userid = :userID");
		$switching = array(':sessionID' => $sessionID, ':ordn' => $ordn, ':userID' => $userID);
		$withquotes = array(true, true, true);

		if ($debug) {
			return	returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		}
	}

/* =============================================================
	QNOTES FUNCTIONS
============================================================ */
	function get_qnotes($sessionID, $key1, $key2, $type, $useclass = false, $debug = false) {
		$q = (new QueryBuilder())->table('qnote');
		$q->where('sessionid', $sessionID);
		$q->where('key1', $key1);
		$q->where('key2', $key2);
		$q->where('rectype', $type);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			if ($useclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'QNote');
				return $sql->fetchAll();
			}
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function get_qnote($sessionID, $key1, $key2, $type, $recnbr, $useclass = false, $debug = false) {
		$q = (new QueryBuilder())->table('qnote');
		$q->where('sessionid', $sessionID);
		$q->where('key1', $key1);
		$q->where('key2', $key2);
		$q->where('rectype', $type);
		$q->where('recno', $recnbr);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			if ($useclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'QNote');
				return $sql->fetch();
			}
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

	function count_qnotes($sessionID, $key1, $key2, $type, $debug = false) {
		$q = (new QueryBuilder())->table('qnote');
		$q->field($q->expr('COUNT(*)'));
		$q->where('sessionid', $sessionID);
		$q->where('key1', $key1);
		$q->where('key2', $key2);
		$q->where('rectype', $type);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	function has_dplusnote($sessionID, $key1, $key2, $type) {
		if (count_qnotes($sessionID, $key1, $key2, $type)) {
			return 'Y';
		} else {
			return 'N';
		}
	}

	function update_note($sessionID, Qnote $qnote, $debug = false) {
		$originalnote = Qnote::load($sessionID, $qnote->key1, $qnote->key2, $qnote->rectype, $qnote->recno); // LOADS as Class
		$q = (new QueryBuilder())->table('qnote');
		$q->mode('update');
		$q->set('notefld', $qnote->notefld);
		$q->where('sessionid', $sessionID);
		$q->where('key1', $qnote->key1);
		$q->where('key2', $qnote->key2);
		$q->where('form1', $qnote->form1);
		$q->where('form2', $qnote->form2);
		$q->where('form3', $qnote->form3);
		$q->where('form4', $qnote->form4);
		$q->where('form5', $qnote->form5);
		$q->where('recno', $qnote->recno);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return array(
				'sql' => $q->generate_sqlquery($q->params),
				'success' => $sql->rowCount() ? true : false,
				'updated' => $sql->rowCount() ? true : false,
				'querytype' => 'update'
			);
		}
	}

	function add_qnote($sessionID, Qnote $qnote, $debug = false) {
		$q = (new QueryBuilder())->table('qnote');
		$q->mode('insert');
		$qnote->recno = get_maxqnoterecnbr($qnote->sessionid, $qnote->key1, $qnote->key2, $qnote->rectype) + 1;

		foreach ($qnote->_toArray() as $property => $value) {
			$q->set($property, $value);
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return array(
				'sql' => $q->generate_sqlquery($q->params),
				'success' => $sql->rowCount() ? true : false,
				'updated' => $sql->rowCount() ? true : false,
				'querytype' => 'insert'
			);
		}
	}

	function get_maxqnoterecnbr($sessionID, $key1, $key2, $rectype, $debug = false) {
		$q = (new QueryBuilder())->table('qnote');
		$q->field($q->expr('MAX(recno)'));
		$q->where('sessionid', $sessionID);
		$q->where('key1', $key1);
		$q->where('key2', $key2);
		//$q->where('rectype', $rectype);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return intval($sql->fetchColumn());
		}
	}

	function delete_note($sessionID, Qnote $qnote, $debug = false) {
		$q = (new QueryBuilder())->table('qnote');
		$q->mode('delete');
		$q->where('sessionid', $sessionID);
		$q->where('key1', $qnote->key1);
		$q->where('key2', $qnote->key2);
		$q->where('form1', $qnote->form1);
		$q->where('form2', $qnote->form2);
		$q->where('form3', $qnote->form3);
		$q->where('form4', $qnote->form4);
		$q->where('form5', $qnote->form5);
		$q->where('recno', $qnote->recno);
		$q->where('rectype', $qnote->rectype);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return array(
				'sql' => $q->generate_sqlquery($q->params),
				'success' => $sql->rowCount() ? true : false,
				'updated' => $sql->rowCount() ? true : false,
				'querytype' => 'update'
			);
		}
	}

/* =============================================================
	PRODUCT FUNCTIONS
============================================================ */
	function get_itemsearchresults($sessionID, $limit = 10, $page = 1, $debug = false) {
		$q = (new QueryBuilder())->table('pricing');
		$q->where('sessionid', $sessionID);
		if (!empty($limit)) {
			$q->limit($limit, $q->generate_offset($page, $limit));
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'PricingItem');
			return $sql->fetchAll();
		}
	}

	function count_itemsearchresults($sessionID, $debug = false) {
		$q = (new QueryBuilder())->table('pricing');
		$q->field($q->expr('COUNT(*)'));
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	function count_itemhistory($sessionID, $itemID, $debug = false) {
		$q = (new QueryBuilder())->table('custpricehistory');
		$q->field($q->expr('COUNT(*)'));
		$q->where('sessionid', $sessionID);
		$q->where('itemid', $itemID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	function get_itemhistoryfield($sessionID, $itemID, $field, $debug = false) {
		$q = (new QueryBuilder())->table('custpricehistory');
		$q->field($field);
		$q->where('sessionid', $sessionID);
		$q->where('itemid', $itemID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	function get_itemavailability($sessionID, $itemID, $debug = false) {
		$q = (new QueryBuilder())->table('whseavail');
		$q->where('sessionid', $sessionID);
		$q->where('itemid', $itemID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function get_commissionprices($itemID, $debug = false) {
		$q = (new QueryBuilder())->table('commprice');
		$q->where('itemid', $itemID);
		$q->order('percent DESC');
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function get_pricingitem($sessionID, $itemID, $debug = false) {
		$q = (new QueryBuilder())->table('pricing');
		$q->where('sessionid', $sessionID);
		$q->where('itemid', $itemID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'PricingItem');
			return $sql->fetch();
		}
	}

	/* =============================================================
		USER ACTION FUNCTIONS
	============================================================ */
	function count_actions($filters, $filterable, $debug = false) {
		$q = (new QueryBuilder())->table('useractions');
		$q->field($q->expr('COUNT(*)'));
		$q->generate_filters($filters, $filterable);

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	function get_actions($filters, $filterable, $limit = 0, $page = 0, $debug = false) {
		$q = (new QueryBuilder())->table('useractions');
		$q->generate_filters($filters, $filterable);

		if (DplusWire::wire('config')->cptechcustomer == 'stempf') {
			$q->order($q->generate_orderby("duedate-ASC"));
		}
		if ($limit) {
			$q->limit($limit, $q->generate_offset($page, $limit));
		}

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'UserAction');
			return $sql->fetchAll();
		}
	}

	function count_dayallactions($day, $filters, $filterable, $debug = false) {
		$q = (new QueryBuilder())->table('useractions');
		$taskquery = (new QueryBuilder())->table('useractions')->field('id')->where('actiontype', 'task');
		if (!isset($filters['datecompleted'])) {
			$taskquery->where($q->expr('DATE(duedate)'), $q->expr("STR_TO_DATE([], [])", [$day, $q->generate_dateformat('duedate', $filterable)]));
		}
		$actionsquery = (new QueryBuilder())->table('useractions')->field('id')->where('actiontype', '!=', 'task')->where($q->expr('DATE(datecreated)'), $q->expr("STR_TO_DATE([], [])", [$day, $q->generate_dateformat('datecreated', $filterable)]));

		$q->field($q->expr('COUNT(*)'));
		$q->where(
			$q
			->orExpr()
			->where('id', 'in', $taskquery)
			->where('id', 'in', $actionsquery)
		);
		$q->generate_filters($filters, $filterable);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	function get_dayallactions($day, $filters, $filterable, $debug = false) {
		$q = (new QueryBuilder())->table('useractions');
		$taskquery = (new QueryBuilder())->table('useractions')->field('id')->where('actiontype', 'task');
		if (!isset($filters['datecompleted'])) {
			$taskquery->where($q->expr('DATE(duedate)'), $q->expr("STR_TO_DATE([], [])", [$day, $q->generate_dateformat('duedate', $filterable)]));
		}
		$actionsquery = (new QueryBuilder())->table('useractions')->field('id')->where('actiontype', '!=', 'task')->where($q->expr('DATE(datecreated)'), $q->expr("STR_TO_DATE([], [])", [$day, $q->generate_dateformat('datecreated', $filterable)]));

		$q->where(
			$q->orExpr()->where('id', 'in', $taskquery)->where('id', 'in', $actionsquery)
		);
		$q->generate_filters($filters, $filterable);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'UserAction');
			return $sql->fetchAll();
		}
	}

	function get_daypriorincompletetasks($day, $filters, $filterable, $debug = false) {
		$q = (new QueryBuilder())->table('useractions');
		$q->where('actiontype', 'task');
		$q->where($q->expr('DATE(duedate)'), '<=', $q->expr("STR_TO_DATE([], [])", [$day, $q->generate_dateformat('duedate', $filterable)]));
		$q->order('duedate', 'ASC');

		$q->generate_filters($filters, $filterable);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'UserAction');
			return $sql->fetchAll();
		}
	}

	function count_daypriorincompletetasks($day, $filters, $filterable, $debug = false) {
		$q = (new QueryBuilder())->table('useractions');
		$q->field($q->expr('COUNT(*)'));
		$q->where('actiontype', 'task');
		$q->where($q->expr('DATE(duedate)'), '<=', $q->expr("STR_TO_DATE([], [])", [$day, $q->generate_dateformat('duedate', $filterable)]));
		$q->order('duedate', 'ASC');

		$q->generate_filters($filters, $filterable);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	function get_useraction($id, $debug = false) {
		$q = (new QueryBuilder())->table('useractions');
		$q->where('id', $id);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'UserAction');
			return $sql->fetch();
		}
	}

	function edit_useraction(UserAction $updatedaction, $debug = false) {
		$originalaction = UserAction::load($updatedaction->id); // (id, bool fetchclass, bool debug)
		$q = (new QueryBuilder())->table('useractions');
		$q->mode('update');
		$q->generate_setdifferencesquery($originalaction->_toArray(), $updatedaction->_toArray());
		$q->where('id', $updatedaction->id);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			$sql->execute($q->params);
			$success = $sql->rowCount();
			if ($success) {
				return array("error" => false,  "sql" => $q->generate_sqlquery($q->params));
			} else {
				return array("error" => true,  "sql" => $q->generate_sqlquery($q->params));
			}
		}
	}

	function update_useraction(UserAction $updatedaction, $debug = false) {
		return edit_useraction($updatedaction, $debug);
	}

	function update_useractionlinks(UserAction $oldlinks, UserAction $newlinks, $debug = false) {
		$q = (new QueryBuilder())->table('useractions');
		$q->mode('update');
		$q->generate_setdifferencesquery($oldlinks->_toArray(), $newlinks->_toArray());
		$q->set('dateupdated', date("Y-m-d H:i:s"));
		foreach ($oldlinks->get_linkswithvaluesarray() as $linkcolumn => $val) {
			$q->where($linkcolumn, $val);
		}
		
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			$sql->execute($q->params);
			$success = $sql->rowCount();
			if ($success) {
				return array("error" => false,  "sql" => $q->generate_sqlquery($q->params));
			} else {
				return array("error" => true,  "sql" => $q->generate_sqlquery($q->params));
			}
		}
	}

	function create_useraction(UserAction $action, $debug = false) {
		$q = (new QueryBuilder())->table('useractions');
		$q->mode('insert');
		$q->generate_setvaluesquery($action->_toArray());
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return array('sql' => $q->generate_sqlquery($q->params), 'insertedid' => DplusWire::wire('dplusdatabase')->lastInsertId());
		}
	}

	function get_maxuseractionid($loginID, $debug = false) {
		$q = (new QueryBuilder())->table('useractions');
		$q->field($q->expr('MAX(id)'));
		$q->where('createdby', $loginID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		$sql->execute($q->params);

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	function get_mindateuseractioncreated($custID = false, $shipID = false, $debug = false) {
		$q = (new QueryBuilder())->table('useractions');
		$q->field($q->expr("DATE_FORMAT(MIN(datecreated), '%m/%d/%Y')"));
		if ($custID) {
			$q->where('customerlink', $custID);
		}
		if ($shipID) {
			$q->where('shiptolink', $shipID);
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	function get_mindateuseractioncompleted($custID = false, $shipID = false, $debug = false) {
		$q = (new QueryBuilder())->table('useractions');
		$q->field($q->expr("DATE_FORMAT(MIN(datecreated), '%m/%d/%Y')"));
		if ($custID) {
			$q->where('customerlink', $custID);
		}
		if ($shipID) {
			$q->where('shiptolink', $shipID);
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

/* =============================================================
	VENDOR FUNCTIONS
============================================================ */
	function get_vendors($debug = false) {
		$q = (new QueryBuilder())->table('vendors');
		$q->where('shipfrom', '');
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'Vendor');
			return $sql->fetchAll();
		}
	}

	function get_vendor($vendorID, $shipfromID = '', $debug = false) {
		$q = (new QueryBuilder())->table('vendors');
		$q->where('vendid', $vendorID);
		$q->where('shipfrom', $shipfromID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'Vendor');
			return $sql->fetch();
		}
	}

	function getvendorshipfroms($vendorID, $debug) {
		$sql = DplusWire::wire('dplusdatabase')->prepare("SELECT * FROM vendors WHERE vendid = :vendor AND shipfrom != ''");
		$switching = array(':vendor' => $vendorID); $withquotes = array(true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function search_vendorspaged($limit = 10, $page = 1, $keyword, $debug) {
		$SHARED_ACCOUNTS = Processwire\wire('config')->sharedaccounts;
		$limiting = returnlimitstatement($limit, $page);
		$search = '%'.str_replace(' ', '%',$keyword).'%';
		$sql = DplusWire::wire('dplusdatabase')->prepare("SELECT * FROM vendors WHERE UCASE(CONCAT(vendid, ' ', shipfrom, ' ', name, ' ', address1, ' ', address2, ' ', address3, ' ', city, ' ', state, ' ', zip, ' ', country, ' ', phone, ' ', fax, ' ', email)) LIKE UCASE(:search) $limiting");
		$switching = array(':search' => $search); $withquotes = array(true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function count_searchvendors($keyword, $debug) {
		$SHARED_ACCOUNTS = Processwire\wire('config')->sharedaccounts;
		$search = '%'.str_replace(' ', '%',$keyword).'%';
		$sql = DplusWire::wire('dplusdatabase')->prepare("SELECT COUNT(*) FROM vendors WHERE UCASE(CONCAT(vendid, ' ', shipfrom, ' ', name, ' ', address1, ' ', address2, ' ', address3, ' ', city, ' ', state, ' ', zip, ' ', country, ' ', phone, ' ', fax, ' ', email)) LIKE UCASE(:search)");
		$switching = array(':search' => $search); $withquotes = array(true);
		if ($debug) {
			return returnsqlquery($sql->queryString, $switching, $withquotes);
		} else {
			$sql->execute($switching);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function get_unitofmeasurements($debug) {
		$q = (new QueryBuilder())->table('unitofmeasure');
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function get_itemgroups($debug = false) {
		$q = (new QueryBuilder())->table('itemgroups');
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function get_vendorname($vendorID) {
		$sql = DplusWire::wire('dplusdatabase')->prepare("SELECT name FROM vendors WHERE vendid = :vendorID LIMIT 1");
		$switching = array(':vendorID' => $vendorID);
		$sql->execute($switching);
		return $sql->fetchColumn();
	}

/* =============================================================
	CART FUNCTIONS
============================================================ */
	/**
	 * Returns if Session has a carthead record
	 * @param  string $sessionID Session Identifier
	 * @param  bool   $debug     Run in debug?
	 * @return bool              If there's a carthead record will return 1 / true
	 */
	function has_carthead($sessionID, $debug = false) {
		$q = (new QueryBuilder())->table('carthed');
		$q->field($q->expr("IF(COUNT(*) > 0, 1, 0)"));
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	/**
	 * Returns the Cart's current Customer ID
	 * @param  string $sessionID Session Identifier
	 * @param  bool   $debug     Run in debug? If so returns SQL Query
	 * @return string            Cart Customer ID
	 */
	function get_custidfromcart($sessionID, $debug = false) {
		$q = (new QueryBuilder())->table('carthed');
		$q->field('custid');
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns the carthead record for this session
	 * @param  string $sessionID Session Identifier
	 * @param  bool   $debug     Run in debug? If so returns SQL Query
	 * @return CartQuote            CartQuote
	 */
	function get_carthead($sessionID, $debug = false) {
		$q = (new QueryBuilder())->table('carthed');
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'CartQuote');
			return $sql->fetch();
		}
	}

	/**
	 * Returns the number of Cart Items for this session
	 * @param  string $sessionID Session Identifier
	 * @param  bool   $debug     Run in debug? If so return SQL Query
	 * @return int               Number of Cart Items for this session
	 */
	function count_cartdetails($sessionID, $debug = false) {
		$q = (new QueryBuilder())->table('cartdet');
		$q->field('COUNT(*)');
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns an array of CartDetails
	 * @param  string $sessionID Session Identifier
	 * @param  bool   $useclass  Use CartDetail Class?
	 * @param  bool   $debug     Run in debug? If so return SQL Query
	 * @return array             CartDetails
	 */
	function get_cartdetails($sessionID, $useclass = true, $debug = false) {
		$q = (new QueryBuilder())->table('cartdet');
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			if ($useclass) {
				$sql->setFetchMode(PDO::FETCH_CLASS, 'CartDetail');
				return $sql->fetchAll();
			}
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	/**
	 * Return the CartDetail for this session and Line Number
	 * @param  string     $sessionID Session Identifier
	 * @param  int        $linenbr   Detail Line Number
	 * @param  bool       $debug     Run in debug?
	 * @return CartDetail            Cart Detail Line
	 */
	function get_cartdetail($sessionID, $linenbr, $debug = false) {
		$q = (new QueryBuilder())->table('cartdet');
		$q->where('sessionid', $sessionID);
		$q->where('linenbr', $linenbr);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'CartDetail');
			return $sql->fetch();
		}
	}
	
	/**
	 * Inserts new carthead record
	 * @param  string    $sessionID Session Identifier
	 * @param  CartQuote $cart      Cart Header
	 * @param  bool      $debug     Run in debug? IF so, return SQL Query
	 * @return bool                 Was Record Inserted?
	 */
	function insert_carthead($sessionID, CartQuote $cart, $debug = false) {
		$properties = array_keys($cart->_toArray());
		$q = (new QueryBuilder())->table('carthed');
		$q->mode('insert');
		$cart->set('date', date('Ymd'));
		$cart->set('time', date('His'));
		foreach ($properties as $property) {
			if (!empty($cart->$property)) {
				$q->set($property, $cart->$property);
			}
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return DplusWire::wire('dplusdatabase')->lastInsertId() > 0 ? true : false;
		}
	}
	
	/**
	 * Updates carthead record
	 * @param  string    $sessionID Session Identifier
	 * @param  CartQuote $cart      Cart Header
	 * @param  bool      $debug     Run in debug? If so, return SQL Query
	 * @return int                  Was Record Updated?
	 */
	function update_carthead($sessionID, CartQuote $cart, $debug = false) {
		$originalcart = CartQuote::load($sessionID);
		$properties = array_keys($cart->_toArray());
		$q = (new QueryBuilder())->table('carthed');
		$q->mode('update');
		$cart->set('date', date('Ymd'));
		$cart->set('time', date('His'));
		foreach ($properties as $property) {
			if ($cart->$property != $originalcart->$property) {
				$q->set($property, $cart->$property);
			}
		}
		$q->where('sessionid', $cart->sessionid);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return boolval($sql->rowCount());
		}
	}

	/**
	 * Updates the CartDetail record (cartdet) in the database
	 * @param  string     $sessionID Session Identifier
	 * @param  CartDetail $detail    CartDetail Object with changes, will use CartDetail properties to load original
	 * @param  bool       $debug     Run in debug?
	 * @return string                SQL Query
	 */
	function update_cartdetail($sessionID, CartDetail $detail, $debug = false) {
		$originaldetail = CartDetail::load($sessionID, $detail->linenbr);
		$properties = array_keys($detail->_toArray());
		$q = (new QueryBuilder())->table('cartdet');
		$q->mode('update');
		foreach ($properties as $property) {
			if ($detail->$property != $originaldetail->$property) {
				$q->set($property, $detail->$property);
			}
		}
		$q->where('sessionid', $detail->sessionid);
		$q->where('linenbr', $detail->linenbr);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			if ($detail->has_changes()) {
				$sql->execute($q->params);
			}
			return $q->generate_sqlquery($q->params);
		}
	}

	/**
	 * Inserts CartDetail (cartdet) record into database
	 * @param  string     $sessionID Session Identifier
	 * @param  CartDetail $detail    CartDetail object to insert
	 * @param  bool       $debug     Run in debug?
	 * @return string                SQL Query
	 */
	function insert_cartdetail($sessionID, CartDetail $detail, $debug = false) {
		$properties = array_keys($detail->_toArray());
		$q = (new QueryBuilder())->table('cartdet');
		$q->mode('insert');

		foreach ($properties as $property) {
			if (strlen($detail->$property)) {
				$q->set($property, $detail->$property);
			}
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			$sql->execute($q->params);
			return $q->generate_sqlquery($q->params);
		}
	}
	
/* =============================================================
	OE HEAD FUNCTIONS
============================================================ */
	/**
	 * Returns if Sales Order exists in the oe_head table
	 * @param  string $ordn   Sales Order Number
	 * @param  bool   $debug  Run in debug? If so, will return SQL Query
	 * @return bool           Does Sales Order exist?
	 */
	function does_salesorderexist($ordn, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');
		$q->field($q->expr("IF(COUNT(*) > 0, 1, 0)"));
		$q->where('ordernumber', $ordn);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return boolval($sql->fetchColumn());
		}
	}
	
	/**
	 * Returns the Sales Order from the oe_head table
	 * @param  string $ordn      Sales Order Number
	 * @param  bool   $debug     Run in debug? If so, will return SQL Query
	 * @return SalesOrder        Sales Order
	 */
	function get_salesorder($ordn, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');
		$q->where('ordernumber', $ordn);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'SalesOrder');
			return $sql->fetch();
		}
	}
	
	function is_orderlocked($ordn, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');
		$q->field('lockedby');
		$q->where('ordernumber', $ordn);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return !empty($sql->fetchColumn()) ? true : false;
		}
	}
	
	function get_orderlocklogin($ordn, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');
		$q->field('lockedby');
		$q->where('ordernumber', $ordn);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
/* =============================================================
	EDIT ORDER FUNCTIONS
============================================================ */
	/**
	 * Returns Sales Order from oe_head
	 * // NOTE THis is the order record to add edits to
	 * @param  string         $sessionID Session Identifier
	 * @param  string         $ordn      Sales Order Number
	 * @param  bool           $debug     Run in debug? If so, return SQL Query
	 * @return SalesOrder                Editable Sales Order
	 */
	function get_orderhead($sessionID, $ordn, $debug = false) {
		$q = (new QueryBuilder())->table('oe_head');
		$q->where('ordernumber', $ordn);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'SalesOrder');
			return $sql->fetch();
		}
	}
	
	/**
	 * Returns if an ordrhed record for Session ID exists
	 * @param  string $sessionID Session ID 
	 * @param  string $ordn      Sales Order Number
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return bool              Is there an ordrhed record for Session ID?
	 */
	function does_salesordereditexist($sessionID, $ordn, $debug = false) {
		$q = (new QueryBuilder())->table('ordrhed');
		$q->field($q->expr('COUNT(*)'));
		$q->where('orderno', $ordn);
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	/**
	 * Returns SalesOrderEdit object for Editable Sales Order
	 * @param  string $sessionID Session ID 
	 * @param  string $ordn      Sales Order Number
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return SalesOrderEdit    Editable Sales Order
	 */
	function get_salesorderforedit($sessionID, $ordn, $debug = false) {
		$q = (new QueryBuilder())->table('ordrhed');
		$q->where('orderno', $ordn);
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'SalesOrderEdit');
			return $sql->fetch();
		}
	}

	function get_orderdetail($sessionID, $ordn, $linenbr, $debug = false) {
		$q = (new QueryBuilder())->table('ordrdet');
		$q->where('sessionid', $sessionID);
		$q->where('orderno', $ordn);
		$q->where('linenbr', $linenbr);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'SalesOrderDetail');
			return $sql->fetch();
		}
	}

	function get_allorderdocs($sessionID, $ordn, $debug = false) {
		$q = (new QueryBuilder())->table('orddocs');
		$q->where('sessionid', $sessionID);
		$q->where('orderno', $ordn);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function get_ordertracking($sessionID, $ordn, $debug = false) {
		$q = (new QueryBuilder())->table('ordrtrk');
		$q->where('sessionid', $sessionID);
		$q->where('orderno', $ordn);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	function update_orderdetail($sessionID, $detail, $debug = false) {
		$originaldetail = SalesOrderDetail::load($sessionID, $detail->orderno, $detail->linenbr);
		$properties = array_keys($detail->_toArray());
		$q = (new QueryBuilder())->table('ordrdet');
		$q->mode('update');
		foreach ($properties as $property) {
			if ($detail->$property != $originaldetail->$property) {
				$q->set($property, $detail->$property);
			}
		}
		$q->where('orderno', $detail->orderno);
		$q->where('sessionid', $detail->sessionid);
		$q->where('linenbr', $detail->linenbr);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			if ($detail->has_changes()) {
				$sql->execute($q->params);
			}
			return $q->generate_sqlquery($q->params);
		}
	}

	function edit_orderhead($sessionID, $ordn, SalesOrderEdit $order, $debug = false) {
		$orginalorder = SalesOrderEdit::load($sessionID, $ordn);
		$properties = array_keys($order->_toArray());
		$q = (new QueryBuilder())->table('ordrhed');
		$q->mode('update');
		foreach ($properties as $property) {
			if ($order->$property != $orginalorder->$property) {
				$q->set($property, $order->$property);
			}
		}
		$q->where('orderno', $order->ordernumber);
		$q->where('sessionid', $order->sessionid);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			if ($order->has_changes()) {
				$sql->execute($q->params);
			}
			return $q->generate_sqlquery($q->params);
		}
	}

	function edit_orderhead_credit($sessionID, $ordn, $paytype, $ccno, $expdate, $ccv, $debug = false) {
		$q = (new QueryBuilder())->table('ordrhed');
		$q->mode('update');
		$q->set('paymenttype', $paytype);
		$q->set('cardnumber', $q->expr('AES_ENCRYPT([], HEX([]))', [$ccno, $sessionID]));
		$q->set('cardexpire', $q->expr('AES_ENCRYPT([], HEX([]))', [$expdate, $sessionID]));
		$q->set('cardcode', $q->expr('AES_ENCRYPT([], HEX([]))', [$ccv, $sessionID]));
		$q->where('orderno', $ordn);
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery();
		} else {
			$sql->execute($q->params);
			return $q->generate_sqlquery($q->params);
		}
	}
	
	/**
	 * Returns Decoded credit card information for Sales Order
	 * @param  string $sessionID Session Identifier
	 * @param  string $ordn      Sales Order Number
	 * @param  bool   $debug     Run in debug? If so, returns SQL Query
	 * @return OrderCreditCard   
	 */
	function get_orderhedcreditcard($sessionID, $ordn, $debug = false) {
		$q = (new QueryBuilder())->table('ordrhed');
		$q->field($q->expr("AES_DECRYPT(cardnumber, HEX(sessionid)) AS cardnumber"));
		$q->field($q->expr("AES_DECRYPT(cardnumber , HEX(sessionid)) AS cardcode"));
		$q->field($q->expr("AES_DECRYPT(cardexpire, HEX(sessionid)) AS expiredate "));
		$q->where('sessionid', $sessionID);
		$q->where('orderno', $ordn);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'OrderCreditCard');
			return $sql->fetch();
		}
	}

	function getshipvias($sessionID) {
		$sql = DplusWire::wire('dplusdatabase')->prepare("SELECT code, via FROM shipvia WHERE sessionid = :sessionID");
		$switching = array(':sessionID' => $sessionID); $withquotes = array(true);
		$sql->execute($switching);
		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

/* =============================================================
	MISC ORDER FUNCTIONS
============================================================ */
	function getstates() {
		$sql = DplusWire::wire('dplusdatabase')->prepare("SELECT abbreviation as state, name FROM states");
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}

	function getcountries() {
		$sql = DplusWire::wire('dplusdatabase')->prepare("SELECT * FROM countries");
		$sql->execute();
		return $sql->fetchAll(PDO::FETCH_ASSOC);
	}



/* =============================================================
	ITEM FUNCTIONS
============================================================ */
	function get_itemfrompricing($itemID, $debug  = false) {
		$q = (new QueryBuilder())->table('pricing');
		$q->where('itemid', $itemID);
		$q->limit(1);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetch(PDO::FETCH_ASSOC);
		}
	}

	/* =============================================================
		ITEM MASTER FUNCTIONS
	============================================================ */
	function search_items($query, $custID, $limit, $page, $debug = false) {
		$search = QueryBuilder::generate_searchkeyword($query);
		$q = (new QueryBuilder())->table('itemsearch');

		if (empty($custID)) {
			$q->where('origintype', ['I', 'V', 'L']);
			$q->where(
		        $q
		        ->orExpr()
		        ->where($q->expr("UCASE(CONCAT(itemid, ' ', originid, ' ', desc1, ' ', desc2))"), 'like', $q->expr("UCASE([])",[$search]))
		        ->where($q->expr("UCASE(CONCAT(itemid, ' ', refitemid, ' ', desc1, ' ', desc2))"), 'like', $q->expr("UCASE([])",[$search]))
		    );
		} else {
			$q->where('origintype', ['I', 'V', 'L', 'C']);
			$q->where($q->expr("UCASE(CONCAT(itemid, ' ', refitemid, ' ', desc1, ' ', desc2))"), 'like', $q->expr("UCASE([])",[$search]));
		}
		$q->where('itemstatus', '!=', 'I');
		$q->order($q->expr("itemid LIKE UCASE([]) DESC", [$search]));
		$q->group('itemid');
		$q->limit($limit, $q->generate_offset($page, $limit));

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'XRefItem');
			return $sql->fetchAll();
		}
	}

	function count_searchitems($query, $custID, $debug = false) {
		$search = QueryBuilder::generate_searchkeyword($query);
		$q = (new QueryBuilder())->table('itemsearch');
		$q->field('COUNT(DISTINCT(itemid))');

		if (empty($custID)) {
			$q->where('origintype', ['I', 'V', 'L']);
			$q->where(
		        $q
		        ->orExpr()
		        ->where($q->expr("UCASE(CONCAT(itemid, ' ', originid, ' ', desc1, ' ', desc2))"), 'like', $q->expr("UCASE([])",[$search]))
		        ->where($q->expr("UCASE(CONCAT(itemid, ' ', refitemid, ' ', desc1, ' ', desc2))"), 'like', $q->expr("UCASE([])",[$search]))
		    );
		} else {
			$q->where('origintype', ['I', 'V', 'L', 'C']);
			$q->where($q->expr("UCASE(CONCAT(itemid, ' ', refitemid, ' ', desc1, ' ', desc2))"), 'like', $q->expr("UCASE([])",[$search]));
		}
		$q->where('itemstatus', '!=', 'I');
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns the Item Description from the cross reference table
	 * @param  string $itemID Item ID / Part Number
	 * @param  bool   $debug  Run in debug? If so, return SQL Query
	 * @return string         Item Description
	 */
	function get_xrefitemdescription($itemID, $debug = false) {
		$q = (new QueryBuilder())->table('itemsearch');
		$q->field('desc1');
		$q->where('itemid', $itemID);
		$q->limit(1);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns the record number for the next item
	 * @param  string $itemID     Item ID / Part Number
	 * @param  string $nextorprev Next or (prev)iou Record
	 * @param  bool   $debug      Run in debug? If so return SQL query
	 * @return int                Record Number
	 */
	function get_nextitemrecno($itemID, $nextorprev, $debug = false) {
		$q = (new QueryBuilder())->table('itemsearch');
		$expression = $nextorprev == 'next' ? "MAX(recno) + 1" : "MIN(recno) - 1";
		$q->field($q->expr($expression));
		$q->where('itemid', $itemID);
		$q->where('itemstatus', '!=', 'I');
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns the itemID for the record with the provided recno
	 * @param  int    $recno      Record Number
	 * @param  bool   $debug      Run in debug? If so return SQL query
	 * @return string             Item Id
	 */
	function get_itemidbyrecno($recno, $debug = false) {
		$q = (new QueryBuilder())->table('itemsearch');
		$q->field('itemid');
		$q->where('recno', $recno);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Return the item from the cross-reference table
	 * @param  string $itemID   Item Number / ID
	 * @param  string $custID   Customer ID
	 * @param  string $vendorID Vendor ID
	 * @param  bool   $debug    Run in debug? If so, return SQL Query
	 * @return XRefItem         Item
	 */
	function get_xrefitem($itemID, $custID = '', $vendorID = '', $debug = false) {
		$q = (new QueryBuilder())->table('itemsearch');
		$itemquery = (new QueryBuilder())->table('itemsearch');
		$itemquery->field('itemid');
		$itemquery->where('itemid', $itemID);
		$itemquery->where('origintype', ['I', 'L']); // ITEMID found by the ITEMID, or by short item lookup // NOTE USED at Stempf

		if (!empty($custID)) {
			$custquery = (new QueryBuilder())->table('itemsearch');
			$custquery->field('itemid');
			$custquery->where('itemid', $itemID);
			$custquery->where('origintype', 'C');
			$custquery->where('originID', $custID);
			$q->where(
				$q
				->orExpr()
				->where('itemid', 'in', $itemquery)
				->where('itemid', 'in', $custquery)
			);
		} elseif (!empty($vendorID)) {
			$vendquery = (new QueryBuilder())->table('itemsearch');
			$vendquery->field('itemid');
			$vendquery->where('itemid', $itemID);
			$vendquery->where('origintype', 'V');
			$vendquery->where('originID', $vendorID);
			$q->where(
				$q
				->orExpr()
				->where('itemid', 'in', $itemquery)
				->where('itemid', 'in', $vendquery)
			);
		} else {
			$q->where('itemid', $itemID);
		}
		$q->limit(1);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'XRefItem');
			return $sql->fetch();
		}
	}

	/* =============================================================
		TABLE FORMATTER FUNCTIONS
	============================================================ */
	/**
	 * Returns Formatter for User
	 * @param  string $userID    String
	 * @param  string $formatter Formatter type
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return string            JSON encoded string of the formatter
	 */
	function get_formatter($userID, $formatter, $debug = false) {
		$q = (new QueryBuilder())->table('tableformatter');
		$q->field('data');
		$q->where('user', $userID);
		$q->where('formattertype', $formatter);
		$q->limit(1);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns if user has a formatter saved for that formatter type
	 * @param  string $userID    User ID
	 * @param  string $formatter Formatter Type
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return array             Response array
	 */
	function does_tableformatterexist($userID, $formatter, $debug = false) {
		$q = (new QueryBuilder())->table('tableformatter');
		$q->field($q->expr('IF(COUNT(*) > 0, 1, 0)'));
		$q->where('user', $userID);
		$q->where('formattertype', $formatter);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Get the max id for that user and that formatter type
	 * // NOTE used to check if newly created formatter is more than the last saved one
	 * @param  string $userID    User ID
	 * @param  string $formatter Formatter Type
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return int               Max table formatter ID
	 */
	function get_maxtableformatterid($userID, $formatter, $debug = false) {
		$q = (new QueryBuilder())->table('tableformatter');
		$q->field($q->expr('MAX(id)'));
		$q->where('user', $userID);
		$q->where('formattertype', $formatter);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Updates the formatter for that user
	 * @param  string $userID    User ID
	 * @param  string $formatter Formatter Type
	 * @param  string $data      JSON encoded string
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return array             Response array
	 */
	function update_formatter($userID, $formatter, $data, $debug = false) {
		$q = (new QueryBuilder())->table('tableformatter');
		$q->mode('update');
		$q->set('data', $data);
		$q->where('user', $userID);
		$q->where('formattertype', $formatter);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return array('sql' => $q->generate_sqlquery($q->params), 'success' => $sql->rowCount() ? true : false, 'updated' => $sql->rowCount() ? true : false, 'querytype' => 'update');
		}
	}

	/**
	 * Creates the formatter for that user
	 * @param  string $userID    User ID
	 * @param  string $formatter Formatter Type
	 * @param  string $data      JSON encoded string
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return array             Response array
	 */
	function create_formatter($userID, $formatter, $data, $debug = false) {
		$q = (new QueryBuilder())->table('tableformatter');
		$q->mode('insert');
		$q->set('data', $data);
		$q->set('user', $userID);
		$q->set('formattertype', $formatter);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return array('sql' => $q->generate_sqlquery($q->params), 'success' => DplusWire::wire('dplusdatabase')->lastInsertId() > 0 ? true : false, 'id' => DplusWire::wire('dplusdatabase')->lastInsertId(), 'querytype' => 'create');
		}
	}

	/* =============================================================
		USER CONFIGS FUNCTIONS
	============================================================ */
	/**
	 * Returns if System Config Exist for this user
	 * @param  string $userID        User ID
	 * @param  string $configtype    Config Code
	 * @param  bool $debug           Run in debug? If so, return SQL Query
	 * @return int                   Does User Config Exist
	 */
	function does_systemconfigexist($userID, $configtype, $debug = false) {
		$q = (new QueryBuilder())->table('userconfigs');
		$q->field($q->expr("IF(COUNT(*) > 0, 1, 0)"));
		$q->where('user', $userID);
		$q->where('configtype', $configtype);
		
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	/**
	 * Returns JSON system configuration for a subsytem for a user / user type
	 * @param  string $userID        User ID
	 * @param  string $configuration Which Config to load
	 * @param  bool   $debug         Run in debug? If so, return SQL Query
	 * @return string                JSON encoded config
	 */
	function get_systemconfiguration($userID, $configuration, $debug = false) {
		$q = (new QueryBuilder())->table('userconfigs');
		$q->field($q->expr("data"));
		$q->where('user', $userID);
		$q->where('configtype', $config);
		$q->limit(1);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

  /* =============================================================
		CUSTOMER JSON CONFIGS
	============================================================ */
	function does_customerconfigexist($config, $debug = false) {
		$q = (new QueryBuilder())->table('customerconfigs');
		$q->field($q->expr('COUNT(*)'));
		$q->where('configtype', $config);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	function get_customerconfig($config, $debug = false) {
		$q = (new QueryBuilder())->table('customerconfigs');
		$q->field('data');
		$q->where('configtype', $config);
		$q->limit(1);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	function update_customerconfig($config, $data, $debug = false) {
		$q = (new QueryBuilder())->table('customerconfigs');
		$q->mode('update');
		$q->set('data', $data);
		$q->where('configtype', $config);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return array('sql' => $q->generate_sqlquery($q->params), 'success' => $sql->rowCount() ? true : false, 'updated' => $sql->rowCount() ? true : false, 'querytype' => 'update');
		}
	}

	function create_customerconfig($config, $data, $debug = false) {
		$q = (new QueryBuilder())->table('customerconfigs');
		$q->mode('insert');
		$q->set('data', $data);
		$q->set('configtype', $config);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return array('sql' => $q->generate_sqlquery($q->params), 'success' => DplusWire::wire('dplusdatabase')->lastInsertId() > 0 ? true : false, 'id' => DplusWire::wire('dplusdatabase')->lastInsertId(), 'querytype' => 'create');
		}
	}

	/* =============================================================
		LOGM FUNCTIONS
	============================================================ */
	function get_logmuser($loginID, $debug = false) {
		$q = (new QueryBuilder())->table('logm');
		$q->where('loginid', $loginID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'LogmUser');
			return $sql->fetch();
		}
	}

	function get_logmuserlist($debug = false) {
		$q = (new QueryBuilder())->table('logm');
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'LogmUser');
			return $sql->fetchAll();
		}
	}

	/* =============================================================
		OOKING FUNCTIONS
	============================================================ */
	/**
	 * Return the Number of bookings made that day, for a salesrep, if need be
	 * @param  string $custID    Customer ID
	 * @param  string $shiptoID  Customer Shipto ID
	 * @param  string $loginID   User Login ID, if blank, will use the current User
	 * @param  bool   $debug     Run in debug?
	 * @return int               Number of bookings made for that day
	 * @uses User Roles
	 */
	function count_todaysbookings($custID = false, $shiptoID = false, $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$q = (new QueryBuilder())->table('bookingd');
		$q->field('COUNT(*)');
		$q->where('bookdate', date('Ymd'));

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep']) {
			$q->where('salesperson1', DplusWire::wire('user')->salespersonid);
		}

		if (!empty($custID)) {
			$q->where('custid', $custID);
			if (!empty($shiptoID)) {
				$q->where('shiptoid', $shiptoID);
			}
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Get today's booking amount for a User
	 * @param  string $custID   Customer ID
	 * @param  string $shiptoID Customer Shipto ID
	 * @param  string $loginID  User Login ID, IF blank, will use current User
	 * @param  bool   $debug    Run in debug? If so, will return SQL
	 * @return float            Booking Amount for today
	 */
	function get_todaysbookingsamount($custID = '', $shiptoID = '', $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);

		$q = (new QueryBuilder())->table('bookingd');
		$q->field('SUM(netamount)');
		$q->where('bookdate', date('Ymd'));

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep']) {
			$q->where('salesperson1', DplusWire::wire('user')->salespersonid);
		}

		if (!empty($custID)) {
			$q->where('custid', $custID);
			if (!empty($shiptoID)) {
				$q->where('shiptoid', $shiptoID);
			}
		}

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns Bookings for that user based on permissions/roles
	 * @param  array  $filter       array of filter
	 * @param  array  $filtertypes  array of filters by their keys and the way to filter them
	 * @param  string $interval     Interval of time ex. month|day
	 * @param  string $loginID      User Login ID, if blank, will use current user
	 * @param  bool   $debug        Run in debug? If so, return SQL Query
	 * @return array                Of booking total records {custid, amount}
	 */
	function get_userbookings($filter, $filtertypes, $interval = '', $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$q = (new QueryBuilder())->table('bookingr');

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep']) {
			$q->where('salesrep', DplusWire::wire('user')->salespersonid);
		}

		$q->generate_filters($filter, $filtertypes);

		switch ($interval) {
			case 'month':
				$q->field($q->expr("CAST(CONCAT(YEAR(bookdate), LPAD(MONTH(bookdate), 2, '0'), '01') AS UNSIGNED) as bookdate"));
				$q->field('SUM(amount) as amount');
				$q->group('YEAR(bookdate), MONTH(bookdate)');
				break;
			case 'day':
				$q->field('bookingr.*');
				$q->field('SUM(amount) as amount');
				$q->group('bookdate');
				break;
		}

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	/**
	 * Returns Booking Totals by customer for that user based on permissions/roles
	 * @param  array  $filter       array of filter
	 * @param  array  $filtertypes  array of filters by their keys and the way to filter them
	 * @param  string $interval     Interval of time ex. month|day
	 * @param  string $loginID      User Login ID, if blank, will use current user
	 * @param  bool   $debug        Run in debug? If so, return SQL Query
	 * @return array                Of booking total records {custid, amount}
	 */
	function get_bookingtotalsbycustomer($filter, $filtertypes, $interval = '', $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$q = (new QueryBuilder())->table('bookingc');

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep']) {
			$q->where('salesrep', DplusWire::wire('user')->salespersonid);
		}

		$q->generate_filters($filter, $filtertypes);

		switch ($interval) {
			case 'month':
				$q->field('bookingc.custid');
				$q->field('SUM(amount) as amount');
				$q->group('custid');
				break;
			case 'day':
				$q->field('bookingc.*');
				$q->field('SUM(amount) as amount');
				$q->group('bookdate');
				break;
		}
		$q->field('name');
		$q->join('custindex.custid', 'bookingc.custid', 'left outer');
		$q->where('custindex.shiptoid', '');
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	/**
	 * Returns Number of booked Sales Order Numbers for a day
	 * @param  string $date     Datetime string usually in m/d/Y format
	 * @param  string $custID   Customer ID
	 * @param  string $shiptoID Customer Shipto ID
	 * @param  string $loginID  User Login ID, if blank, will use current User
	 * @param  bool   $debug    Run debug? If so, will return SQL Query
	 * @return int              Number of booking Orders
	 */
	function count_daybookingordernumbers($date, $custID = '', $shiptoID = '', $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$q = (new QueryBuilder())->table('bookingd');
		$q->field($q->expr('COUNT(DISTINCT(salesordernbr))'));

		$q->where('bookdate', date('Ymd', strtotime($date)));

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep']) {
			$q->where('salesperson1', DplusWire::wire('user')->salespersonid);
		}

		if (!empty($custID)) {
			$q->where('custid', $custID);
			if (!empty($shiptoID)) {
				$q->where('shiptoid', $shiptoID);
			}
		}

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns an array of the Sales Orders for that day
	 * @param  string $date     Datetime string, usually in m/d/Y
	 * @param  bool   $custID   Customer ID
	 * @param  bool   $shiptoID Customer Shipto ID
	 * @param  string $loginID  User Login ID, if blank, will use current User
	 * @param  bool   $debug    Run debug? If so, will return SQL Query
	 * @return array            Sales Orders for that day
	 */
	function get_daybookingordernumbers($date, $custID = false, $shiptoID = false, $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$q = (new QueryBuilder())->table('bookingd');
		$q->field($q->expr('DISTINCT(salesordernbr)'));
		$q->field('bookdate');
		$q->field('custid');
		$q->field('shiptoid');
		$q->where('bookdate', date('Ymd', strtotime($date)));

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep']) {
			$q->where('salesperson1', DplusWire::wire('user')->salespersonid);
		}

		if (!empty($custID)) {
			$q->where('custid', $custID);
			if (!empty($shiptoID)) {
				$q->where('shiptoid', $shiptoID);
			}
		}

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	/**
	 * Return the detail lines for a booking on a specific date
	 * @param  string $ordn     Sales Order Number
	 * @param  string $date     Datetime string, usually in m/d/Y
	 * @param  bool   $custID   Customer ID
	 * @param  bool   $shiptoID Customer Shipto ID
	 * @param  string $loginID  User Login ID, if blank, will use current User
	 * @param  bool   $debug    Run debug? If so, will return SQL Query
	 * @return array            Sales Order Detail Lines ex. {bookdate, custid, shiptoid, salesorderbase, origorderline, itemid, salesordernbr, salesperson1,
	 * 			                                             b4qty, b4price, b4uom, afterqty
	 *                                                       afterprice, afteruom, netamount, createdate, createtime }
	 */
	function get_bookingdayorderdetails($ordn, $date, $custID = false, $shiptoID = false, $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$q = (new QueryBuilder())->table('bookingd');
		$q->where('bookdate', date('Ymd', strtotime($date)));
		$q->where('salesordernbr', $ordn);

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep']) {
			$q->where('salesperson1', DplusWire::wire('user')->salespersonid);
		}

		if (!empty($custID)) {
			$q->where('custid', $custID);
			if (!empty($shiptoID)) {
				$q->where('shiptoid', $shiptoID);
			}
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	/**
	 * Returns an array of customer booking records for a salesrep
	 * if User is a sales rep
	 * @param  string $custID     Customer ID
	 * @param  string $shipID     Customer Shipto ID
	 * @param  array  $filter      Array that contains the column and the values to filter for
	 * ex. array(
	 * 	'ordertotal' => array (123.64, 465.78)
	 * )
	 * @param  array   $filterable  Array that contains the filterable columns as keys, and the rules needed
	 * ex. array(
	 * 	'ordertotal' => array(
	 * 		'querytype' => 'between',
	 * 		'datatype' => 'numeric',
	 * 		'label' => 'Order Total'
	 * 	),
	 * 	'orderdate' => array(
	 * 		'querytype' => 'between',
	 * 		'datatype' => 'date',
	 * 		'date-format' => 'Ymd',
	 * 		'label' => 'order-date'
	 * 	)
	 * )
	 * @param  string $interval   Interval of time ex. day | month
	 * @param  string $loginID    User Login ID, if blank, will use the current User
	 * @param  bool   $debug      Run in debug? If so, return SQL Query
	 * @return array              Booking records (array)
	 */
	function get_customerbookings($custID, $shipID, $filter = false, $filterable = false, $interval = '', $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$q = (new QueryBuilder())->table('bookingc');
		$q->where('custid', $custID);

		if (!empty($shipID)) {
			$q->where('shiptoid', $shipID);
		}

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep']) {
			$q->where('salesrep', DplusWire::wire('user')->salespersonid);
		}
		$q->generate_filters($filter, $filterable);

		switch ($interval) {
			case 'month':
				$q->field($q->expr("CAST(CONCAT(YEAR(bookdate), LPAD(MONTH(bookdate), 2, '0'), '01') AS UNSIGNED) as bookdate"));
				$q->field('SUM(amount) as amount');
				$q->group('YEAR(bookdate), MONTH(bookdate)');
				break;
			case 'day':
				$q->field('bookingc.*');
				$q->field('SUM(amount) as amount');
				$q->group('bookdate');
				break;
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	/**
	 * Returns an array of Booking Sales Orders for that day that the User has access to
	 * @param  string $date     Datetime usually in m/d/Y
	 * @param  string $custID   Customer ID
	 * @param  string $shipID   Customer Shipto ID
	 * @param  string $loginID  User Login ID, if blank, will use the current User
	 * @param  bool   $debug    Run in debug? If so, return SQL Query
	 * @return array            Booking Sales Orders for that day
	 */
	function get_customerdaybookingordernumbers($date, $custID, $shipID = '', $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$q = (new QueryBuilder())->table('bookingd');
		$q->field($q->expr('DISTINCT(salesordernbr)'));
		$q->field('bookdate');
		$q->where('bookdate', date('Ymd', strtotime($date)));

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep']) {
			$q->where('salesperson1', DplusWire::wire('user')->salespersonid);
		}

		$q->where('custid', $custID);
		if (!empty($shipID)) {
			$q->where('shiptoid', $shipID);
		}

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	/**
	 * Return Number of Customer Booking Sales Order Numbers that the User has access to
	 * @param  string $date    Datetime usually in m/d/Y
	 * @param  string $custID  Customer ID
	 * @param  string $shipID  Customer Shipto ID
	 * @param  string $loginID User Login ID, if blank, will use the current User
	 * @param  bool   $debug   Run in debug? If so, return SQL Query
	 * @return int             Number of Customer Booking Sales ORder Numbers
	 */
	function count_customerdaybookingordernumbers($date, $custID, $shipID = '', $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$q = (new QueryBuilder())->table('bookingd');
		$q->field($q->expr('COUNT(DISTINCT(salesordernbr))'));

		$q->where('bookdate', date('Ymd', strtotime($date)));

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep']) {
			$q->where('salesperson1', DplusWire::wire('user')->salespersonid);
		}

		$q->where('custid', $custID);
		if (!empty($shipID)) {
			$q->where('shiptoid', $shipID);
		}

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Return the Number of Customer bookings
	 * that the User has access to
	 * @param  string $custID  Customer ID
	 * @param  string $shipID  Customer Shipto ID
	 * @param  string $loginID User Login ID, if blank, will use the current User
	 * @param  bool   $debug   Run in debug? If so, return SQL Query
	 * @return int             Number of Customer bookings
	 * @uses User dplusrole
	 */
	function count_customertodaysbookings($custID, $shipID, $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$q = (new QueryBuilder())->table('bookingc');
		$q->field('COUNT(*)');
		$q->where('bookdate', date('Ymd'));

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep']) {
			$q->where('salesrep', DplusWire::wire('user')->salespersonid);
		}

		$q->where('custid', $custID);
		if (!empty($shipID)) {
			$q->where('shiptoid', $shipID);
		}

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Return the Customers booking total for today that the User has access to
	 * @param  string $custID  Customer ID
	 * @param  string $shipID  Customer Shipto ID
	 * @param  string $loginID User Login ID, if blank, will use the current User
	 * @param  bool   $debug   Run in debug?
	 * @return float           booking total
	 * @uses User dplusrole
	 */
	function get_customertodaybookingamount($custID, $shipID = '', $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$q = (new QueryBuilder())->table('bookingc');
		$q->field('SUM(amount)');

		$q->where('bookdate', date('Ymd'));

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep']) {
			$q->where('salesrep', DplusWire::wire('user')->salespersonid);
		}

		$q->where('custid', $custID);

		if (!empty($shipID)) {
			$q->where('shiptoid', $shipID);
		}

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns Booking Records for each Customer Shipto
	 * that the User has access to
	 * @param  string $custID      Customer ID
	 * @param  string $shipID      Customer Shipto ID
	 * @param  array  $filter      Array that contains the column and the values to filter for
	*  ex. array(
	* 	 'ordertotal' => array (123.64, 465.78)
	*  )
	* @param  array   $filterable  Array that contains the filterable columns as keys, and the rules needed
	* ex. array(
	* 	'ordertotal' => array(
	* 		'querytype' => 'between',
	* 		'datatype' => 'numeric',
	* 		'label' => 'Order Total'
	* 	),
	* 	'orderdate' => array(
	* 		'querytype' => 'between',
	* 		'datatype' => 'date',
	* 		'date-format' => 'Ymd',
	* 		'label' => 'order-date'
	* 	)
	* )
	 * @param  string $interval    Interval of time ex. month|day
	 * @param  string $loginID     User Login ID, if blank, will use the current User
	 * @param  bool   $debug       Run in debug?
	 * @return array               Customer Shipto Booking Records
	 */
	function get_bookingtotalsbyshipto($custID, $shipID, $filter, $filterable, $interval = '', $loginID = '', $debug = false) {
		$loginID = (!empty($loginID)) ? $loginID : DplusWire::wire('user')->loginid;
		$user = LogmUser::load($loginID);
		$q = (new QueryBuilder())->table('bookingc');

		if ($user->get_dplusrole() == DplusWire::wire('config')->roles['sales-rep']) {
			$q->where('salesrep', DplusWire::wire('user')->salespersonid);
		}

		$q->where('custid', $custID);
		if (!empty($shipID)) {
			$q->where('shiptoid', $shipID);
		}

		$q->generate_filters($filter, $filterable);

		switch ($interval) {
			case 'month':
				$q->field('custid');
				$q->field('shiptoid');
				$q->field('SUM(amount) as amount');
				$q->group('custid,shiptoid');
				break;
			case 'day':
				$q->field('bookingc.*');
				$q->field('SUM(amount) as amount');
				$q->group('bookdate');
				break;
		}

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	/* =============================================================
		SIGNIN LOG FUNCTIONS
	============================================================ */

	/**
	 * Return the user signins for today that the User has access to
	 * @param  string $day    Date    
	 * @param  bool   $debug  Run in debug? If so, return SQL Query
	 * @uses User dplusrole
	 */
	function get_daysignins($day, $debug = false) {
		$day = empty(date('Y-m-d', strtotime($day))) ? date('Y-m-d') : date('Y-m-d', strtotime($day));
		$q = (new QueryBuilder())->table('log_signin');
		$q->where($q->expr("DATE(date) = STR_TO_DATE([], '%Y-%m-%d')", [$day]));
		$q->order('date DESC');

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'SigninLog');
			return $sql->fetchAll();
		}
	}

	/**
	 * Return the number of user signins for today that the User has access to
	 * @param  string $day   Date
	 * @param  bool  $debug  Run in debug? If so, return SQL Query
	 * @uses User dplusrole
	 */
	function count_daysignins($day, $debug = false) {
		$day = empty(date('Y-m-d', strtotime($day))) ? date('Y-m-d') : date('Y-m-d', strtotime($day));
		$q = (new QueryBuilder())->table('log_signin');
		$q->field('COUNT(*)');
		$q->where($q->expr("DATE(date) = STR_TO_DATE([], '%Y-%m-%d')", [$day]));
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}

	/**
	 * Returns the log_signin records that match the filter
	 * @param  array $filter      Array of filters and values for each filter (column)
	 * @param  array $filtertypes Array of the possible filters and their properties
	 * @param  bool  $debug       Run in debug? If so, return SQL Query
	 * @return array              log_signin records
	 */
	function get_logsignins($filter, $filtertypes, $debug = false) {
		$q = (new QueryBuilder())->table('log_signin');
		$q->order('date DESC');

		if (!empty($filter)) {
			$q->generate_filters($filter, $filtertypes);
		}
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchAll();
		}
	}

	/**
	 * Inserts log of user signins for today that the User has access to
	 * @param  string $sessionID  Session Identifier
	 * @param  string $userID     User Login ID
	 * @param  bool   $debug       Run in debug? If so, return SQL Query
	 * @uses User dplusrole
	 */
	function insert_logsignin($sessionID, $userID, $debug = false) {
		$date = date('Y-m-d H:i:s');
		$q = (new QueryBuilder())->table('log_signin');
		$q->mode('insert');
		$q->set('sessionid', $sessionID);
		$q->set('user', $userID);
		$q->set('date', $date);

		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $q->generate_sqlquery($q->params);
		}
	}

	/**
	 * Checks to see if sessionid already exists in log-signin table
	 * @param  string $sessionID   Session Identifier
	 * @param  bool   $debug       Run in debug? If so, return SQL Query
	 * @uses  User dplusrole
	 */
	function has_loggedsignin($sessionID, $debug = false) {
		$q = (new QueryBuilder())->table('log_signin');
		$q->field('COUNT(*)');
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());

		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	/* =============================================================
		SALES ORDER PICKING FUNCTIONS
	============================================================ */
	/**
	 * Returns if there is a a whsesession record for that Session
	 * @param  string $sessionID Session Identifier
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return bool              Does whsesession record exist for that Session ID
	 */
	function does_whsesessionexist($sessionID, $debug = false) {
		$q = (new QueryBuilder())->table('whsesession');
		$q->field($q->expr('IF(COUNT(*) > 0, 1, 0)'));
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	/**
	 * Returns an instance WhseSession from loading a WhseSession record for that Session
	 * @param  string      $sessionID Session Identifier
	 * @param  bool        $debug     Run in debug? If so, return SQL Query
	 * @return WhseSession            WhseSession for that Session ID
	 */
	function get_whsesession($sessionID, $debug = false) {
		$q = (new QueryBuilder())->table('whsesession');
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'WhseSession');
			return $sql->fetch();
		}
	}
	
	/**
	 * Returns the Pick Sales Order Header
	 * @param  string           $ordn      Sales Order Number
	 * @param  bool             $debug     Run in debug? If so, return SQL Query
	 * @return Pick_SalesOrder             Pick Sales Order Header
	 */
	function get_picksalesorderheader($ordn, $debug = false) {
		$q = (new QueryBuilder())->table('wmpickhed');
		$q->where('ordernbr', $ordn);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'Pick_SalesOrder');
			return $sql->fetch();
		}
	}
	
	/**
	 * Returns an Instance of Pick_SalesOrderDetail
	 * @param  string                $sessionID Session Identifier
	 * @param  bool                  $debug     Run in debug? If so, return SQL Query
	 * @return Pick_SalesOrderDetail
	 */
	function get_whsesessiondetail($sessionID, $debug = false) {
		$q = (new QueryBuilder())->table('wmpickdet');
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'Pick_SalesOrderDetail');
			return $sql->fetch();
		}
	}
	
	/**
	 * Returns if there are details to pick
	 * @param  string                $sessionID Session Identifier
	 * @param  bool                  $debug     Run in debug? If so, return SQL Query
	 * @return bool
	 */
	function has_whsesessiondetail($sessionID, $debug = false) {
		$q = (new QueryBuilder())->table('wmpickdet');
		$q->field($q->expr('IF(COUNT(*) > 0, 1, 0)'));
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	/**
	 * Returns BarcodedItem 
	 * @param  string       $barcode Barcode 
	 * @param  bool         $debug   Run in debug? If so, return SQL Query
	 * @return BarcodedItem
	 */
	function get_barcodeditem($barcode, $debug = false) {
		$q = (new QueryBuilder())->table('barcodes');
		$q->where('barcodenbr', $barcode);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'BarcodedItem');
			return $sql->fetch();
		}
	}
	
	/**
	 * Returns the item id for the supplied barcode
	 * @param  string $barcode Barcode for an Item
	 * @param  bool   $debug   Run in debug? If so, return SQL Query
	 * @return string          Item ID
	 */
	function get_barcodeditemid($barcode, $debug = false) {
		$q = (new QueryBuilder())->table('barcodes');
		$q->field('itemid');
		$q->where('barcodenbr', $barcode);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	/**
	 * Returns all the barcoded Items for that Item ID
	 * @param  string $itemID Item ID
	 * @param  bool   $debug  Run in debug? If so, return SQL Query
	 * @return array          BarcodedItems
	 */
	function get_barcodeditemsforitemid($itemID, $debug = false) {
		$q = (new QueryBuilder())->table('barcodes');
		$q->where('itemid', $itemID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			$sql->setFetchMode(PDO::FETCH_CLASS, 'BarcodedItem');
			return $sql->fetchAll();
		}
	}
	
	/**
	 * Returns an array of all the Item barcodes that have been picked
	 * // NOTE Each add of an barcode is its own record, so the same
	 * barcode can have multiple records
	 * @param  string $sessionID Session Identifier
	 * @param  string $ordn      Sales Order Number
	 * @param  string $itemID    Item ID
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return array             Barcodes picked for that Sales Order and Item ID
	 */
	function get_orderpickeditems($sessionID, $ordn, $itemID, $debug = false) {
		$q = (new QueryBuilder())->table('whseitempick');
		$q->where('sessionid', $sessionID);
		$q->where('ordn', $ordn);
		$q->where('itemid', $itemID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchAll();
		}
	}
	
	/**
	 * Removes items picked for this session
	 * @param  string $sessionID Session Identifier
	 * @param  bool   $debug     Run in debug? If so, @return string SQL Query
	 * @return int               Number of rows deleted
	 */
	function delete_orderpickeditems($sessionID, $debug = false) {
		$q = (new QueryBuilder())->table('whseitempick');
		$q->mode('delete');
		$q->where('sessionid', $sessionID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->rowCount();
		}
	}
	
	/**
	 * Returns the total Qty of all the barcodes picked for this Order and Item ID
	 * @param  string $sessionID Session Identifier
	 * @param  string $ordn      Sales Order Number
	 * @param  string $itemID    Item ID
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return int               Total Qty of all the barcodes picked for this Order and Item ID
	 */
	function get_orderpickeditemqtytotal($sessionID, $ordn, $itemID, $debug = false) {
		$q = (new QueryBuilder())->table('whseitempick');
		$q->field($q->expr('SUM(qty)'));
		$q->where('sessionid', $sessionID);
		$q->where('ordn', $ordn);
		$q->where('itemid', $itemID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	/**
	 * Returns an array of total picked Qtys for each pallet of all the barcodes picked for this Order and Item ID
	 * @param  string $sessionID Session Identifier
	 * @param  string $ordn      Sales Order Number
	 * @param  string $itemID    Item ID
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return array             Total Qty of all the barcodes picked for this Order and Item ID
	 */
	function get_orderpickeditemqtytotalsbypallet($sessionID, $ordn, $itemID, $debug = false) {
		$q = (new QueryBuilder())->table('whseitempick');
		$q->field('palletnbr');
		$q->field($q->expr('SUM(qty) AS qty'));
		$q->where('sessionid', $sessionID);
		$q->where('ordn', $ordn);
		$q->where('itemid', $itemID);
		$q->group('palletnbr');
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	
	/**
	 * Inserts a new record into the database for the new barcode added for this item / Sales Order
	 * // NOTE Logic should be added before using this function
	 * @param  string $sessionID Session Identifier
	 * @param  string $ordn      Sales Order Number
	 * @param  string $barcode   Barcode string
	 * @param  int    $palletnbr Pallet Number
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return int               Number of Records Inserted 1 | 0
	 */
	function insert_orderpickedbarcode($sessionID, $ordn, $barcode, $palletnbr = 1, $debug = false) {
		$barcodeditem = BarcodedItem::load($barcode);
		$pickitem = Pick_SalesOrderDetail::load($sessionID);
		$recordnumber = $pickitem->get_pickedmaxrecordnumber() + 1;
		
		$q = (new QueryBuilder())->table('whseitempick');
		$q->mode('insert');
		$q->set('sessionid', $sessionID);
		$q->set('ordn', $ordn);
		$q->set('itemid', $barcodeditem->itemid);
		$q->set('recordnumber', $recordnumber);
		$q->set('palletnbr', "$palletnbr");
		$q->set('barcode', $barcode);
		$q->set('qty', $barcodeditem->unitqty);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return DplusWire::wire('dplusdatabase')->lastInsertId();
		}
	}
	
	/**
	 * Removes barcode record from picked queue
	 * @param  string $sessionID Session Identifier
	 * @param  string $ordn      Sales Order Number
	 * @param  string $barcode   Barcode string
	 * @param  int    $palletnbr Pallet Number
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return int               Number of Records affected 1 | 0
	 */
	function remove_orderpickedbarcode($sessionID, $ordn, $barcode, $palletnbr = 1, $debug = false) {
		$barcodeditem = BarcodedItem::load($barcode);
		$pickitem = Pick_SalesOrderDetail::load($sessionID);
		
		$q = (new QueryBuilder())->table('whseitempick');
		$q->mode('delete');
		$q->where('sessionid', $sessionID);
		$q->where('ordn', $ordn);
		$q->where('barcode', $barcode);
		$q->where('palletnbr', $palletnbr);
		$q->where('recordnumber', $pickitem->get_pickedmaxrecordnumberforbarcode($barcode, $palletnbr));
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->rowCount();
		}
	}
	
	/**
	 * Return the MAX record number for the Sales Order Item Picked
	 * @param  string $sessionID Session Identifier
	 * @param  string $ordn      Sales Order Number
	 * @param  string $itemID    Item ID
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return int               whseitempick MAX record number for that SessionID, Sales Order, Item ID
	 */
	function get_orderpickeditemmaxrecordnumber($sessionID, $ordn, $itemID, $debug = false) {
		$q = (new QueryBuilder())->table('whseitempick');
		$q->field($q->expr('MAX(recordnumber)'));
		$q->where('sessionid', $sessionID);
		$q->where('ordn', $ordn);
		$q->where('itemid', $itemID);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
	
	
	/**
	 * Return the MAX record number for the Sales Order Item Barcode
	 * @param  string $sessionID Session Identifier
	 * @param  string $ordn      Sales Order Number
	 * @param  string $itemID    Item ID
	 * @param  string $barcode   Barcode
	 * @param  int    $palletnbr Pallet Nbr
	 * @param  bool   $debug     Run in debug? If so, return SQL Query
	 * @return int               whseitempick MAX record number for that SessionID, Sales Order, Item ID, barcode
	 */
	function get_orderpickedbarcodemaxrecordnumber($sessionID, $ordn, $itemID, $barcode, $palletnbr, $debug = false) {
		$q = (new QueryBuilder())->table('whseitempick');
		$q->field($q->expr('MAX(recordnumber)'));
		$q->where('sessionid', $sessionID);
		$q->where('ordn', $ordn);
		$q->where('itemid', $itemID);
		$q->where('barcode', $barcode);
		$q->where('palletnbr', $palletnbr);
		$sql = DplusWire::wire('dplusdatabase')->prepare($q->render());
		
		if ($debug) {
			return $q->generate_sqlquery($q->params);
		} else {
			$sql->execute($q->params);
			return $sql->fetchColumn();
		}
	}
