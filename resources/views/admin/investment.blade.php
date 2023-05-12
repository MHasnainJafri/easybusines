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

                                <h4 class="card-title mt-5">All Investments</h4>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr style="background-color: #fbf8f8; ">
                                            <td style="padding:20px;">Id</td>
                                            {{-- <td style="padding:20px;">Image</td> --}}

                                            <td style="padding:20px;">Amount</td>
                                            <td style="padding:20px;">user_Name</td>
                                                {{-- <td style="padding:20px;">Action</td> --}}

                                        </tr>

                                        @foreach ($investments as $investment)
                                            <tr align="center" style="background-color: black;">
                                                <td>{{ $investment->id }}</td>


                                                {{-- <td>{{ $investment->name }}</td> --}}
                                                <td>{{ $investment->amount }}</td>
                                                <td>{{ $investment->user->name }}</td>
                                               {{-- <td>   <div class="form-group">

                                                {{-- <input type="submit" class="btn btn-primary" value="Update"> --}}

                                                {{-- <a href="{{url('profit' ,$investment->id)}}" class="btn btn-primary">Add Profit</a>
                                            </div>  </td> --}}


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
