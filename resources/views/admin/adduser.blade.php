<!DOCTYPE html>
<html lang="en">

<head>
    @include('Admin.css')


    <style type="text/css">
        .title {
            color: white;
            padding-top: 25px;
            font-size: 25px;
        }
        label{
            display: inline-block;
    width: 200px;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        @include('Admin.sidebar')
        <!-- partial -->

        @include('Admin.navbar')


        <!-- partial -->

        <div class="container-fluid page-body-wrapper">

            <div class="container" >


                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">Add User</h4>
                        {{-- <p class="card-description"> Basic form layout </p> --}}
                        <form action="{{url('uploaduser')}}" enctype="multipart/form-data" method="post" >
                            @csrf
                          <div class="form-group">
                            <label>Username</label>
                            <input style="color: white;"  type="text" name="name" class="form-control" placeholder="Username">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input style="color: white;"  type="email" name="email" class="form-control" placeholder="Email">
                          </div>
                          <div class="form-group">
                            <label >Phone Number</label>
                            <input style="color: white;"  type="number" name="phonenumber" class="form-control" placeholder="phonenumber">
                          </div>
                          <div class="form-group">
                            <label >Image</label>
                            <input style="color: white;"  type="file" name="image" class="form-control" placeholder="image">
                          </div>

                          <button type="submit" class="btn btn-primary me-2">Submit</button>
                          <button class="btn btn-dark">Cancel</button>
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
        @include('Admin.js')
</body>

</html>



