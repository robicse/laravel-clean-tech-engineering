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

/* artisan command */
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return 'cache clear';
});
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return 'config:cache';
});
Route::get('/view-cache', function() {
    $exitCode = Artisan::call('view:cache');
    return 'view:cache';
});
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return 'view:clear';
});
/* artisan command */


Route::get('/', function () {
    //return view('welcome');
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {
        Route::get('change-password/{id}','UserController@changedPassword')->name('password.change_password');
        Route::post ('change-password-update','UserController@changedPasswordUpdated')->name('password.change_password_update');

    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    Route::resource('stores','StoreController');
    Route::resource('stores','StoreController');
    Route::resource('productCategories','ProductCategoryController');
    Route::resource('productSubCategories','ProductSubCategoryController');
    Route::resource('productBrands','ProductBrandController');
    Route::resource('productUnits','ProductUnitController');
    Route::resource('products','ProductController');
    Route::resource('party','PartyController');
    Route::resource('productPurchases','ProductPurchaseController');
    Route::resource('productSales','ProductSaleController');
    Route::resource('productSaleReturns','ProductSaleReturnController');
    Route::resource('officeCostingCategory','OfficeCostingCategoryController');
    Route::resource('expenses','ExpenseController');
    Route::resource('productPurchaseRawMaterials','ProductPurchaseRawMaterialsController');
    Route::resource('productProductions','ProductProductionController');
    Route::resource('productSaleReplacement','ProductSaleReplacementController');
    Route::resource('service','ServiceController');

    Route::get('check-name','ServiceController@checkName');

    Route::get('productPurchases-invoice','ProductPurchaseController@invoice')->name('productPurchases-invoice');
    Route::get('productPurchases-invoice-print','ProductPurchaseController@invoicePrint')->name('productPurchases-invoice-print');
    Route::get('productSales-invoice/{id}','ProductSaleController@invoice')->name('productSales-invoice');
    Route::get('productSales-invoice-print/{id}','ProductSaleController@invoicePrint')->name('productSales-invoice-print');
    Route::get('productSales-invoice-edit/{id}','ProductSaleController@invoiceEdit')->name('productSales-invoice-edit');
    Route::post('productSales-invoice-update/{id}','ProductSaleController@updateInvoice')->name('productSales.invoiceUpdate');
    Route::get('sub-category-list','ProductController@subCategoryList');
    Route::get('check-barcode','ProductController@checkBarcode');
    Route::get('product-relation-data','ProductPurchaseController@productRelationData');
    Route::get('product-sale-relation-data','ProductSaleController@productSaleRelationData');
    Route::get('stock-list','StockController@stockList')->name('stock.index');
    Route::get('stock-summary-list','StockController@stockSummaryList')->name('stock.summary.list');
    Route::get('stock-low-list','StockController@stockLowList')->name('stock.low.list');

    Route::get('returnable-sale-product-list','ProductSaleReturnController@returnableSaleProduct')->name('returnable.sale.product');
    Route::post('sale-product-return','ProductSaleReturnController@saleProductReturn')->name('sale.product.return');
    Route::get('transaction-list','TransactionController@transactionList')->name('transaction.index');
    Route::get('transaction-loss-profit','TransactionController@lossProfit')->name('transaction.lossProfit');
    Route::get('delivery-list','TransactionController@deliveryList')->name('delivery.index');
    Route::post('party/new-party','ProductSaleController@newParty')->name('parties.store.new');
    Route::post('party/supplier/new-party','ProductPurchaseController@newParty')->name('parties.supplier.store.new');
    Route::post('pay-due','ProductSaleController@payDue')->name('pay.due');
    Route::get('productSales-customer-due','ProductSaleController@customerDue')->name('productSales.customer.due');
    Route::post('party/new-office-costing-category','ExpenseController@newOfficeCostingCategory')->name('office.costing.category.new');
    Route::get('product-production-relation-data','ProductProductionController@productProductionRelationData');




    Route::get('productPosSales/list','ProductPosSaleController@index')->name('productPosSales.index');
    Route::get('productPosSales','ProductPosSaleController@create')->name('productPosSales.create');
    Route::get('sale/{id}/data', 'ProductPosSaleController@listData')->name('sale.data');
    Route::get('sale/loadform/{discount}/{total}/{paid}', 'ProductPosSaleController@loadForm');

    Route::get('pos/print/{id}/{status}', 'PointOfSaleController@print')->name('pointOfSale.print');
    Route::get('pos/print_pos/{id}/{status}', 'PointOfSaleController@printPos')->name('pointOfSale.print2');

    Route::get('product-pos-sales-invoice/{id}/{status}','PointOfSaleController@invoicePos')->name('product.pos.sales-invoice');
    Route::get('product-pos-sales-invoice-print/{id}','PointOfSaleController@invoicePosPrint')->name('product.pos.Sales-invoice-print');


    Route::get('selectedform/{product_code}/{store_id}','ProductPosSaleController@selectedform');
    Route::get('add-to-cart','CartController@addToCart');
    Route::get('delete-cart-product/{rowId}','CartController@deleteCartProduct');
    Route::get('delete-all-cart-product','CartController@deleteAllCartProduct');
    Route::post('pos_insert', 'ProductPosSaleController@postInsert');


    Route::get('get-sale-product/{sale_id}','ProductSaleReplacementController@getSaleProduct');
    Route::get('get-returnable-product/{sale_id}','ProductSaleReturnController@getReturnableProduct');




    //excel
    Route::get('export', 'UserController@export')->name('export');
    Route::get('importExportView', 'ExportExcelController@importExportView');
    Route::post('import', 'ExportExcelController@import')->name('import');

    Route::get('transaction/export/', 'TransactionController@export')->name('transaction.export');
    Route::get('delivery/export/', 'TransactionController@deliveryExport')->name('delivery.export');
    Route::get('loss-profit/export/', 'TransactionController@lossProfitExport')->name('loss.profit.export');
    Route::get('loss-profit-filter-export/{start_date}/{end_date}','TransactionController@lossProfitExportFilter')->name('loss.profit.filter.export');
    Route::get('stock/export/', 'StockController@export')->name('stock.export');

    // custom start
    Route::post('/roles/permission','RoleController@create_permission');
    Route::post('/user/active','UserController@activeDeactive')->name('user.active');





    ///////////////////////////Account////////////////////////////////////////////



    Route::resource('voucherType','VoucherTypeController');
    Route::resource('posting','PostingController');

    //Route::post('pay-due','ServiceSaleController@payDue')->name('pay.due');

    Route::get('account/coa_print','AccountController@coa_print')->name('account.coa_print');
    Route::get('account/cashbook','AccountController@cash_book_form');
    Route::post('account/cashbook','AccountController@cash_book_form')->name('account.cashbook');
    Route::get('account/cashbook-print/{date_from}/{date_to}','AccountController@cash_book_print');

    //Route::get('account/voucher-invoice/{voucher_no}/{transaction_date}','TransactionController@voucher_invoice');
    Route::get('account/voucher-invoice/{voucher_type_id}/{voucher_no}','PostingController@voucher_invoice');
    Route::post('account/transaction-delete/{voucher_type_id}/{voucher_no}','PostingController@transactionDelete');
    Route::get('account/transaction-edit/{voucher_type_id}/{voucher_no}','PostingController@transactionEdit');
    Route::post('account/posting-update/{voucher_type_id}/{voucher_no}','PostingController@transactionUpdate');
    Route::get('account/generalledger','PostingController@general_ledger_form')->name('account.generalledger');
    Route::get('/get-transaction-head/{id}','AccountController@transaction_head');
    Route::post('account/general-ledger','PostingController@view_general_ledger')->name('account.general_ledger');
    Route::get('account/general-ledger-print/{headcode}/{date_from}/{date_to}','PostingController@general_ledger_print');
    Route::get('account/trial-balance','PostingController@trial_balance_form');
    Route::get('account/trial-balance-print/{date_from}/{date_to}','PostingController@trial_balance_print');
    Route::post('account/trial-balance','PostingController@view_trial_balance')->name('account.trial_balance');
    Route::get('account/balance-sheet','PostingController@balance_sheet');
    Route::get('account/balance-sheet-print','PostingController@balance_sheet_print');

    Route::get('account/debit-voucher','AccountController@debit_voucher_form')->name('account.debit.voucher');
    Route::post('account/debit-voucher','AccountController@view_debit_voucher')->name('account.debit_voucher');
    Route::get('account/debit-voucher-print/{headcode}/{date_from}/{date_to}','AccountController@debit_voucher_print');


    Route::get('account/credit-voucher','AccountController@credit_voucher_form')->name('account.credit.voucher');
    Route::post('account/credit-voucher','AccountController@view_credit_voucher')->name('account.credit_voucher');
    Route::get('account/credit-voucher-print/{headcode}/{date_from}/{date_to}','AccountController@credit_voucher_print');

    Route::resource('accounts','AccountController');
    Route::get('selectedform/{id}','AccountController@selectedform');
    Route::get('newform/{id}','AccountController@newform');
    Route::post('insert_coa','AccountController@insert_coa');


//relation-data

    Route::get('service-relation-data','ServiceSaleController@serviceRelationData');

    Route::get('employeeSalary-relation-data','EmployeeSalaryController@employeeSalaryRelationData');

    Route::get('get-voucher-no','PostingController@getVoucherNo');



});
