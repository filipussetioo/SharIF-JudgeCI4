<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Dashboard');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the defaul
// route since we don't have to scan directories.
$routes->get('/', 'Dashboard::index',['filter' => 'check-installandlogin:dual,noreturn']);
$routes->get('/dashboard', 'Dashboard::index',['filter' => 'check-installandlogin:dual,noreturn']);
$routes->post('/dashboard/widget_positions', 'Dashboard::widget_positions');
// Authentication
$routes->get('/install','Install::index');
$routes->post('/install','Install::index');
$routes->add('/login','Login::index');
$routes->post('login/register','Login::register');
$routes->get('login/lost','Login::lost');
$routes->post('login/lost','Login::lost');
$routes->get('login/reset/(:any)', 'Login::reset/$1');
$routes->post('login/reset/(:any)', 'Login::reset/$1');
$routes->get('/register','Login::register');
$routes->post('/register','Login::register');
$routes->get('/settings','Settings::index',['filter' => 'check-loginandlevelAdmin:dual,noreturn']);
$routes->post('/settings','Settings::index',['filter' => 'check-loginandlevelAdmin:dual,noreturn']);
$routes->add('/profile/(:num)','Profile::index/$1',['filter' => 'check-login:dual,noreturn']);
$routes->get('/logout','Login::logout');
$routes->add('/settings/update', 'Settings::update');
// Users
$routes->get('/profile', 'Profile::index');
$routes->get('/users', 'Users::index',['filter' => 'check-loginandlevelAdmin:dual,noreturn']);
$routes->get('/users/add', 'Users::add',['filter' => 'check-loginandlevelAdmin:dual,noreturn']);
$routes->post('/users/add', 'Users::add',['filter' => 'check-loginandlevelAdmin:dual,noreturn']);
$routes->post('/users/delete_submissions', 'Users::delete_submissions',['filter' => 'check-loginandlevelAdmin:dual,noreturn']);
$routes->post('/users/delete', 'Users::delete',['filter' => 'check-loginandlevelAdmin:dual,noreturn']);
$routes->get('users/list_excel', 'Users::list_excel',['filter' => 'check-loginandlevelAdmin:dual,noreturn']);
// Notifications and scoreboard
$routes->get('/notifications', 'Notifications::index',['filter' => 'check-login:dual,noreturn']);
$routes->get('/notifications/add', 'Notifications::add',['filter' => 'check-login:dual,noreturn']);
$routes->post('/notifications/add', 'Notifications::add',['filter' => 'check-login:dual,noreturn']);
$routes->add('/notifications/edit/(:num)', 'Notifications::edit/$1',['filter' => 'check-login:dual,noreturn']);
$routes->post('/notifications/delete', 'Notifications::delete',['filter' => 'check-login:dual,noreturn']);
$routes->post('/notifications/check', 'Notifications::check',['filter' => 'check-login:dual,noreturn']);
$routes->get('/scoreboard','Scoreboard::index',['filter' => 'check-loginandcli:dual,noreturn']);
$routes->add('/server_time','Server_time::index',['filter' => 'check-loginandisajax:dual,noreturn']);
// Logs, hof, moss, rejudge, queue
$routes->get('logs', 'Logs::index',['filter' => 'check-login:dual,noreturn']);
$routes->get('halloffame', 'Halloffame::index',['filter' => 'check-login:dual,noreturn']);
$routes->get('moss/(:num)','Moss::index/$1',['filter' => 'check-loginandlevelHead:dual,noreturn']);
$routes->post('moss/(:num)','Moss::index/$1',['filter' => 'check-loginandlevelHead:dual,noreturn']);
$routes->get('moss/update/(:num)','Moss::update/$1',['filter' => 'check-loginandlevelHead:dual,noreturn']);
$routes->post('moss/update/(:num)','Moss::update/$1',['filter' => 'check-loginandlevelHead:dual,noreturn']);
$routes->get('queue','Queue::index',['filter' => 'check-loginandlevelHead:dual,noreturn']);
$routes->post('queue','Queue::index',['filter' => 'check-loginandlevelHead:dual,noreturn']);
$routes->post('queue/resume','Queue::resume',['filter' => 'check-loginandlevelHead:dual,noreturn']);
$routes->post('queue/pause','Queue::pause',['filter' => 'check-loginandlevelHead:dual,noreturn']);
$routes->post('queue/empty_queue','Queue::empty_queue',['filter' => 'check-loginandlevelHead:dual,noreturn']);
$routes->cli('queueprocess/run', 'Queueprocess::run');
$routes->get('rejudge', 'Rejudge::index',['filter' => 'check-loginandlevelHead:dual,noreturn']);
$routes->post('rejudge', 'Rejudge::index',['filter' => 'check-loginandlevelHead:dual,noreturn']);
$routes->get('rejudge/(:num)', 'Rejudge::index/$1',['filter' => 'check-loginandlevelHead:dual,noreturn']);
$routes->post('rejudge/rejudge_single','Rejudge::rejudge_single',['filter' => 'check-loginandlevelHead:dual,noreturn']);
//Assignments
$routes->get('/assignments','Assignments::index',['filter' => 'check-login:dual,noreturn']);
$routes->get('/assignments/add','Assignments::add',['filter' => 'check-login:dual,noreturn']);
$routes->post('/assignments/add','Assignments::add',['filter' => 'check-login:dual,noreturn']);
$routes->post('/assignments/select','Assignments::select',['filter' => 'check-login:dual,noreturn']);
$routes->get('/assignments/edit/(:num)','Assignments::edit/$1',['filter' => 'check-login:dual,noreturn']);
$routes->post('/assignments/edit/(:num)','Assignments::edit/$1',['filter' => 'check-login:dual,noreturn']);
$routes->get('/assignments/delete/(:num)','Assignments::delete/$1',['filter' => 'check-login:dual,noreturn']);
$routes->post('/assignments/delete/(:num)','Assignments::delete/$1',['filter' => 'check-login:dual,noreturn']);
$routes->get('/assignments/pdf/(:num)/(:any)/(:any)','Assignments::pdf/$1/$2/$3',['filter' => 'check-login:dual,noreturn']);
$routes->get('/assignments/pdf/(:num)','Assignments::pdf/$1',['filter' => 'check-login:dual,noreturn']);
$routes->post('/assignments/pdfCheck/(:num)', 'Assignments::pdfCheck/$1');
$routes->get('/assignments/pdfCheck/(:num)', 'Assignments::pdfCheck/$1');
$routes->get('/assignments/downloadtestsdesc/(:num)', 'Assignments::downloadtestsdesc/$1');
$routes->get('/assignments/download_submissions/(:any)/(:num)', 'Assignments::download_submissions/$1/$2');
// Submit and submissions
$routes->get('submit','Submit::index',['filter' => 'check-login:dual,noreturn']);
$routes->post('submit','Submit::index',['filter' => 'check-login:dual,noreturn']);
$routes->get('submit/load/(:num)','Submit::load/$1',['filter' => 'check-login:dual,noreturn']);
$routes->post('submit/save/(:any)','Submit::save/$1');
$routes->post('submit/save','Submit::save');
$routes->get('submit/get_output/(:num)','Submit::get_output/$1');
$routes->get('submissions/all/(:any)/(:any)', 'Submissions::all');
$routes->get('submissions/final','Submissions::the_final',['filter' => 'check-login:dual,noreturn']);
$routes->get('submissions/final/(:any)','Submissions::the_final/$1',['filter' => 'check-login:dual,noreturn']);
$routes->get('submissions/final/(:any)/(:any)','Submissions::the_final/$1/$2',['filter' => 'check-login:dual,noreturn']);
$routes->post('/submissions/view_code', 'Submissions::view_code');
$routes->post('/submissions/select', 'Submissions::select');
$routes->get('/submissions/all_excel/(:any)/(:any)', 'Submissions::all_excel/$1/$2');
$routes->get('/submissions/final_excel/(:any)/(:any)', 'Submissions::final_excel/$1/$2');
$routes->get('submissions/download_file/(:any)/(:num)/(:num)/(:num)','Submissions::download_file/$1/$2/$3/$4');
$routes->get('submissions/all','Submissions::all');
// Problems
$routes->get('/problems', 'Problems::index',['filter' => 'check-login:dual,noreturn']);
$routes->get('/problems/(:num)','Problems::index/$1');
$routes->get('/problems/(:num)/(:num)','Problems::index/$1/$2');
$routes->get('/problems/edit/(:any)/(:num)/(:num)', 'Problems::edit/$1/$2/$3');
$routes->post('/problems/edit/(:any)/(:num)/(:num)', 'Problems::edit/$1/$2/$3');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
