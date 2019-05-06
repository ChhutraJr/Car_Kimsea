<?php

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

//Login

Route::get('/','LoginController@index')->name('login.system');
Route::post('/login','LoginController@auth')->name('login.login');

Route::group(['prefix' => '/','middleware' => 'check.admin'],function () {

    Route::get('/event',function (){
        event(new \App\Events\Event('Hello'));
    });

    Route::post('/notification/get', 'NotificationController@get');
    Route::post('/notification/read', 'NotificationController@read');


    //Logout
    Route::get('/logout','LoginController@logout');

    //Dashboard
    Route::get('/dashboard', 'DashboardController@index');

    //Customer Start
    Route::get('/customers/{val1?}/{val2?}/{val3?}','CustomerController@index');
    Route::get('/customer/create','CustomerController@create');
    Route::post('/customer/store','CustomerController@store')->name('store.customer');
    Route::get('/customer/update/{id}','CustomerController@update');
    Route::post('/customer/save-update','CustomerController@save_update')->name('save_update.customer');
    Route::post('/customer/delete','CustomerController@delete')->name('master_delete.customer');

    // Server Side
    Route::post('/customer/get_data', 'CustomerController@get_data')->name('customer.get_data');

    //Filters
    Route::post('/customer/get_data_filter', 'CustomerController@get_data_filter')->name('customer.get_data_filter');


    //Customer Detail Start
    Route::get('/customer-detail/follow-up/{id}','CustomerController@update_follow_up');

    //Add Customer Follow Up Start
    Route::post('/customer-detail/follow-up/store','CustomerController@store_follow_up')->name('store_detail.follow_up');
    Route::post('/customer-detail/follow-up/delete','CustomerController@delete_follow_up')->name('delete_detail.follow_up');
    //Add Customer Follow Up End

    //Server Side Follow Up
    Route::post('/customer-detail/follow-up/get_data', 'CustomerController@get_data_follow_up')->name('follow_up.get_data');
    //Server Side Customer Detail
    Route::post('/customer-detail/get_data','CustomerController@get_data_detail')->name('customer_detail.get_data');

    //Customer Detail End

    //Customer End

    //Vehicle Start
    //Vehicle Model Start
    Route::get('/vehicle-models','VehicleModelController@index');
    Route::get('/vehicle-model/create','VehicleModelController@create');
    Route::post('/vehicle-model/store','VehicleModelController@store')->name('store.vehicle_model');
    Route::get('/vehicle-model/update/{id}','VehicleModelController@update');
    Route::post('/vehicle-model/save-update','VehicleModelController@save_update')->name('save_update.vehicle_model');
    Route::post('/vehicle-model/delete','VehicleModelController@delete')->name('master_delete.vehicle_model');

    //Validate Model
    Route::post('/vehicle-model-validate','VehicleModelController@model_name_validate')->name('vehicle_model.validate');

    //    Server Side
    Route::post('/vehicle-model/get_data', 'VehicleModelController@get_data')->name('vehicle_model.get_data');
    //Vehicle Model End

    //Vehicle Brand Start
    Route::get('/vehicle-brands','VehicleBrandController@index');
    Route::get('/vehicle-brand/create','VehicleBrandController@create');
    Route::post('/vehicle-brand/store','VehicleBrandController@store')->name('store.vehicle_brand');
    Route::get('/vehicle-brand/update/{id}','VehicleBrandController@update');
    Route::post('/vehicle-brand/save-update','VehicleBrandController@save_update')->name('save_update.vehicle_brand');
    Route::post('/vehicle-brand/delete','VehicleBrandController@delete')->name('master_delete.vehicle_brand');

    //    Server Side
    Route::post('/vehicle-brand/get_data', 'VehicleBrandController@get_data')->name('vehicle_brand.get_data');
    //Vehicle Brand End

    //Vehicle Color Start
    Route::get('/vehicle-colors','VehicleColorController@index');
    Route::get('/vehicle-color/create','VehicleColorController@create');
    Route::post('/vehicle-color/store','VehicleColorController@store')->name('store.vehicle_color');
    Route::get('/vehicle-color/update/{id}','VehicleColorController@update');
    Route::post('/vehicle-color/save-update','VehicleColorController@save_update')->name('save_update.vehicle_color');
    Route::post('/vehicle-color/delete','VehicleColorController@delete')->name('master_delete.vehicle_color');

    //    Server Side
    Route::post('/vehicle-color/get_data', 'VehicleColorController@get_data')->name('vehicle_color.get_data');

    //Validate Color
    Route::post('/vehicle-color-validate','VehicleColorController@color_name_validate')->name('vehicle_color.validate');

    //Vehicle Color End

    //Vehicle End

    //Expense Start
    Route::get('/expenses/{val1?}/{val2?}/{val3?}','ExpenseController@index');
    Route::get('/expense/create','ExpenseController@create');
    Route::post('/expense/store','ExpenseController@store')->name('store.expense');
    Route::get('/expense/update/{id}','ExpenseController@update');
    Route::post('/expense/save-update','ExpenseController@save_update')->name('save_update.expense');
    Route::post('/expenses/delete','ExpenseController@delete')->name('master_delete.expense');
    // Server Side
    Route::post('/expense/get_data', 'ExpenseController@get_data')->name('expense.get_data');

    //Expense validate total amount
    Route::post('/expense-total-amount-validate', 'ExpenseController@total_amount_validate')->name('expense.total_amount_validate');

    //Get Expense by between date
    Route::post('expense-get-by-date','ExpenseController@get_data_by_date')->name('expense.get_data_by_date');

    //Get Expense by pagination
    Route::get('expense/pagination/{page}','ExpenseController@pagination');


    //Expense End

    //Expense Category Start
    Route::get('/expense-categories','ExpenseCategoryController@index');
    Route::get('/expense-category/create','ExpenseCategoryController@create');
    Route::post('/expense-category/store','ExpenseCategoryController@store')->name('store.expense_category');
    Route::get('/expense-category/update/{id}','ExpenseCategoryController@update');
    Route::post('/expense-category/save-update','ExpenseCategoryController@save_update')->name('save_update.expense_category');
    Route::post('/expense-category/delete','ExpenseCategoryController@delete')->name('master_delete.expense_category');
    // Server Side
    Route::post('/expense-category/get_data', 'ExpenseCategoryController@get_data')->name('expense_category.get_data');

    //Expense Category_validate_name
    Route::post('/expense-cat-name-validate','ExpenseCategoryController@expense_cat_name_validate')->name('exp_cat.validate_name');

    //Expense Category End

    //invoice Start
    Route::get('/invoices/{val1?}/{val2?}/{val3?}','InvoiceController@index');
    Route::get('/invoice/create/{cus_id?}','InvoiceController@create');
    Route::post('/invoice/store','InvoiceController@store')->name('store.invoice');
    Route::get('/invoice/update/{id}','InvoiceController@update');
    Route::post('/invoice/save-update','InvoiceController@save_update')->name('save_update.invoice');
    Route::post('invoice/delete','InvoiceController@delete')->name('master_delete.invoice');

    // Server Side
    Route::post('/invoice/get_data', 'InvoiceController@get_data')->name('invoice.get_data');

    //invoice Product
    Route::get('/invoice_products','InvoiceController@invoice_products');

    //invoice Detail
    Route::post('/invoice_detail/store','InvoiceController@store_detail')->name('store_detail.invoice');
    Route::post('/invoice_detail/save-update','InvoiceController@save_update_detail')->name('save_update_detail.invoice');

    // Server Side
    Route::post('/invoice_detail/get_data', 'InvoiceController@get_data_detail')->name('invoice_detail.get_data');

    //invoice Payment on add new invoice
    Route::post('/invoice_payment/store','InvoiceController@store_payment')->name('store_payment.invoice');

    //invoice Payment on add payment action
    Route::post('/invoice_payment_multi/store','InvoiceController@store_payment_multi')->name('store_payment_multi.invoice');

    //invoice Payment on add payment action
    Route::post('/invoice_payment/save-update','InvoiceController@save_update_payment')->name('save_update_payment.invoice');

    //Delete Payment
    Route::post('/invoice_payment/delete','InvoiceController@delete_payment')->name('delete_payment.invoice');

    // Server Side
    Route::post('/invoice_payment/get_data', 'InvoiceController@get_data_payment')->name('invoice_payment.get_data');

    //Check Product Qty
    Route::post('/invoice_product_qty/check','InvoiceController@check_product_qty')->name('invoice_product_qty.check');

    //Check Description
    Route::post('/invoice_des/check','InvoiceController@check_des')->name('invoice_des.check');

    //invoice Payment
    Route::get('/invoice-detail/payment/{id}','InvoiceController@update_payment');

    //Update Detail
    Route::get('/invoice_detail/update/{id}','InvoiceController@update_detail');

    //Get Invoice by between date
    Route::post('invoice-get-by-date','InvoiceController@get_data_by_date')->name('invoice.get_data_by_date');

    //Get Invoice by pagination
    Route::get('invoice/pagination/{page}','InvoiceController@pagination');

    //Invoice Export Excel
    Route::get('invoice/export/{id}','InvoiceController@export_invoice');

    //invoice End

    // Product Start
    Route::get('/products/{val1?}/{val2?}/{val3?}','ProductController@index');
    Route::get('/product/create/{pro_name?}','ProductController@create');
    Route::post('/product/store','ProductController@store')->name('store.product');
    Route::get('/product/update/{id}','ProductController@update');
    Route::get('/product_detail/update/{id}','ProductController@update_detail');
    Route::post('/product/save-update','ProductController@save_update')->name('save_update.product');
    Route::post('/product/delete','ProductController@delete')->name('master_delete.product');

    Route::post('/product/delete','ProductController@delete')->name('master_delete.product');

    // Server Side
    Route::post('/product/get_data', 'ProductController@get_data')->name('product.get_data');

    //Product Detail
    Route::post('/product_detail/store','ProductController@store_detail')->name('store_detail.product');
    Route::post('/product_detail/save-update','ProductController@save_update_detail')->name('save_update_detail.product');

    // Server Side
    Route::post('/product_detail/get_data', 'ProductController@get_data_detail')->name('product_detail.get_data');

    //Grand Total
    Route::get('/product_grand_total/{id}','ProductController@grand_total');

    //Filter Date
    Route::post('/product/get_data_filter_date', 'ProductController@get_data_filter_date')->name('product.get_data_filter_date');

    //Get Product by ID
    Route::get('get-product/{id}', 'ProductController@get_product');

    // product name
    Route::post('/product-code-part-validate','ProductController@code_part_validate')->name('product.code_part_validate');

    //Product End

    //Product Category Start
    Route::get('/product-use-for','ProductUseForController@index');
    Route::get('/product-use-for/create','ProductUseForController@create');
    Route::post('/product-use-for/store','ProductUseForController@store')->name('store.product_use_for');
    Route::get('/product-use-for/update/{id}','ProductUseForController@update');
    Route::post('/product-use-for/save-update','ProductUseForController@save_update')->name('save_update.product_use_for');
    Route::post('/product-use-for/delete','ProductUseForController@delete')->name('master_delete.product_use_for');

    Route::post('/product-use-for-name-validate','ProductUseForController@use_for_name_validate')->name('use_for.name_validate');


    // Server Side
    Route::post('/product-use-for/get_data', 'ProductUseForController@get_data')->name('product_use_for.get_data');

    //Product Category End

    //Product Model Start
    Route::get('/product-models','ProductModelController@index');
    Route::get('/product-model/create','ProductModelController@create');
    Route::post('/product-model/store','ProductModelController@store')->name('store.product_model');
    Route::get('/product-model/update/{id}','ProductModelController@update');
    Route::post('/product-model/save-update','ProductModelController@save_update')->name('save_update.product_model');
    Route::post('/product-model/delete','ProductModelController@delete')->name('master_delete.product_model');

//    Server Side
    Route::post('/product-model/get_data', 'ProductModelController@get_data')->name('product_model.get_data');

    //Product Model End

    //Supplier Start
    Route::get('/suppliers','SupplierController@index');
    Route::get('/supplier/create','SupplierController@create');
    Route::post('/supplier/store','SupplierController@store')->name('store.supplier');
    Route::get('/supplier/update/{id}','SupplierController@update');
    Route::post('/supplier/save-update','SupplierController@save_update')->name('save_update.supplier');
    Route::post('/supplier/delete','SupplierController@delete')->name('master_delete.supplier');

    // supplier name validate

    Route::post('/supplier-name-validate','SupplierController@supplier_name_validate')->name('supplier.validate_name');

    //    Server Side
    Route::post('/supplier/get_data', 'SupplierController@get_data')->name('supplier.get_data');
    //  Supplier End

    //User Start
    Route::get('/users/{val1?}/{val2?}/{val3?}', 'UserController@index');
    Route::get('/user/create','UserController@create');
    Route::post('/user/store', 'UserController@store')->name('store.user');
    Route::get('/user/update/{id}','UserController@update');
    Route::post('/user/save-update','UserController@save_update')->name('save_update.user');

    Route::post('/users/status','UserController@status')->name('status.user');

    //All user
    Route::post('/all_users','UserController@all_users');

    // Server Side
    Route::post('/user/get_data', 'UserController@get_data')->name('user.get_data');

    //Role Start
    Route::get('/roles','RoleController@index');
    Route::get('/role/create','RoleController@create');
    Route::post('/role/store','RoleController@store')->name('store.role');
    Route::get('/role/update/{id}','RoleController@update');
    Route::post('/role/save-update','RoleController@save_update')->name('save_update.role');
    Route::post('/role/delete','RoleController@delete')->name('master_delete.role');

    //Server Side
    Route::post('/role/get_data', 'RoleController@get_data')->name('role.get_data');

    //Permission
    Route::post('/role/permission','RoleController@per')->name('role.per');
    //Role End

    //User End

    //Purchase Start

    Route::resource("purchases","PurchaseController");
    // Server Side
    Route::post('/purchases/get_data', 'PurchaseController@get_data')->name('purchase.get_data');
    Route::post('/purchases_detail/get_data', 'PurchaseController@get_data_detail')->name('purchase_detail.get_data');
    Route::post('/purchases_payment/get_data', 'PurchaseController@get_data_payment')->name('purchase_payment.get_data');
    Route::post('/purchases/get_data_filter_date', 'PurchaseController@get_data_filter_date')->name('purchase.get_data_filter_date');

    //Store Detail
    Route::post('/purchase_detail/store','PurchaseController@store_detail')->name('purchases.store_detail');
    Route::post('purchase/delete','PurchaseController@destroy')->name('master_delete.purchase');
    Route::post('/purchase_payment/delete','PurchaseController@delete_payment')->name('delete_payment.purchase');

    //Purchase Payment on add payment action
    Route::post('/purchase_payment_multi/store','PurchaseController@store_payment_multi')->name('store_payment_multi.purchase');
    //Purchase Payment
    Route::get('/purchase-detail/payment/{id}','PurchaseController@update_payment');
    //Purchase edit
    Route::get('/purchases/update/{id}','PurchaseController@edit');

    //Edit Detail
    Route::get('/purchase_detail/update/{id}','PurchaseController@update_detail');
    //Update Detail
    Route::post('/purchase_detail/save-update','PurchaseController@save_update_detail')->name('save_update_detail.purchase');
    //Check Product Qty
    Route::post('/purchase_product_qty/check','PurchaseController@check_product_qty')->name('purchase_product_qty.check');
    //Check Description
    Route::post('/purchase_des/check','PurchaseController@check_des')->name('purchase_des.check');
    //Submit Update
    Route::post('/purchase/save-update','PurchaseController@save_update')->name('save_update.purchase');
    //Purchase Payment on add new invoice
    Route::post('/purchase_payment/store','PurchaseController@store_payment')->name('store_payment.purchase');

    //Purchase End

    //Report Start

    //Payment Sell Report
    Route::get('/sell-payment-report','SellPaymentReportController@index');

    //Product Sell Report
    Route::get('/product-sell-report','ProductSellReportController@index');

    //Stock Report
    Route::get('/stock-report','StockReportController@index');
    // Server Side
    Route::post('/stock-report/get_data', 'StockReportController@get_data')->name('stock_report.get_data');
    //Print
    Route::get('/stock-report/print','StockReportController@get_print');
    //Expense Report
    Route::get('/expense-report','ExpenseReportController@index');
    // Server Side
    Route::post('/expense-report/get_data', 'ExpenseReportController@get_data')->name('expense_report.get_data');
    //Customer Report
    Route::get('/customer-report','CustomerReportController@index');
    // Server Side
    Route::post('/customer-report/get_data', 'CustomerReportController@get_data')->name('customer_report.get_data');

    //Invoice Representative Report
    Route::get('/invoices-report','InvoiceReportController@index');
    // Server Side
    Route::post('/invoices-report/get_data', 'InvoiceReportController@get_data')->name('invoice_rep_report.get_data');

    //Purchase Report

    Route::get('/purchase-report', 'PurchaseReportController@index')->name('purchase_report.get_data');
    Route::post('/purchase-report/get_data', 'PurchaseReportController@get_data')->name('purchase_report.get_data');
    //Report End
//  Out stock report
    Route::get('/out_stock-report', 'OutStockReportController@index');
    Route::post('/out_stock-report/get_data', 'OutStockReportController@get_data')->name('out_stock_report.get_data');
    Route::post('/out_stock_report/get_data_filter_date','OutStockReportController@get_data_filter_date')->name('out_stock_report.get_data_filter_date');
    //Out stock report Export Excel
    Route::get('/out_stock/export','OutStockReportController@export_out_stock_report');
    //Module Start
    Route::get('/module/all','RoleController@module');
    Route::get('/sub_module/all','RoleController@sub_module_all');
    Route::get('/sub_module/{module_id}','RoleController@sub_module');
    //Module End

    Route::get('/customer-services/export/english/{id}','CustomerController@exportCustomerDetail');
    Route::get('/customer-services/export/khmer/{id}','CustomerController@exportCustomerDetail');

    //Purchase print
    Route::get('/purchases/print/{id}','PurchaseController@print');


    //Repair Order Start
    Route::post('/repair-order/store','CustomerController@update_ro_no')->name('store.ro_no');

    //Repair Order End


    //Province  Start

    Route::get('/province','ProvinceController@index');
    Route::get('/province/create','ProvinceController@create');
    Route::post('/province/store','ProvinceController@store')->name('store.province');
    Route::get('/province/update/{id}','ProvinceController@update');
    Route::post('/province/save-update','ProvinceController@save_update')->name('save_update.province');
    Route::post('/province/delete','ProvinceController@delete')->name('master_delete.province');

  //Province End

    //Village Start
    Route::get('/village','VillageController@index');
    Route::get('/village/create','VillageController@create');
    Route::post('/village/store','VillageController@store')->name('store.village');
    Route::get('/village/update/{id}','ProvinceController@update');
    Route::post('/village/save-update','ProvinceController@save_update')->name('save_update.village');
    Route::post('/village/delete','ProvinceController@delete')->name('master_delete.village');

    //Village End

    //Language Start
    Route::get('/language','LanguageController@index');
    Route::get('/language/create','LanguageController@create');
    Route::post('/language/store','LanguageController@store')->name('store.Language');
    Route::get('/language/update/{id}','LanguageController@update');
    Route::post('/language/save-update','LanguageController@save_update')->name('save_update.Language');
    Route::post('/language/delete','LanguageController@delete')->name('master_delete.Language');

    //Language End


});
