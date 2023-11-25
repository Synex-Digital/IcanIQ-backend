<div class="deznav">
    <div class="deznav-scroll dz-scroll">
        <ul class="metismenu" id="menu">
            <li><a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="index.html">Dashboard</a></li>
                    <li><a href="orders.html">Orders</a></li>
                    <li><a href="order-id.html">Order ID</a></li>
                    <li><a href="general-customers.html">General Customers</a></li>
                    <li><a href="analytics.html">Analytics</a></li>
                    <li><a href="reviews.html">Reviews</a></li>
                </ul>
            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="flaticon-381-television"></i>
                    <span class="nav-text">Class</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('class.index') }}">All Classes</a></li>
                </ul>
            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="flaticon-381-file"></i>
                    <span class="nav-text">Model Test
                        {{-- <span class="badge badge-sm badge-danger ms-3">New</span> --}}
                    </span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('modeltest.index') }}">Model Test List</a></li>                    
                </ul>
            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="flaticon-381-database-1"></i>
                    <span class="nav-text">Student
                        {{-- <span class="badge badge-sm badge-danger ms-3">New</span> --}}
                    </span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('student.index') }}">All Students List</a></li>
                </ul>
            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="flaticon-381-controls-3"></i>
                    <span class="nav-text">Question</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('question.index') }}">Question List</a></li>
                </ul>
            </li>
            {{-- <li><a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="flaticon-381-internet"></i>
                    <span class="nav-text">Question Choice</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('questionchoice.index') }}">Answer</a></li>
                </ul>
            </li> --}}
            <li><a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="flaticon-381-heart"></i>
                    <span class="nav-text">Answer</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('answer.index') }}">Answer List</a></li>
                </ul>
            </li>
            <li><a href="widget-basic.html" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-381-settings-2"></i>
                    <span class="nav-text">Widget</span>
                </a>
            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="flaticon-381-notepad"></i>
                    <span class="nav-text">Forms</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="form-element.html">Form Elements</a></li>
                    <li><a href="form-wizard.html">Wizard</a></li>
                    <li><a href="form-editor.html">Form Editor</a></li>
                    <li><a href="form-pickers.html">Pickers</a></li>
                    <li><a href="form-validation-jquery.html">Jquery Validate</a></li>
                </ul>
            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="flaticon-381-network"></i>
                    <span class="nav-text">Table</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="table-bootstrap-basic.html">Bootstrap</a></li>
                    <li><a href="table-datatable-basic.html">Datatable</a></li>
                </ul>
            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="flaticon-381-layer-1"></i>
                    <span class="nav-text">Pages</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="page-register.html">Register</a></li>
                    <li><a href="page-login.html">Login</a></li>
                    <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">Error</a>
                        <ul aria-expanded="false">
                            <li><a href="page-error-400.html">Error 400</a></li>
                            <li><a href="page-error-403.html">Error 403</a></li>
                            <li><a href="page-error-404.html">Error 404</a></li>
                            <li><a href="page-error-500.html">Error 500</a></li>
                            <li><a href="page-error-503.html">Error 503</a></li>
                        </ul>
                    </li>
                    <li><a href="page-lock-screen.html">Lock Screen</a></li>
                </ul>
            </li>
        </ul>
        <div class="add-menu-sidebar">
            <img src="{{ asset('backend') }}/images/food-serving.png" alt="/">
            <p class="mb-3">Organize your menus through button bellow</p>
            <span class="fs-12 d-block mb-3">Lorem ipsum dolor sit amet</span>
            <a href="javascript:void(0)" class="btn btn-secondary btn-rounded" data-bs-toggle="modal" data-bs-target="#addOrderModalside" >+Add Menus</a>
        </div>
        <div class="copyright">
            <p><strong>Sego Restaurant Admin Dashboard</strong> © 2023 All Rights Reserved</p>
            <p>Made with <span class="heart"></span> by DexignZone</p>
        </div>
    </div>
</div>