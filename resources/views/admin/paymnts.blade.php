<!DOCTYPE html>
<html lang="en">

<head>
    @include('Admin.css')

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
                    <div class="col-11 grid-margin">
                        <div class="card">
                            <div class="card-body">

                                {{-- @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif --}}
                                <h4 class="card-title">Payments</h4>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr style="background-color: #fbf8f8; ">
                                            <td style="padding:20px;">Id</td>
                                            <td style="padding:20px;">User Name</td>
                                            <td style="padding:20px;">Name</td>

                                            <td style="padding:20px;">
                                                Account info
                                            </td>



                                            <td style="padding:20px;">Amount</td>
                                            <td style="padding:20px;">Status</td>

                                            <td style="padding:20px;">Action</td>

                                        </tr>





                                        @foreach ($payments as $payment)
                                            <tr align="center" style="background-color: black;">
                                                <td>{{ $payment->id }}</td>
                                                <td>{{ $payment->name }}</td>
                                                <td>{{ $payment->user->name }}</td>
                                                <td>
                                                    @empty($payment->easypaisa_account_number)
                                                        {{ $payment->bank_account_number }}
                                                    @else
                                                        {{ $payment->easypaisa_account_number }}
                                                    @endempty

                                                </td>

                                                <td>{{ $payment->amount }}</td>
                                                <td>
                                                    @if ($payment->status == 0)
                                                        <div class="badge badge-outline-success">pending</div>
                                                    @elseif($payment->status == 1)
                                                        <div class="badge badge-outline-success">approved</div>
                                                    @elseif ($payment->status == 2)
                                                        <div class="badge badge-outline-danger">rejected</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($payment->status == '0' || $payment->status == '2')
                                                        <a class="btn btn-danger" href="{{ url('action', $payment->id) }}">View</a>
                                                    @else
                                                        <a class="btn btn-danger disabled" href="{{ url('action', $payment->id) }}">View</a>
                                                    @endif
                                                </td>


                                            </tr>
                                                @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                    </tr>
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
