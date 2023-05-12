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

                                <div class="card-body">
                                    <h4 class="card-title">User Payment Histroy</h4>

                                    <div class="table-responsive">
                                      <table class="table table-dark">
                                        <thead>
                                          <tr>
                                            {{-- <th> # </th> --}}
                                            {{-- <th> First name </th> --}}
                                            <th> Amount </th>
                                            <th> Date </th>
                                          </tr>
                                        </thead>
                                    @foreach ($payments as $payment )


                                          <tr>
                                            {{-- <td> 1 </td>/ --}}
                                            <td> {{$payment->amount}} </td>
                                            <td> {{$payment->created_at}} </td>
                                          </tr>


                                          @endforeach
                                      </table>
                                    </div>
                                  </div>

                                  {{-- Investment histroy of this user --}}


                                  <div class="card-body">
                                    <h4 class="card-title">User Invetsment Histroy</h4>

                                    <div class="table-responsive">
                                      <table class="table table-dark">
                                        <thead>
                                          <tr>
                                            {{-- <th> Name </th> --}}
                                            {{-- <th> Name</th> --}}
                                            <th> Amount </th>
                                            <th> date </th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($investments as $investment )


                                          <tr>
                                            {{-- <td> Mansoor </td> --}}
                                            {{-- <td> Herman Beck </td> --}}
                                            <td>{{$investment->amount}}</td>
                                            <td> {{$investment->created_at}}</td>
                                          </tr>
                                          @endforeach


                                        </tbody>
                                      </table>
                                    </div>
                                  </div>



                                    {{-- Investment histroy of this user --}}


                                    <div class="card-body">
                                        <h4 class="card-title">User Profit Histroy</h4>

                                        <div class="table-responsive">
                                          <table class="table table-dark">
                                            <thead>
                                              <tr>
                                                {{-- <th> Name </th> --}}
                                                {{-- <th> Name</th> --}}
                                                <th> Profit </th>
                                                <th> date </th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($profit as $value )


                                              <tr>
                                                {{-- <td> Mansoor </td> --}}
                                                {{-- <td> Herman Beck </td> --}}
                                                <td>{{$value->amount}}</td>
                                                <td> {{$value->created_at}}</td>
                                              </tr>
                                              @endforeach


                                            </tbody>
                                          </table>
                                        </div>
                                      </div>





                                  <div class="col-md-6 grid-margin stretch-card">
                                    <div class="card">
                                      <div class="card-body">
                                        <h4 class="card-title">Add Profit</h4>

                                        <form class="forms-sample" action="{{ url('userprofit', $id) }}" method="POST">
                                          @csrf
                                          <div class="form-group">
                                            <label>Amount</label>
                                            <input class="form-control" style="color: white;" type="number" name="amount">
                                          </div>
                                          {{-- <input type="hidden" name="user_id" value="{{ $user->id }}"> --}}

                                          <button type="submit" class="btn btn-primary me-2">Submit</button>
                                          <a href="{{ route('allusers') }}" class="btn btn-dark">Cancel</a>
                                        </form>
                                      </div>
                                    </div>
                                  </div>













                                  {{--  --}}
                                </div>
                            </div>
                        </div>
                    </div>
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
