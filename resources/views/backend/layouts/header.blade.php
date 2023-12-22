<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="dashboard_bar">
                        Dashboard
                    </div>
                </div>
                <ul class="navbar-nav header-right">
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown">
                            <img src="{{ asset('files/panelusers/' . Auth::guard('admin')->user()->profile) }}"
                                width="20" alt="/">
                            <div class="header-info">
                                <span
                                    class="text-black"><strong>{{ Auth::guard('admin')->user()->name }}</strong></span>
                                <p class="fs-12 mb-0">{{ Auth::guard('admin')->user()->role }}</p>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
