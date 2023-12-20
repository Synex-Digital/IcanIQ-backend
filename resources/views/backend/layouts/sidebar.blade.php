<div class="deznav">
    <div class="deznav-scroll dz-scroll"
        style="display: flex;
    flex-direction: column;
    justify-content: space-between;">
        <ul class="metismenu" id="menu">
            <li><a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('panel-user.index') }}">Panel Users</a></li>
                </ul>
            </li>
            <li><a href="{{ route('student.index') }}">
                    <i class="flaticon-381-database-1"></i>
                    <span class="nav-text">Student
                    </span>
                </a>
            </li>
            <li><a class="ai-icon" href="{{ route('modeltest.index') }}">
                    <i class="flaticon-381-network"></i>
                    <span class="nav-text">Model Test
                    </span>
                </a>
            </li>
            <li>
                <a class="ai-icon" href="{{ route('requests.index') }}">
                    <i class="flaticon-381-television"></i>
                    <span class="nav-text">Request</span>
                </a>
                {{-- <ul aria-expanded="false">
                    <li><a href="{{ route('answer.index') }}">Answer List</a></li>
                </ul> --}}
            </li>
            <li>
                <a class="ai-icon" href="{{ route('performance.list') }}">
                    <i class="flaticon-381-settings-2"></i>
                    <span class="nav-text">Performance</span>
                </a>
            </li>

        </ul>

        <div class="copyright">
            <a href="{{ route('admin.logout') }}" class="dropdown-item ai-icon">
                <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18"
                    height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span class="ms-2">Logout </span>
            </a>
        </div>
    </div>
</div>
