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
                        {{-- <span class="badge badge-sm badge-danger ms-3">New</span> --}}
                    </span>
                </a>
            </li>
            {{-- <li><a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="flaticon-381-television"></i>
                    <span class="nav-text">Class</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('class.index') }}">All Classes</a></li>
                </ul>
            </li> --}}
            <li><a class="ai-icon" href="{{ route('modeltest.index') }}">
                    <i class="flaticon-381-file"></i>
                    <span class="nav-text">Model Test
                        {{-- <span class="badge badge-sm badge-danger ms-3">New</span> --}}
                    </span>
                </a>
            </li>
            {{-- <li><a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="flaticon-381-controls-3"></i>
                    <span class="nav-text">Question</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('question.index') }}">Question List</a></li>
                </ul>
            </li> --}}
            {{-- <li><a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="flaticon-381-internet"></i>
                    <span class="nav-text">Question Choice</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('questionchoice.index') }}">Answer</a></li>
                </ul>
            </li> --}}
            <li>
                <a class="ai-icon" href="{{ route('requests.index') }}">
                    <i class="flaticon-381-heart"></i>
                    <span class="nav-text">Request</span>
                </a>
                {{-- <ul aria-expanded="false">
                    <li><a href="{{ route('answer.index') }}">Answer List</a></li>
                </ul> --}}
            </li>

        </ul>

        <div class="copyright">
            <p>© 2023 All Rights Reserved</p>
            <p>Made <a href="https://synexdigital.com"> by DexignZone</a></p>
        </div>
    </div>
</div>
