<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.css')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <div class="container-scroller">
        @include('admin.sidebar')
        <!-- partial -->

        @include('admin.navbar')



        <!-- partial -->
        <div style="padding-bottom:50px; " class="container-fluid page-body-wrapper">


            <div class="container" align="center">
                <div class="row ">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ url('/adduser') }}" class="btn btn-primary">Add User</a>
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <h4 class="card-title">Registered Users</h4>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr style="background-color: #fbf8f8; ">
                                            <td style="padding:20px;">Id</td>
                                            {{-- <td style="padding:20px;">Image</td> --}}
                                            <td style="padding:20px;">Name</td>
                                            <td style="padding:20px;">Email</td>
                                            <td style="padding:20px;">Phonenumber</td>
                                            <td style="padding:20px;">Amount</td>
                                            <td style="padding:20px;">Status</td>
                                            <td style="padding:20px;">Action</td>

                                        </tr>

                                        @foreach ($data as $user)
                                            <tr align="center" style="background-color: black;">
                                                <td>{{ $user->id }}</td>


                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phonenumber }}</td>
                                                <td>{{ $user->amount }}</td>
                                                <td>
                                                    @if ($user->status == 0)
                                                        <div class="badge badge-outline-success">Active</div>
                                                    @else
                                                        <div class="badge badge-outline-danger">Blocked</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="flex d-flex flex-column p-2">
                                                    @if ($user->status == 0)
                                                    <a href="{{url('block' ,$user->id)}}" class="badge badge-outline-danger btn me-2 mb-3">Block</a>
                                                @else
                                                <a href="{{url('unblock' ,$user->id)}}" class="badge badge-outline-success btn mb-3">unblock</a>

                                                @endif

                                                    <a class="btn btn-primary mb-3" href="{{url('show' ,$user->id)}}"> Update </a>


                                                    <a href="{{url('delete' ,$user->id)}}" class="btn btn-danger mb-3" href=""> Delete </a>
                                                    {{-- <td>   <div class="form-group"> --}}

                                                        {{-- <input type="submit" class="btn btn-primary" value="Update"> --}}

                                                        <a href="{{route('addprofit' ,$user->id)}}" class="btn btn-primary">Add Profit</a>

                                                    </div>
                                                </td>
                                </div>
                            </div>
                        </div>
                    </div>
                    </tr>
                    @endforeach
                    </table>
                    <!-- partial -->

                    <!-- container-scroller -->
                    <!-- plugins:js -->
                    <script>
                        setTimeout(function() {
                            $('.alert').fadeOut('slow');
                        }, 5000);
                    </script>

                    @include('admin.js')
</body>

</html>
