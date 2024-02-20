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
/*$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;*/

$route['404_override'] = '';
//$route['translate_uri_dashes'] = FALSE;

$route['default_controller'] = 'home';
$route['home'] = 'home';

$route['gallery'] = 'home/gallery';


$route['all-products'] = 'home/all_products';
$route['all-category'] = 'home/products_by_category';
$route['productdescription'] = 'home/product_description';
$route['catalogs'] = 'home/catalogs';
$route['about-us'] = 'home/about_us';
$route['contact-us'] = 'home/contact_us';
$route['privacy-policy'] = 'home/privacy_policy';
$route['sitemap'] = 'home/site_map';
$route['certificate'] = 'home/certificate';
$route['career'] = 'home/career';
$route['team-us'] = 'home/team_us';
$route['catalog/(:any)'] = 'home/catalog';

$route['distributor-list'] = 'login/userlist';
$route['disapprove'] = 'login/disapprove';
$route['approve'] = 'login/approve';
$route['block'] = 'login/block';
$route['unblock'] = 'login/unblock';

$route['login'] = 'login';
$route['validate'] = 'login/validate';
$route['register'] = 'login/register';
$route['insert_user'] = 'login/insert_user';
$route['userprofile'] = 'login/userprofile';
//route['edit-profile'] = 'user/editprofile';
$route['changepassword'] = 'login/changepassword';
$route['change-password?(:any)'] = 'login/changepassword';
$route['forgot-password'] = 'login/forgot_password';
$route['logout'] = 'login/logout';
$route['edit-profile'] = 'login/edit_profile';
$route['catalog/(:any)/(:any)'] = 'home/catalog';
$route['getproducts_cat'] = 'home/getproducts_cat';
$route['compare?(:any)'] = 'home/product_compare';

$route['cart'] = 'login/cart';
$route['addToCart'] = 'home/addToCart';
$route['removefromcart'] = 'home/removefromcart';
$route['emptycart'] = 'home/emptycart';
$route['update_cart'] = 'home/update_cart';

$route['search?(:any)'] = 'home/search_products';

$route['pdf/(:any)'] = 'home/pdf';

$route['error-page'] = 'home/error';
$route['thankyou'] = 'home/thankyou_page';

// $route['refresh'] = 'home/refresh';
$route['captcha-image?(:any)']='home/ajx_captcah_image';
//$route['delete_user']    = 'user/delete_user';
$route['load-captcha-image?(:any)']='captchabg/load_captcha_image';

$route['([a-zA-Z0-9\/-]+)'] = 'home/route';