<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.css')


</head>

<body>
    <div class="container-scroller">
        @include('admin.sidebar')
        <!-- partial -->

        @include('admin.navbar')

        <div class="container-fluid page-body-wrapper">

            <div class="container">


                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add User</h4>
                            {{-- <p class="card-description"> Basic form layout </p> --}}
                            <form action="{{ url('update', $user->id) }}" enctype="multipart/form-data" method="post">

                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                @csrf
                                <div class="form-group">
                                    <label>Username</label>
                                    <input value="{{ $user->name }}" name="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input value="{{ $user->email }}" name="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input value="{{ $user->phonenumber }}" name="phonenumber" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Balance</label>
                                    <input value="{{ $user->amount }}" name="amount" class="form-control">
                                </div>

                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Update">

                                     <a href="{{url('showusers')}}" class="btn btn-dark">Cancel</a>


                                </div>

                            </form>
                        </div>
                    </div>
                </div>


            </div>





            <!-- partial -->
        </div>
    </div>
        <!-- container-scroller -->
        <!-- plugins:js -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @include('Admin.js')
</body>

</html>
