<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/dashboard') }}" class="brand-link">
        <img src="{{ asset('assets-admin/dist/img/pages-makna-logo-2.webp') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">POS Project</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets-admin/dist/img/avatar2.png') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Azmira Khatun</a>
            </div>
        </div>

        <!-- Sidebar Search Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item menu-open">
                    <a href="{{ url('/dashboard') }}" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}"
                        href="{{ route('roles.index') }}">
                        Roles
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/users') }}" class="nav-link">
                        <i class="bi bi-people-fill"></i>
                        <p>Users</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/add-category') }}" class="nav-link">
                        <i class="bi bi-tags"></i>
                        <p>Category <span class="badge badge-info right">6</span></p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/sub-categories') }}" class="nav-link">
                        <i class="bi bi-tags"></i>
                        <p>Sub Category <span class="badge badge-info right">6</span></p>
                    </a>
                </li>



                <li class="nav-item">
                    <a href="{{ url('/product_units') }}" class="nav-link">
                        <i class="bi bi-cart-check-fill"></i>
                        <p>Product Units <span class="badge badge-info right">6</span></p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ url('/products') }}" class="nav-link">
                        <i class="bi bi-cart-check-fill"></i>
                        <p>Product</p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ route('damageProduct.index') }}" class="nav-link">
                        <i class="bi bi-people-fill"></i>
                        <p>Damage Products</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/vendors') }}" class="nav-link">
                        <i class="bi bi-person-heart"></i>
                        <p>Vendors</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('customerIndex') }}" class="nav-link">
                        <i class="bi bi-people-fill"></i>
                        <p>Customers</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('purchase.index') }}" class="nav-link">
                        <i class="bi bi-people-fill"></i>
                        <p>Purchase</p>
                    </a>
                </li>


<li class="nav-item">
                    <a href="{{ route('sales.index') }}" class="nav-link">
                        <i class="bi bi-people-fill"></i>
                        <p>Sales</p>
                    </a>
                </li>



<li class="nav-item">
                    <a href="{{ route('salesitems.index') }}" class="nav-link">
                        <i class="bi bi-people-fill"></i>
                        <p>Sale Items</p>
                    </a>
                </li>



<li class="nav-item">
                    <a href="{{ route('salesInvoiceIndex') }}" class="nav-link">
                        <i class="bi bi-people-fill"></i>
                        <p>Sale Invoices</p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ route('purchase_items.index') }}" class="nav-link">
                        <i class="bi bi-people-fill"></i>
                        <p>Purchase Items</p>
                    </a>
                </li>



                <li class="nav-item">
                    <a href="{{ route('purchaseReturns.index') }}" class="nav-link">
                        <i class="bi bi-people-fill"></i>
                        <p>Purchase returns</p>
                    </a>
                </li>




                <li class="nav-item">
                    <a class="nav-link" href="{{ route('purchase_returns.index') }}">
                        Purchase Returns
                    </a>
                </li>


 <li class="nav-item">
                    <a class="nav-link" href="{{ route('purchaseInvoices.index') }}">
                        Purchase Invoice
                    </a>
                </li>





                <li class="nav-item">
                    <a href="{{ route('paymentMethodIndex') }}" class="nav-link">
                        <i class="bi bi-credit-card-2-front-fill"></i> <!-- Bootstrap Icons -->
                        <span>Payment Methods</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ route('discounts.index') }}" class="nav-link">
                        <i class="bi bi-credit-card-2-front-fill"></i> <!-- Bootstrap Icons -->
                        <span>Discounts</span>
                    </a>
                </li>





 <li class="nav-item">
                    <a href="{{ route('payments.index') }}" class="nav-link">
                        <i class="bi bi-people-fill"></i>
                        <p>Payments</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('stocks.index') }}" class="nav-link">
                        <i class="bi bi-credit-card-2-front-fill"></i> <!-- Bootstrap Icons -->
                        <span>Stocks</span>
                    </a>
                </li>





                <li class="nav-item">
                    <a href="{{ route('expiredProductsIndex') }}" class="nav-link">
                        <i class="bi bi-credit-card-2-front-fill"></i> <!-- Bootstrap Icons -->
                        <span>Expired Product</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-warehouse"></i>
                        <p>Inventory <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ url('/expired-products') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Expired Products</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Reports <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="{{ url('/report/purchase') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>Purchase Report</a></li>
                        <li class="nav-item"><a href="{{ url('/report/sales') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>Sales Report</a></li>
                        <li class="nav-item"><a href="{{ url('/report/inventory') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>Inventory Report</a></li>
                        <li class="nav-item"><a href="{{ url('/report/profit-loss') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>Profit/Loss Report</a></li>
                        <li class="nav-item"><a href="{{ url('/report/customers') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>Customers Report</a></li>
                        <li class="nav-item"><a href="{{ url('/report/vendors') }}" class="nav-link"><i
                                    class="far fa-circle nav-icon"></i>Vendors Report</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
