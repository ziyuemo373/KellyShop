<?php

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency']], function () {
    Route::get('/', 'Customer\HomeController@index')->defaults('_config', [
        'view' => 'shop.home.index'
    ])->name('shop.home.index');

    //checkout and cart
    //Cart Items(listing)
    Route::get('checkout/cart', 'Customer\CartController@index')->defaults('_config', [
        'view' => 'shop.checkout.cart.index'
    ])->name('shop.checkout.cart.index');

    //Cart Items Add
    Route::post('checkout/cart/add/{id}', 'Customer\CartController@add')->defaults('_config',[
        'redirect' => 'shop.checkout.cart.index'
    ])->name('cart.add');

    //Cart Update Before Checkout
    Route::post('/checkout/cart', 'Customer\CartController@updateBeforeCheckout')->defaults('_config',[
        'redirect' => 'shop.checkout.cart.index'
    ])->name('shop.checkout.cart.update');

    //Cart Items Remove
    Route::get('/checkout/cart/remove/{id}', 'Customer\CartController@remove')->defaults('_config',[
        'redirect' => 'shop.checkout.cart.index'
    ])->name('shop.checkout.cart.remove');

    //Checkout Index page
    Route::get('/checkout/onepage', 'Customer\OnepageController@index')->defaults('_config', [
        'view' => 'shop.checkout.onepage'
    ])->name('shop.checkout.onepage.index');

    Route::post('/checkout/save-order', 'Customer\OnepageController@saveOrder')->name('shop.checkout.save-order');

    Route::get('/checkout/success', 'Customer\OnepageController@success')->defaults('_config', [
        'view' => 'shop.checkout.success'
    ])->name('shop.checkout.success');

    //customer routes starts here
    Route::prefix('customer')->group(function () {
        //pending: forgot Password Routes
        //pending: Forgot Password Form Show

        // Login Routes
        // Login form show
        Route::get('login', 'Customer\SessionController@show')->defaults('_config', [
            'view' => 'shop.customers.session.index',
        ])->name('customer.session.index');

        // Login form store
        Route::post('login', 'Customer\SessionController@create')->defaults('_config', [
            'redirect' => 'shop.home.index'
        ])->name('customer.session.create');

        // Registration Routes
        //registration form show
        Route::get('register', 'Customer\RegistrationController@show')->defaults('_config', [
            'view' => 'shop.customers.signup.index'
        ])->name('customer.register.index');

        //registration form store
        Route::post('register', 'Customer\RegistrationController@create')->defaults('_config', [
            'redirect' => 'customer.session.index',
        ])->name('customer.register.create');

        // Auth Routes
        Route::group(['middleware' => ['customer']], function () {

            //Customer logout
            Route::get('logout', 'Customer\SessionController@destroy')->defaults('_config', [
                'redirect' => 'customer.session.index'
            ])->name('customer.session.destroy');
        });
    });

    Route::get('/products/{id}', 'Customer\ProductController@index')->defaults('_config', [
        'view' => 'shop.products.view'
    ])->name('shop.products.index');

    Route::get('/test', 'TestController@index')->name('test.index');

    Route::get('/test/return', 'TestController@return')->name('test.return');

    Route::get('/test/notify', 'TestController@notify')->name('test.notify');
});

Route::group(['middleware' => ['web']], function () {
    Route::prefix('admin')->group(function () {

        Route::get('/', 'Admin\Controller@redirectToLogin');

        // Login Routes
        Route::get('/login', 'Admin\SessionController@create')->defaults('_config', [
            'view' => 'admin.admins.session.index'
        ])->name('admin.session.index');

        //login post route to admin auth controller
        Route::post('/login', 'Admin\SessionController@store')->defaults('_config', [
            'redirect' => 'admin.dashboard.index'
        ])->name('admin.session.store');

        // Admin Routes
        Route::group(['middleware' => ['admin']], function () {
            Route::get('/logout', 'Admin\SessionController@destroy')->defaults('_config', [
                'redirect' => 'admin.session.index'
            ])->name('admin.session.destroy');

            // Dashboard Route
            Route::get('dashboard', 'Admin\DashboardController@index')->defaults('_config', [
                'view' => 'admin.dashboard.index'
            ])->name('admin.dashboard.index');

            //Customers Management Routes
            Route::get('customers', 'Admin\CustomerController@index')->defaults('_config', [
                'view' => 'admin.customers.index'
            ])->name('admin.customer.index');

            Route::get('customers/edit/{id}', 'Admin\CustomerController@edit')->defaults('_config',[
                'view' => 'admin.customers.edit'
            ])->name('admin.customer.edit');

            Route::put('customers/edit/{id}', 'Admin\CustomerController@update')->defaults('_config', [
                'redirect' => 'admin.customer.index'
            ])->name('admin.customer.update');

            Route::get('customers/delete/{id}', 'Admin\CustomerController@destroy')
                ->name('admin.customer.delete');

            // Catalog Routes
            Route::prefix('catalog')->group(function () {

                // Catalog Product Routes
                Route::get('/products', 'Admin\ProductController@index')->defaults('_config', [
                    'view' => 'admin.catalog.products.index'
                ])->name('admin.catalog.products.index');

                Route::get('/products/create', 'Admin\ProductController@create')->defaults('_config', [
                    'view' => 'admin.catalog.products.create'
                ])->name('admin.catalog.products.create');

                Route::post('/products/create', 'Admin\ProductController@store')->defaults('_config', [
                    'redirect' => 'admin.catalog.products.index'
                ])->name('admin.catalog.products.store');

                //product delete
                Route::get('/products/delete/{id}', 'Admin\ProductController@destroy')->name('admin.catalog.products.delete');

                // Catalog Category Routes
                Route::get('/categories', 'Admin\CategoryController@index')->defaults('_config', [
                    'view' => 'admin.catalog.categories.index'
                ])->name('admin.catalog.categories.index');

                Route::get('/categories/create', 'Admin\CategoryController@create')->defaults('_config', [
                    'view' => 'admin.catalog.categories.create'
                ])->name('admin.catalog.categories.create');

                Route::post('/categories/create', 'Admin\CategoryController@store')->defaults('_config', [
                    'redirect' => 'admin.catalog.categories.index'
                ])->name('admin.catalog.categories.store');

                Route::get('/categories/edit/{id}', 'Admin\CategoryController@edit')->defaults('_config', [
                    'view' => 'admin.catalog.categories.edit'
                ])->name('admin.catalog.categories.edit');

                Route::put('/categories/edit/{id}', 'Admin\CategoryController@update')->defaults('_config', [
                    'redirect' => 'admin.catalog.categories.index'
                ])->name('admin.catalog.categories.update');

                Route::get('/categories/delete/{id}', 'Admin\CategoryController@destroy')->name('admin.catalog.categories.delete');

            });
        });
    });
});