<?php


use Illuminate\Support\Facades\Route;
use Spatie\Permission\Contracts\Permission;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\ColorController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::middleware(['auth'])->get('/', function () {
//     return view('welcome');

// });



require __DIR__ . '/auth.php';

// Route::get('/', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');


Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');

//admin group middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');
});

Route::middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/agent/dashboard', [AgentController::class, 'AgentDashboard'])->name('agent.dashboard');
});




Route::middleware(['auth', 'role:admin'])->group(function () {

    //permission all route
    Route::controller(RoleController::class)->group(function () {
        Route::get('/all/permission', 'AllPermission')->name('all.permission')->middleware('can:add.permission');
        Route::get('/add/permission', 'AddPermission')->name('add.permission')->middleware('can:add.permission');
        Route::post('/store/permission', 'StorePermission')->name('store.permission');
        Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission')->middleware('can:add.permission');
        Route::post('/update/permission', 'UpdatePermission')->name('update.permission');
        Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission')->middleware('can:delete.permission');
        Route::get('/import/permission', 'ImportPermission')->name('import.permission');
        Route::get('/export', 'Export')->name('export');
        Route::post('/import', 'Import')->name('import');
    });

    //role all route
    Route::controller(RoleController::class)->group(function () {
        Route::get('/all/roles', 'AllRoles')->name('all.roles')->middleware('can:all.roles');
        Route::get('/add/roles', 'AddRoles')->name('add.roles')->middleware('can:add.roles');
        Route::post('/store/roles', 'StoreRoles')->name('store.roles');
        Route::get('/edit/roles/{id}', 'EditRoles')->name('edit.roles')->middleware('can:edit.roles');
        Route::post('/update/roles', 'UpdateRoles')->name('update.roles');
        Route::get('/delete/roles/{id}', 'DeleteRoles')->name('delete.roles')->middleware('can:delete.roles');


        Route::get('/add/roles/permission', 'AddRolesPermission')->name('add.roles.permission')->middleware('can:add.roles.permission');
        Route::post('/add/permission/store', 'RolesPermissionStore')->name('roles.permission.store');
        Route::get('/all/roles/permission', 'AllRolesPermission')->name('all.roles.permission')->middleware('can:all.roles.permission');
        Route::get('/admin/edit/roles/{id}', 'AdminEditRoles')->name('admin.edit.roles')->middleware('can:admin.edit.roles');
        Route::post('/admin/roles/update/{id}', 'AdminRolesUpdate')->name('admin.roles.update');
        Route::get('/admin/delete/roles/{id}', 'AdminDeleteRoles')->name('admin.delete.roles')->middleware('can:admin.delete.roles');
    });


    //Admin User All Route
    Route::controller(AdminController::class)->group(function () {
        Route::get('/all/admin', 'AllAdmin')->name('all.admin')->middleware('can:all.admin');
        Route::get('/add/admin', 'AddAdmin')->name('add.admin')->middleware('can:add.admin');
        Route::post('/store/admin', 'StoreAdmin')->name('store.admin');
        Route::get('/edit/admin/{id}', 'EditAdmin')->name('edit.admin')->middleware('can:edit.admin');
        Route::post('/update/admin/{id}', 'UpdateAdmin')->name('update.admin');
        Route::get('/delete/admin/{id}', 'DeleteAdmin')->name('delete.admin')->middleware('can:delete.admin');
    });


    

      //color User All Color
      Route::controller(ColorController::class)->group(function () {
        Route::get('/all/color', 'AllColor')->name('all.color')->middleware('can:all.color');
        Route::get('/get/color', 'GetColor')->name('get.color')->middleware('can:all.color');
        Route::get('/get/colorglobal', 'GetColorGlobal')->name('get.colorGlobal');
        Route::get('/add/color', 'AddColor')->name('add.color')->middleware('can:add.color');
      
        Route::post('/store/color', 'StoreColor')->name('store.color');
        Route::get('/edit/color/{id}', 'EditColor')->name('edit.color')->middleware('can:edit.color');
        Route::post('/update/color/{id}', 'UpdateColor')->name('update.color');
        Route::get('/delete/color/{id}', 'DeleteColor')->name('delete.color');
        Route::get('/export/color', 'ExportColor')->name('export.color');
    });

     


    Route::controller(EmployeeController::class)->group(function () {
        Route::get('/all/employee', 'AllEmployee')->name('all.employee')->middleware('can:all.employee');
        Route::get('/add/employee', 'AddEmployee')->name('add.employee')->middleware('can:add.employee');
        Route::post('/store/employee', 'StoreEmployee')->name('store.employee');
        Route::get('/edit/employee/{id}', 'EditEmployee')->name('edit.employee')->middleware('can:edit.employee');
        Route::post('/update/employee/{id}', 'UpdateEmployee')->name('update.employee');
        Route::get('/delete/employee/{id}', 'DeleteEmployee')->name('delete.employee');
        Route::get('/export/employee', 'ExportEmployee')->name('export.employee');
        Route::get('/get/employee', 'Getemployee')->name('get.employee')->middleware('can:all.employee');
        Route::get('/get/employeecount', 'GetEmployeeCount')->name('get.employeecount');
        Route::post('/check/employee', 'CheckEmployee')->name('check.employee');
        Route::get('/pdf/employee', 'exportPDF')->name('pdf.employee');
        Route::post('/import/employee', 'ImportEmployee')->name('import.employee');
        Route::get('/import/employees', 'Importemployees')->name('import.employees');
      
    });

    Route::controller(TransactionController::class)->group(function () {
       
        Route::get('/all/transaction', 'Alltransaction')->name('all.transaction')->middleware('can:all.transaction');
        Route::get('/add/transaction', 'Addtransaction')->name('add.transaction')->middleware('can:add.transaction');
        Route::post('/store/transaction', 'Storetransaction')->name('store.transaction');
        Route::get('/edit/transaction/{id}', 'Edittransaction')->name('edit.transaction')->middleware('can:edit.transaction');
        Route::post('/update/transaction/{id}', 'Updatetransaction')->name('update.transaction');
        Route::get('/delete/transaction/{id}', 'Deletetransaction')->name('delete.transaction');
        Route::get('/export/transaction', 'Exporttransaction')->name('export.transaction');
        Route::get('/get/transaction', 'Gettransaction')->name('get.transaction')->middleware('can:all.transaction');
        Route::get('/get/transactionin', 'GettransactionIN')->name('get.transactionin');
        Route::get('/get/transactionout', 'GettransactionOUT')->name('get.transactionout');
        Route::get('/get/transactionstay', 'GettransactionSTAY')->name('get.transactionstay');
        Route::get('/pdf/transaction', 'exportPdf')->name('pdf.transaction');
      
    });



}); //end admin middleware



// Route::get('/', function () {
//    return 'hello';
// });

// Route::get('/login', function () {
//     return view('admin.admin_login');
// });

// Route::get('/dashboard', function () {
//     return view('admin.dashboard');
// });

// Route::middleware('auth')->group(function () {
  
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

