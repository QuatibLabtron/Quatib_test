<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] 				= "cms/dashboard";
$route['404_override'] 						= '';
$route['translate_uri_dashes'] 				= FALSE;

/*$route['admin/([a-zA-Z_-]+)/(:any)'] 		= '$1/admin/$2';*/

/***********************************************************
			LOGIN ROUTES
************************************************************/

$route['home'] 								= "cms/dashboard";
$route['login'] 							= "login/loginView";
$route['logout'] 							= "login/logout";
$route['googleAuth?(:any)']                 = "login/googleAuth";


/***********************************************************
			DASHBOARD ROUTES
************************************************************/
$route['dashboard'] 						= "cms/dashboard";
$route['getdashboardlist'] 					= "cms/dashboardDataTablelist";
$route['getuserFeedlist'] 					= "cms/userFeedDataTablelist";
$route['dashboard-details-(:any)'] 			= "cms/dashboardDetails/$1";
$route['gettenderDashboardlist-(:any)'] 	= "cms/tendersDataTablelist/$1";
$route['export-user-followup-(:any)'] 		= "cms/userFolloupExport/$1";



/***********************************************************
			USER ROUTES
************************************************************/
$route['add-user'] 					= "user/add_user";
$route['edit-user-(:any)'] 			= "user/edit_user/$1";
$route['user-details-(:any)'] 		= "user/userDetails/$1";
$route['users'] 					= "user/userList";
$route['getuserlist'] 				= 'user/userDataTablelist';
$route['user-activate'] 			= "user/user_active";
$route['user-deactivate'] 			= "user/user_deactive";


/***********************************************************
			ORGANISATIONS ROUTES 
************************************************************/
$route['add-organisations'] 				= "organisations/add_organisations";
$route['edit-organisations-(:any)'] 		= "organisations/edit_organisations/$1";
$route['organisations-detail-(:any)'] 		= "organisations/organisationsDetail/$1";
$route['organisations'] 					= "organisations/organisationsList";
$route['getorganisationslist'] 				= 'organisations/organisationsDataTablelist';
$route['getorgcontactslist'] 				= 'organisations/contactsDataTablelist';
$route['upload-organisations-image'] 		= 'organisations/organisationsImageUpload';
$route['organisations-activate'] 			= "organisations/organisations_active";
$route['organisations-deactivate'] 			= "organisations/organisations_deactive";
$route['organisations-export'] 				= "organisations/organisations_export";
$route['organisations-import'] 				= "organisations/organisations_import";


/***********************************************************
			CONTACTS ROUTES 
************************************************************/
$route['add-contacts'] 						= "contacts/add_contacts";
$route['edit-contacts-(:any)'] 				= "contacts/edit_contacts/$1";
$route['contacts-detail-(:any)'] 			= "contacts/contactsDetail/$1";
$route['contacts'] 							= "contacts/contactsList";
$route['getcontactslist'] 					= 'contacts/contactsDataTablelist';
$route['upload-contacts-image'] 			= 'contacts/contactsImageUpload';
$route['contacts-activate'] 				= "contacts/contacts_active";
$route['contacts-deactivate'] 				= "contacts/contacts_deactive";
$route['contacts-export'] 					= "contacts/contacts_export";
$route['contacts-import'] 					= "contacts/contacts_import";


/***********************************************************
			PRICE LIST ROUTES 
************************************************************/

$route['tender_pricelist-detail-(:any)'] 	= "tender_pricelist/tender_pricelistDetail/$1";
$route['tender_pricelist'] 					= "tender_pricelist/tender_pricelistList";
$route['gettender_pricelistlist'] 			= 'tender_pricelist/tender_pricelistDataTablelist';
$route['tender_pricelist-import'] 			= "tender_pricelist/tender_pricelist_import";



/***********************************************************
			Tender ROUTES 
************************************************************/
$route['add-tenders'] 							= "tenders/add_tenders";
$route['edit-tenders-(:any)'] 					= "tenders/edit_tenders/$1";
$route['tenders-detail-(:any)'] 				= "tenders/tendersDetail/$1";
$route['tenders-pdf-(:any)-(:any)'] 			= "tenders/generate_pdf/$1/$2";
$route['tenders-invoice-pdf-(:any)-(:any)'] 	= "tenders/generate_pdf_invoice/$1/$2";
$route['tenders'] 								= "tenders/tendersList";
$route['gettenderslist'] 						= 'tenders/tendersDataTablelist';
$route['upload-tenders-image'] 					= 'tenders/tendersImageUpload';
$route['tenders-activate'] 						= "tenders/tenders_active";
$route['tenders-deactivate'] 					= "tenders/tenders_deactive";
$route['send-email-tenders-(:any)']     		= "tenders/tendersGenrateEmail/$1";
$route['send-invoice-email-(:any)']     		= "tenders/tendersGenrateEmailInvoice/$1";


	                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            

/***********************************************************
			GENERAL & BUSINESS PARAMETER ROUTES
************************************************************/

$route['gen-parameter-list'] 				= "parameter";
$route['parameter-list']					= "parameter/gen_parameter";
$route['business-parameter']				= "parameter/business_parameter_list";



/***********************************************************
			CRUD FOR EXCEL ROUTES STARTS
************************************************************/


	/***********************************************************
				DATA TYPES EXCEL ROUTES  
	************************************************************/
	$route['add-datatypes'] 				= "datatypes/add_datatypes";
	$route['edit-datatypes-(:any)'] 		= "datatypes/edit_datatypes/$1";
	$route['datatypes-detail-(:any)'] 		= "datatypes/datatypesDetail/$1";
	$route['datatypes'] 					= "datatypes/datatypesList";
	$route['getdatatypeslist'] 				= 'datatypes/datatypesDataTablelist';
	$route['datatypes-activate'] 			= "datatypes/datatypes_active";
	$route['datatypes-deactivate'] 			= "datatypes/datatypes_deactive";


	/***********************************************************
				ENTITIES EXCEL ROUTES 
	************************************************************/
	$route['add-entities'] 					= "entities/add_entities";
	$route['edit-entities-(:any)'] 			= "entities/edit_entities/$1";
	$route['entities-detail-(:any)'] 		= "entities/entitiesDetail/$1";
	$route['entities'] 						= "entities/entitiesList";
	$route['getentitieslist'] 				= 'entities/entitiesDataTablelist';
	$route['entities-activate'] 			= "entities/entities_active";
	$route['entities-deactivate'] 			= "entities/entities_deactive";


/***********************************************************
			CRUD FOR EXCEL ROUTES END
************************************************************/


/***********************************************************
			 EXCEL PROCESSING ROUTES 
************************************************************/
$route['import-excel-process']				= "excel_process/excel_importing";

