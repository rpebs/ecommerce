@extends('admin.layouts.main')
@section('title')
    Product Stock
@endsection
@section('path')
    Admin
@endsection
@section('location')
    Product
@endsection
@section('content')
    @include('sweetalert::alert')
    <section class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    Add Product Stock
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-12">
                            <form action="{{ route('add.action') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <select name="code" id="code" class="form-select" onchange="auto()">
                                        <option value="">Select Product Code</option>
                                        @foreach ($data as $d)
                                            <option value="{{ $d->code }}">{{ $d->code }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Product Name</label>
                                    <input type="text" id="name" name="name" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Penambahan Stock</label>
                                    <input type="number" id="name" name="stock" class="form-control">
                                </div>
                                <input type="submit" class="btn btn-md btn-primary" value="Add">
                        </div>

                    </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
        crossorigin="anonymous"></script>
    <script type="text/javascript">
        function auto() {
            var code = $("#code").val();
            $.ajax({
                url: '/admin/addstock/fill/' + code,
                success: (function(data) {
                    var json = data,
                        obj = JSON.parse(json);
                    $('#name').val(obj.name);
                })

            });
        }

        $(document).ready(function() {

        });
    </script>
@endsection
