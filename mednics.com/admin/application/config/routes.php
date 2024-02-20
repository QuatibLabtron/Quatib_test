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
$route['default_controller'] 		= 'login/loginView';
$route['404_override'] 				= '';
$route['translate_uri_dashes'] 		= FALSE;

/*$route['admin/([a-zA-Z_-]+)/(:any)'] 		= '$1/admin/$2';*/

/***********************************************************
			LOGIN ROUTES
************************************************************/

$route['login'] 					= "login/loginView";
$route['logout'] 					= "login/logout";
$route['dashboard'] 				= "cms/dashboard";
$route['googleAuth?(:any)']         = "login/googleAuth";



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
			SECTION ROUTES 
************************************************************/
$route['add-section'] 				= "section/add_section";
$route['edit-section-(:any)'] 		= "section/edit_section/$1";
$route['section-detail-(:any)'] 	= "section/sectionDetail/$1";
$route['sections'] 					= "section/sectionList";
$route['getsectionlist'] 			= 'section/sectionDataTablelist';
$route['upload-section-image'] 		= 'section/sectionImageUpload';
$route['section-activate'] 			= "section/section_active";
$route['section-deactivate'] 		= "section/section_deactive";
$route['section-export'] 			= "section/section_export";
$route['section-import'] 			= "section/section_import";



/***********************************************************
			CATEGORIES ROUTES 
************************************************************/
$route['add-categories'] 			= "categories/add_categories";
$route['edit-categories-(:any)'] 	= "categories/edit_categories/$1";
$route['categories-detail-(:any)'] 	= "categories/categoriesDetail/$1";
$route['categories'] 				= "categories/categoriesList";
$route['getcategorieslist'] 		= 'categories/categoriesDataTablelist';
$route['upload-categories-image'] 	= 'categories/categoriesImageUpload';
$route['categories-activate'] 		= "categories/categories_active";
$route['categories-deactivate'] 	= "categories/categories_deactive";
$route['categories-export'] 		= "categories/categories_export";
$route['categories-import'] 		= "categories/categories_import";



/***********************************************************
			PAGES ROUTES 
************************************************************/
$route['add-pages'] 				= "pages/add_pages";
$route['edit-pages-(:any)'] 		= "pages/edit_pages/$1";
$route['pages-detail-(:any)'] 		= "pages/pagesDetail/$1";
$route['pages'] 					= "pages/pagesList";
$route['getpageslist'] 				= 'pages/pagesDataTablelist';
$route['pages-activate'] 			= "pages/pages_active";
$route['pages-deactivate'] 			= "pages/pages_deactive";
$route['pages-export'] 				= "pages/pages_export";
$route['pages-import'] 				= "pages/pages_import";


/***********************************************************
			PRODUCTS ROUTES 
************************************************************/

$route['products-detail-(:any)'] 	= "products/productsDetail/$1";
$route['products'] 					= "products/productsList";
$route['getproductslist'] 			= 'products/productsDataTablelist';
$route['products-activate'] 		= "products/products_active";
$route['products-deactivate'] 		= "products/products_deactive";
$route['products-field'] 			= "products/productsFieldList";
$route['add-products-field'] 		= "products/addproductsField";
$route['products-import'] 			= "products/products_import";
$route['pricelist-import'] 			= "products/pricelist_import";

/***********************************************************
			BANNER ROUTES 
************************************************************/
$route['add-banners'] 				= "banners/add_banners";
$route['edit-banners-(:any)'] 		= "banners/edit_banners/$1";
$route['banners-detail-(:any)'] 	= "banners/bannersDetail/$1";
$route['banners'] 					= "banners/bannersList";
$route['getbannerslist'] 			= 'banners/bannersDataTablelist';
$route['upload-banners-image'] 		= 'banners/bannersImageUpload';
$route['banners-activate'] 			= "banners/banners_active";
$route['banners-deactivate'] 		= "banners/banners_deactive";


/***********************************************************
			PRODUCTS SEO ROUTES 
************************************************************/

$route['products-seo-import'] 	    = "seo/products_seo_import";
$route['add-seo-product'] 			= "seo/add_seo_product";
$route['add-seo-categorie'] = "seo/add_seo_categorie";
$route['add-seo-pages'] = "seo/add_seo_pages";
$route['add-seo-product-(:any)'] 	= "seo/add_seo_product/$1";
$route['add-seo-categorie-(:any)'] 	= "seo/add_seo_categorie/$1";
$route['add-seo-pages-(:any)'] 	= "seo/add_seo_pages/$1";
$route['seo-detail-(:any)'] 	= "seo/seoDetail/$1";

/***********************************************************
			GENERAL & BUSINESS PARAMETER ROUTES
************************************************************/

$route['gen-parameter-list'] 		= "parameter";
$route['parameter-list']			= "parameter/gen_parameter";
$route['business-parameter']		= "parameter/business_parameter_list";




/***********************************************************
			CRUD FOR EXCEL ROUTES STARTS
************************************************************/


	/***********************************************************
				DATA TYPES EXCEL ROUTES  
	************************************************************/
	$route['add-datatypes'] 			= "datatypes/add_datatypes";
	$route['edit-datatypes-(:any)'] 	= "datatypes/edit_datatypes/$1";
	$route['datatypes-detail-(:any)'] 	= "datatypes/datatypesDetail/$1";
	$route['datatypes'] 				= "datatypes/datatypesList";
	$route['getdatatypeslist'] 			= 'datatypes/datatypesDataTablelist';
	$route['datatypes-activate'] 		= "datatypes/datatypes_active";
	$route['datatypes-deactivate'] 		= "datatypes/datatypes_deactive";


	/***********************************************************
				ENTITIES EXCEL ROUTES 
	************************************************************/
	$route['add-entities'] 				= "entities/add_entities";
	$route['edit-entities-(:any)'] 		= "entities/edit_entities/$1";
	$route['entities-detail-(:any)'] 	= "entities/entitiesDetail/$1";
	$route['entities'] 					= "entities/entitiesList";
	$route['getentitieslist'] 			= 'entities/entitiesDataTablelist';
	$route['entities-activate'] 		= "entities/entities_active";
	$route['entities-deactivate'] 		= "entities/entities_deactive";


/***********************************************************
			CRUD FOR EXCEL ROUTES END
************************************************************/


/***********************************************************
			 EXCEL PROCESSING ROUTES 
************************************************************/
$route['import-excel-process']		= "excel_process/excel_importing";
