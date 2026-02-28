@extends('layouts.layout')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Home</a>
    <span>›</span>
    <a href="{{ route('settings.index') }}">Settings</a>
    <span>›</span>
    <a href="{{ route('settings.security_settings.index') }}">Security Settings</a>
    <span>›</span>
    <span>Create User</span>
@endsection

@section('title', 'security_settings')
@section('content')
    {{-- <h1>  Settings</h1> --}}

    {{-- Top filter option start --}}
    <div class="row justify-content-center">

        <div class="col-12 col-md-8 col-lg-6 d-flex justify-content-center">

            <div class="card filter-card mb-4 p-4 w-100" style="max-width: 500px;">

                <div class="fw-semibold dashboard-home p-2 text-center">
                    Filter Option
                </div>
                <hr>

                <form method="GET" action="">

                    <!-- Employee Name -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Employee Name</label>
                        <input type="text" name="name" value="{{ request('name') }}" class="form-control"
                            placeholder="Enter employee name">
                    </div>

                    <!-- Status -->
                    <div class="text-center mb-4">


                        <div class="status-group justify-content-center">

                            <label class="form-label fw-semibold d-block mb-3">Status</label>

                            <label class="status-option">
                                <input type="radio" name="status" value="all"
                                    {{ request('status', 'all') == 'all' ? 'checked' : '' }}>
                                <span>All</span>
                            </label>

                            <label class="status-option">
                                <input type="radio" name="status" value="active"
                                    {{ request('status') == 'active' ? 'checked' : '' }}>
                                <span>Active</span>
                            </label>

                            <label class="status-option">
                                <input type="radio" name="status" value="inactive"
                                    {{ request('status') == 'inactive' ? 'checked' : '' }}>
                                <span>Inactive</span>
                            </label>

                        </div>
                    </div>

                    <!-- Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-success px-3">
                            <i class="bi bi-search me-1"></i> Filter
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    {{-- Top filter option end --}}





    <div class=" ">


        <!-- FILTER + CREATE --> 
        <div class="card">
            <div class="top-bar">

                <div class="filter">
                    <form method="GET">
                        <input type="text" name="employee_name" placeholder="Employee Name">
                        <button class="btn btn-primary">Search</button>
                        <label><input type="radio" name="status" value=""> All</label>
                        <label><input type="radio" name="status" value="active"> Active</label>
                        <label><input type="radio" name="status" value="inactive"> Inactive</label>

                        <br><br>

                    </form>
                </div>

                <button class="btn btn-success" onclick="openModal()">+ Create User</button>

            </div>
        </div>

        <!-- TABLE -->
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Full Name</th>
                        <th>Employee Name</th>
                        <th>Employee ID</th>
                        <th>Active</th>
                        <th>Super Admin</th>
                    </tr>
                </thead>
                <tbody>


                    <tr>
                        <td>hospital@gmail.com</td>
                        <td>Susmita</td>
                        <td>Susmita Debnath</td>
                        <td>emp88909</td>
                        <td>Y</td>
                        <td>Y</td>
                    </tr>
                    {{-- @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->employee_name }}</td>
                            <td>{{ $user->employee_id }}</td>

                            <td>
                                @if ($user->active)
                                    <span class="badge active">Active</span>
                                @else
                                    <span class="badge inactive">Inactive</span>
                                @endif
                            </td>

                            <td>
                                @if ($user->is_super_admin)
                                    <span class="badge super">Yes</span>
                                @else
                                    <span class="badge normal">No</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>


    </div>

    <!-- MODAL -->

    <div class="modal" id="modal">
        <div class="modal-box">
            <h3>Create User</h3>
            {{-- {{ route('users.store') }} --}}

            <form method="POST" action="">
                @csrf

                <input type="text" name="full_name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="text" name="employee_name" placeholder="Employee Name">
                <input type="text" name="employee_id" placeholder="Employee ID">

                <label><input type="checkbox" name="active" value="1"> Active</label><br>
                <label><input type="checkbox" name="is_super_admin" value="1"> Super Admin</label><br><br>

                <button class="btn btn-success">Save</button>
                <button type="button" class="btn btn-primary" onclick="closeModal()">Cancel</button>
            </form>
        </div>


        <script>
            function openModal() {
                document.getElementById('modal').style.display = 'block';
            }

            function closeModal() {
                document.getElementById('modal').style.display = 'none';
            }
        </script>




        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>



    @endsection
