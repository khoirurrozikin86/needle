<!-- partial:partials/_sidebar.html -->
<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            E -<span> NEEDLE</span>
        </a>
       
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>



            @if (Auth::user()->can('permission.menu'))
                <li class="nav-item nav-category">Role & Permission</li>
                <li class="nav-item {{ request()->is('*/permission') || request()->is('*/roles') ? 'active' : '' }}">
                    <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button"
                        aria-expanded="false" aria-controls="uiComponents">
                        <i class="link-icon" data-feather="feather"></i>
                        <span class="link-title">Role & Permission</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>

                    </a>
                    <div class="{{ request()->is('edit/permission/*') || request()->is('all/permission') || request()->is('add/permission') || request()->is('add/roles/permission') || request()->is('all/roles/permission') || request()->is('*/roles') || request()->is('admin/edit/roles/*') || request()->is('edit/roles/*') ? 'show' : 'collapse' }}"
                        id="uiComponents">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('all.permission') }}"
                                    class="nav-link {{ request()->is('all/permission') || request()->is('edit/permission/*') ? 'active' : '' }}">All
                                    Permission</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('all.roles') }}"
                                    class="nav-link {{ request()->is('*/roles') || request()->is('edit/roles/*') ? 'active' : '' }}">All
                                    Roles</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('add.roles.permission') }}"
                                    class="nav-link {{ request()->is('add/roles/permission') ? 'active' : '' }}">Add
                                    Role in Permission</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('all.roles.permission') }}"
                                    class="nav-link {{ request()->is('all/roles/permission') || request()->is('admin/edit/roles/*') ? 'active' : '' }}">All
                                    Role in Permission</a>
                            </li>

                        </ul>
                    </div>
                </li>
            @endif

            @if (Auth::user()->can('admin.menu'))
                <li class="nav-item {{ request()->is('admin') ? 'active' : '' }}">

                    <a class="nav-link" data-bs-toggle="collapse" href="#forms" role="button" aria-expanded="false"
                        aria-controls="forms">
                        <i class="link-icon" data-feather="inbox"></i>
                        <span class="link-title">Manage Admin</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>

                    <div class="{{ request()->is('*/admin') | request()->is('*/admin/*') ? 'show' : 'collapse' }}"
                        id="forms">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('all.admin') }}"
                                    class="nav-link {{ request()->is('*/admin') || 'edit/admin/*' ? 'active' : '' }}">All
                                    Admin</a>
                            </li>

                        </ul>
                    </div>
                </li>
            @endif


            <li class="nav-item nav-category">Master</li>

           

            @if (Auth::user()->can('employee.menu'))
                <li class="nav-item {{ request()->is('*/employee') ? 'active' : '' }}">
                    <a class="nav-link" data-bs-toggle="collapse" href="#emailsze" role="button"
                        aria-expanded="false" aria-controls="emailsze">
                        <i class="link-icon" data-feather="user"></i>
                        <span class="link-title">Employee</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="{{ request()->is('*/employee') || request()->is('*/employee/*') || request()->is('*/employee') ? 'show' : 'collapse' }}"
                        id="emailsze">
                        <ul class="nav sub-menu">


                            @if (Auth::user()->can('all.employee'))
                                <li class="nav-item">
                                    <a href="{{ route('all.employee') }}"
                                        class="nav-link {{ request()->is('all/employee') || request()->is('edit/employee/*') ? 'active' : '' }}">All
                                        Employee</a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </li>
            @endif

            

        
            <li class="nav-item nav-category">Transaction</li>
            {{-- @if (Auth::user()->can('Transaction.menu')) --}}
          
            <li class="nav-item {{ request()->is('*/transaction') ? 'active' : '' }}">
                <a class="nav-link" data-bs-toggle="collapse" href="#emailsyout" role="button" aria-expanded="false"
                    aria-controls="emailsyout">
                    <i class="link-icon" data-feather="check-circle"></i>
                    <span class="link-title">Transaction</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="{{ request()->is('*/transaction') || request()->is('*/transaction/*') || request()->is('*/transaction') ? 'show' : 'collapse' }}"
                    id="emailsyout">
                    <ul class="nav sub-menu">


                        @if (Auth::user()->can('transaction.menu'))
                            <li class="nav-item">
                                <a href="{{ route('add.transaction') }}"
                                    class="nav-link {{ request()->is('add/transaction') ? 'active' : '' }}">Add Trasaction IN</a>
                            </li>
                        @endif
                        @if (Auth::user()->can('transaction.menu'))
                            <li class="nav-item">
                                <a href="{{ route('add.transactionout') }}"
                                    class="nav-link {{ request()->is('add/transactionout') ? 'active' : '' }}">Add Trasaction OUT</a>
                            </li>
                        @endif
                        @if (Auth::user()->can('transaction.menu'))
                            <li class="nav-item">
                                <a href="{{ route('all.transaction') }}"
                                    class="nav-link {{ request()->is('all/transaction') ? 'active' : '' }}">All
                                    Transaction</a>
                            </li>
                        @endif

                    </ul>
                </div>
              
            </li>
           
        {{-- @endif --}}





        </ul>
    </div>
</nav>
