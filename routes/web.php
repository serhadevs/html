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

Route::get('/password-reset',function(){
    return view('auth/passwords/reset');
});

Route::patch('/password-send','Auth\ResetPasswordController@password_send')->name('password_send');

Route::get('/logout', function () {
    auth::logout();
    return redirect('/login');
});




// Panel Routes

Route::group(['middleware' => ['auth']], function () {
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/dashboard-notification/{id}', 'DashboardController@markAsRead');

//Requisition
    Route::resource('/requisition', 'RequisitionController');
    Route::get('/requisition/create/{id}', 'RequisitionController@create');
    Route::post('/requisition/store', 'RequisitionController@store');
    Route::get('/requisition/delete/{id}', 'RequisitionController@destroy');
    Route::get('/file/delete/{id}', 'RequisitionController@deleteFile');
    Route::get('/pdf_requisition/{id}', 'RequisitionController@printPDF');
    Route::get('/getSuppliers', function () {
    $suppliers = App\Supplier::all();

    return response()->json($suppliers);
});


//purchase-order
    Route::resource('/purchase-order', 'PurchaseOrderController');
    Route::get('/purchase-order/create/{id}', 'PurchaseOrderController@create');
    Route::get('/purchase-order/delete/{id}', 'PurchaseOrderController@destroy');

//checkpurchase-order
    Route::resource('/check-purchase', 'CheckPurchaseController');
    Route::get("/check-purchase/show", "CheckPurchaseController@show");
    Route::post('/refuse-purchase', 'CheckPurchaseController@refuse');
    Route::get('/undo-check-requisition','CheckPurchaseController@undo');


//suppliers controllers
    Route::resource('/suppliers', 'SuppliersController');
    Route::get('/suppliers/delete/{id}', 'SuppliersController@destroy');

//approve-requisition
    Route::resource('/approve-requisition', 'ApprovePurchaseRequisitionController');
    Route::get('/undo-approve-requisition','ApprovePurchaseRequisitionController@undo');
    // Route::get("/approve-requisition/show{id}", "ApprovePurchaseRequisitionController@show");


//approve-purchase order
    Route::resource('/approve-purchase-order', 'ApprovePurchaseOrderController');


//department's Units
Route::resource('/unit', 'UnitController');
Route::get('/unit/delete/{id}', 'UnitController@destroy');

//units of measurement
Route::resource('/measurement', 'UnitMeasurementController');
Route::get('/measurement/delete/{id}', 'UnitMeasurementController@destroy');

//Departments 
Route::resource('/department', 'DepartmentController');
Route::get('/department/delete/{id}', 'DepartmentController@destroy');


//Institution 
Route::resource('/institution', 'InstitutionController');
Route::get('/institution/delete/{id}', 'InstitutionController@destroy');


//user controller
Route::resource('/user','UserController');
Route::get('/user/delete/{id}', 'UserController@destroy');
Route::get('/user/reset/{id}', 'UserController@reset');
Route::get('/getUnits',function(){
    $units = App\Unit::all();

    return response()->json($units);
});
// supervisor authentication override
Route::post('/verify_password"', 'UserController@verify_password');
//disable accounts
Route::get('/user/updateStatus/{id}', 'UserController@updateStatus');




//change Institution
Route::resource('/change-institution', 'ChangeInstitutionController');
Route::patch('/change-institution/{id}', 'ChangeInstitutionController@update');

//change Password
Route::post('/change-password/user','UserController@changePassword');
Route::view("/change-password", "auth.change-password")->name('password.expired');
Route::post("/verify_password", "UserController@verify_password");


//IPR controller
Route::resource('/internal_requisition', 'InternalRequisitionController');
Route::get('/internal_requisition/delete/{id}', 'InternalRequisitionController@destroy');
Route::get('/attached/delete/{id}', 'InternalRequisitionController@deleteAttached');


//Approve IRF controller
Route::resource('/approve-internal-requisition', 'ApproveInternalRequisitionController');
Route::get('/undo-approve-internal-requisition','ApproveInternalRequisitionController@undo');

//Approve budget controller
Route::resource('/approve-budget-requisition', 'ApproveBudgetController');
// Route::get("/approve-budget/show", "ApproveBudgetController@show");
//print pdf controller
Route::get('/print_pdf/{id}', 'ApproveBudgetController@printPDF');
Route::get('/undo-budget-requisition','ApproveBudgetController@undo');


//budgetcommitment
Route::resource('/budgetcommitment', 'BudgetCommitmentController');
Route::get('/budgetcommitment/create/{id}', 'BudgetCommitmentController@create');
Route::get('/budgetcommitment/destroy/{id}', 'BudgetCommitmentController@destroy');

//Assign
Route::resource('assign_requisition','AssignRequisitionController');
Route::patch('assign_requisition/{id}/update','AssignRequisitionController@update');
Route::get('assign-requisition/{id}/create','AssignRequisitionController@create');
Route::get('assign-requisition/show/{id}', 'AssignRequisitionController@show');
Route::get('/request-information', 'AssignRequisitionController@request');
Route::get('/refuse-requisition',  'AssignRequisitionController@undo');




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

//Certify internal requisition
Route::resource('/certify-internal-requisition','CertifiedInternalRequisitionController');
Route::get('/undo-internal-requisition','CertifiedInternalRequisitionController@undo');

//Audit Trail
Route::resource('audit-trail','AuditTrailController');
Route::resource('/trail-ipr', 'TrailInternalRequisitionController');

//General report controller
Route::resource('general-report','GeneralReportController');

//spend analysis report
Route::resource('spend-analysis','SpendAnalysisController');
//summary report
Route::resource('summary-report','SummaryReportController');

//currency
Route::resource('/currency', CurrencyController::class);
Route::get('/currency/delete/{id}', 'CurrencyController@destroy');

//Procurement Committee
Route::resource('/procurement-committee', 'ProcurementCommitteeController');
Route::get('/procurement-committee/create/{id}', 'ProcurementCommitteeController@create');
Route::get('/procurement-committee/delete/{id}', 'ProcurementCommitteeController@destroy');

//Entity Head approve
Route::resource('/entity_head_approve', 'EntityHeadApproveController');
Route::get('/undo_entity_head_approve','EntityHeadApproveController@undo');
// Route::get("/approve-requisition/show{id}", "ApprovePurchaseRequisitionController@show");










});
Auth::routes();