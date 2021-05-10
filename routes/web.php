<?php

use Illuminate\Support\Facades\Route;
// use App\InternalRequisition;
// use App\Notifications\InternalRequisitionPublish;
use App\Notifications\RefuseRequisitionPublish;
use App\User;
use App\Notifications\ApproveRequisitionPublish;
use App\Comment;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    // $user = App\User::first();
    // //  dd($users);
    // $internal = App\InternalRequisition::first();
    // // foreach($users as $user){

    // $user->notify(new InternalRequisitionPublish($internal));
    // }

            //     $users = User::where('institution_id',auth()->user()->institution_id )
            //     ->where('department_id', auth()->user()->department_id)
            //     ->whereIn('role_id',['1,2'])
            //     ->get();
      
            //     $requisition = App\Requisition::first();
            //     $comment = App\Comment::first();
       
            
            //    $users->each->notify(new  RefuseRequisitionPublish($requisition,$comment ));
    return view('auth/login');
});

Route::get('/logout', function () {
    auth::logout();
    return redirect('/login');
});

Auth::routes();
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
// Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

// Panel Routes

Route::group(['middleware' => ['auth']], function () {
//Requisition
    Route::resource('/requisition', 'RequisitionController');
    Route::get('/requisition/create/{id}', 'RequisitionController@create');
    Route::post('/requisition/store', 'RequisitionController@store');
    Route::get('/requisition/delete/{id}', 'RequisitionController@destroy');
    Route::get('/file/delete/{id}', 'RequisitionController@deleteFile');

//purchase-order
    Route::resource('/purchase-order', 'PurchaseOrderController');
    Route::get('/purchase-order/create/{id}', 'PurchaseOrderController@create');

//checkpurchase-order
    Route::resource('/check-purchase', 'CheckPurchaseController');
    Route::get("/check-purchase/show", "CheckPurchaseController@show");
    Route::post('/refuse-purchase', 'CheckPurchaseController@refuse');


//suppliers controllers
    Route::resource('/suppliers', 'SuppliersController');

//aprove-requisition
    Route::resource('/approve-requisition', 'ApprovePurchaseRequisitionController');
    // Route::get("/approve-requisition/show{id}", "ApprovePurchaseRequisitionController@show");


//approve-purchase order
    Route::resource('/approve-purchase-order', 'ApprovePurchaseOrderController');


//Departments Controllers
Route::resource('/department', 'DepartmentController');
Route::get('/department/delete/{id}', 'DepartmentController@destroy');


//Institution Controllers
Route::resource('/institution', 'InstitutionController');
Route::get('/institution/delete/{id}', 'InstitutionController@destroy');


//user controller
Route::resource('/user','UserController');
Route::get('/user/delete/{id}', 'UserController@destroy');
Route::get('/user/reset/{id}', 'UserController@reset');


//change Institution
Route::resource('/change-institution', 'ChangeInstitutionController');
Route::patch('/change-institution/{id}', 'ChangeInstitutionController@update');

//change Password
Route::post('/change-password/user','UserController@changePassword');
Route::view("/change-password/", "auth.change-password");

//IPR controller
Route::resource('/internal_requisition', 'InternalRequisitionController');
Route::get('/internal_requisition/delete/{id}', 'InternalRequisitionController@destroy');

//Approve IRF controller
Route::resource('/approve-internal-requisition', 'ApproveInternalRequisitionController');

//Approve budget controller
Route::resource('/approve-budget-requisition', 'ApproveBudgetController');
// Route::get("/approve-budget/show", "ApproveBudgetController@show");
//print pdf controller
Route::get('/print_pdf/{id}', 'ApproveBudgetController@printPDF');


//budgetcommitment
Route::resource('/budgetcommitment', 'BudgetCommitmentController');
Route::get('/budgetcommitment/create/{id}', 'BudgetCommitmentController@create');
Route::get('/budgetcommitment/destroy/{id}', 'BudgetCommitmentController@destroy');

//Assign
Route::resource('assign_requisition','AssignRequisitionController');
Route::get('assign-requisition/{id}/create','AssignRequisitionController@create');

//Payment Voucher
Route::resource('payment-voucher','PaymentVoucherController');
Route::get('payment-voucher/create/{id}','PaymentVoucherController@create');
Route::get('/payment-voucher/delete/{id}', 'PaymentVoucherController@destroy');

//Voucher Check
Route::resource('/voucher-check','VoucherCheckController');
Route::get("/voucher-check/show/{id}", "VoucherCheckController@show");
// Route::get("/voucher-check/store/", "VoucherCheckController@show");

//Certyfing Voucher
Route::resource('/certifying-voucher','CertifyingPaymentVoucherController');














});
