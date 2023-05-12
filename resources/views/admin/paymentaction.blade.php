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


        <!-- partial -->

        <div class="container-fluid page-body-wrapper">

            <div class="container">


                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Verfiication</h4>
                            {{-- <p class="card-description"> Basic form layout </p> --}}
                            <form action="{{ url('verify , $data->id') }}" enctype="multipart/form-data" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Name</label>
                                    <input style="color: white;"  type="text" value="{{ $data->name }}" name="name"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    @if ($data->bank_account_number == 0)
                                        <label>EasyPaisa Account Number</label>
                                        <input style="color: white;"  name="easypaisa_account_number"
                                            value="{{ $data->easypaisa_account_number }}" class="form-control">
                                    @elseif ($data->easypaisa_account_number == 0)
                                        <label>Bank Account Number</label>
                                        <input style="color: white;"  name="bank_account_number" value="{{ $data->bank_account_number }}"
                                            class="form-control">
                                    @endif
                                </div>

                                <label>amount</label>
                                <input style="color: white;"  value="{{ $data->amount }}" name="amount" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <img width="200px" height="200px"
                                src="{{ asset('public/recipient/' . $data->recipient) }}">
                        </div>
                        <div class="form-group">
                            {{-- @dd($data->user->status); --}}
                            {{-- @if ($data->user->status != 0) --}}
                                <a href="{{ url('verify/' . $data->id) }}" class="btn btn-primary">Verify</a>
                                <a href="{{ url('reject/' . $data->id) }}" class="btn btn-primary me-2">Reject</a>

                        </div>


                        </form>
                    </div>
                </div>
            </div>


        </div>





        <!-- partial -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('Admin.js')
</body>

</html>
