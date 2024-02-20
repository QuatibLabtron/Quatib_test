<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code





/***********************************************************
			CUSTOM CONSTANT STARTS
************************************************************/
	
	/***********************************************************
				START DEFAULT CONTENT
	************************************************************/

	define('PROJECT_NAME','Medfuge Ltd.');
	define('WEBSITE_LINK','https://www.medfuge.com/');
	define('WEBSITE_TNC','<p>• Medfuge Ltd.<br>• Bank Name: Royal Bank of Canada<br>• USD Account Number: 4006193<br>• Swift Code: ROYCCAT2<br>• Branch address: Northland Plaza BR 4820 Northland DR NW Suite 220 Calgary AB T2L 2L3<br>• Products shipment will be 4 weeks from the date of receipt of payment<br>• Quotation Validity: 60 days<br>• Warranty: One year from the date of shipment, against any manufacturing defects<br>• 100 % advance payment by wire transfer</p>');

	/***********************************************************
				END DEFAULT CONTENT
	************************************************************/
	/***********************************************************
				START GENERAL PARAMETERS
	************************************************************/

	define('STATUS_INACTIVE',0);
	define('STATUS_ACTIVE',1);
	define('STATUS_BLOCKED',2);
	define('STATUS_NAME', 'normal_status');
    //define('STATUS_NAME', 'general_status');
	define('GENERAL_STATUS', 'general_status');
	define('YES_NO_OPTION','yes_no_option');
	define('YES', '1');
	define('NO', '2');

	define('ADMIN_DEPARTMENT', 1);
	define('DEVELOPER_DEPARTMENT', 2);
	define('PRODUCT_SPECIALIST_DEPARTMENT', 3);
	define('SENIOR_PRODUCT_SPECIALIST_DEPARTMENT', 4);

	define('TENDER_PRICE_TYPE', 'tender_price_type');
	define('TENDER_PRICE_TYPE_INR',1);
	define('TENDER_PRICE_TYPE_DOLLAR',2);
	define('TENDER_PRICE_TYPE_POUNDS',3);

	define('TENDER_INDUSTRY', 'tender_industry');
	define('TENDER_CONTACT_TYPE', 'tender_contact_type');
	define('TENDER_SALUTION', 'tender_salutation');
	define('TENDER_LEAD_SOURCE', 'tender_lead_source');
	define('TENDER_STATUS', 'tender_status');

	define('NORMAL_TENDER_CONTACT_TYPE',1);
	define('DEALER_TENDER_CONTACT_TYPE',2);

	define('ADD_ADJUSTMENT_TYPE',1);
	define('SUB_ADJUSTMENT_TYPE',2);

	define('ORGANISATION_INDIVIDUAL_ID', 1);

	define('TENDER_PREFIX_WORDS', 'custom_prefix_words');
	define('TENDER_PREFIX_NUMBER', 'custom_prefix_number');
	define('TENDER_START_SEQUENCE', 'custom_start_sequence');

	define('TENDER_INVOICE_START_SEQUENCE', 'custom_invoice_start_sequence');
	define('TENDER_INVOICE_PREFIX_NUMBER', 'custom_invoice_prefix_number');


	define('PRODUCT_DISCOUNT_ONLY_QTY', 1);
	define('PRODUCT_DISCOUNT_ONLY_DIRECT', 2);
	define('PRODUCT_DISCOUNT_ONLY_INDV', 3);
	define('PRODUCT_DISCOUNT_DIRECT_N_QTY', 4);
	define('PRODUCT_DISCOUNT_INDV_N_QTY', 5);
	define('PRODUCT_DISCOUNT_ZERO', 6);

	define('INVOICE_DISCOUNT_TYPE_PERCENT', 1);
	define('INVOICE_DISCOUNT_TYPE_DIRECT', 2);
	define('INVOICE_DISCOUNT_TYPE_ZERO', 3);

	define('TENDER_INVOICE_PDF', 1);
	define('TENDER_INVOICE_PDF_MAIL', 2);

	define('TENDER_ACTIVITY_TYPE','tender_activity_type');
	define('TENDER_ACTIVITY_ORG', 1);
	define('TENDER_ACTIVITY_CONTACT', 2);
	define('TENDER_ACTIVITY_TENDER', 3);

	define('TENDER_ACTIVITY_CREATE','Created');
	define('TENDER_ACTIVITY_UPDATE','Updated');


	/***********************************************************
				END GENERAL PARAMETERS
	************************************************************/

	/***********************************************************
				START BUSINESS PARAMETERS
	************************************************************/

	define('BSN_ADMIN_EMAIL','admin_email');
	define('BSN_ADMIN_EMAIL_FROM_NAME','admin_email_from_name');

	define('BSN_MAIL_SMTP_HOST','mail_smtp_host');
	define('BSN_MAIL_SMTP_USER','mail_smtp_user');
	define('BSN_MAIL_SMTP_PASS','mail_smtp_pass');
	define('BSN_MAIL_SMTP_PORT','mail_smtp_port');

	define('BSN_WEBSITE_NAME','website_name');
	define('BSN_WEBSITE_LINK','website_link');
	define('BSN_WEBSITE_EMAIL_ADDRESS','website_email_address');
	define('BSN_WEBSITE_PHONE_NUMBER','website_phone_number');
	define('BSN_WEBSITE_ADDRESS','website_address');

	define('BSN_SEND_EMAIL','send_email');
	define('BSN_SEND_MSG','send_msg');

	/***********************************************************
				END BUSINESS PARAMETERS
	************************************************************/

	/***********************************************************
				START ENCRYPTION DECRYPTION
	************************************************************/

	define('KEY', 'LabtronEquipments2021');
	define('CIPHER', 'AES-128-ECB');
	define('ERROR_MSG', 'Some Error Occured, Please Contact Administrator');
	define('URL_ENCRYPT_KEY', 'labtron');
	define('URL_ENCRYPT_IV', 'labtron');

	/***********************************************************
				END ENCRYPTION DECRYPTION
	************************************************************/
	/***********************************************************
				START GENERAL PATHS
	************************************************************/

	define('LOGO_IMAGE_PATH', 'assets/images/logo.png');
	define('FAVICON_IMAGE_PATH', 'assets/images/favicon.png');
	define('HEADER_LOGO', 'assets/images/header_logo.jpg');
	define('BANNER_IMAGE_PATH', 'assets/resources/images/banners/');
	define('GALLERY_IMAGE_PATH', 'assets/resources/images/gallery/');
	define('EVENTS_IMAGE_PATH', 'assets/resources/images/events/');
	define('LINKS_IMAGE_PATH', 'assets/resources/images/links/');
	define('SAVE_PDF',  dirname(FCPATH).'/tender/assets/tcpdf/savedpdf/');
	define('SAVE_PDF_LINK',  'tender/assets/tcpdf/savedpdf/');
	define('SAVE_ADD_PDF_LINK',  dirname(FCPATH).'/tender/assets/tcpdf/additionalpdf/');

	define('SAMPLE_EXCEL_PATH', 'assets/sample_excels/');

	/***********************************************************
				END GENERAL PATHS
	************************************************************/

	/***********************************************************
				START DATATABLE CONSTANTS
	************************************************************/

	define('TABLE_SERVER_LIMIT','table_server_limit');
	define('TABLE_RESULT','result');
	define('TABLE_RESULT_ARRAY','result_array');
	define('TABLE_COUNT','count');

	/***********************************************************
				END DATATABLE CONSTANTS
	************************************************************/

	define('GLOBAL_CACHE_VERSION_DATE',"20180901");

	/***********************************************************
				START TCPDF
	************************************************************/

		/*define ('PDF_CREATOR', 'Labtron');
		define ('PDF_AUTHOR', 'Labtron');
		define ('PDF_HEADER_LOGO', 'logo.jpg');
		define ('PDF_HEADER_LOGO_WIDTH', '180');*/

		define('K_PATH_MAIN',  dirname(FCPATH).'/tender/assets/tcpdf/');

	/***********************************************************
				END TCPDF
	************************************************************/

/***********************************************************
			CUSTOM CONSTANT ENDS
************************************************************/