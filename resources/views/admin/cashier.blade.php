@extends('admin.layouts.main')
@section('title')
    Cashier
@endsection
@section('path')
    Admin
@endsection
@section('location')
    Cashier
@endsection
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
    @include('sweetalert::alert')
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Add Transaction
                </div>
                <div class="card-body">
                    <div class="row">


                        <div class="col-md-6">
                            <form action="#" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="" class="form-label">Transaction Code</label>
                                    <input type="text" id="transaction_code" name="transaction_code" class="form-control"
                                        value="{{ Str::random(8) }}">
                                </div>
                                {{-- <div class="mb-3">
                                    <label for="" class="form-label">Product Code</label>
                                    <select name="code" id="code" class="form-select" onchange="auto()">
                                        <option value="">Select Product Code</option>
                                        @foreach ($product as $d)
                                            <option value="{{ $d->code }}">{{ $d->code }}</option>
                                        @endforeach
                                    </select>

                                </div> --}}
                                <div class="mb-3">

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Search Product By code</label>
                                        <input type="text" id="code" name="code" class="form-control">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Product Id</label>
                                    <input type="number" id="id" name="products_id" class="form-control" disabled
                                        readonly>
                                </div>

                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Product Name</label>
                                <input type="text" id="name" name="name" class="form-control" disabled readonly>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Price</label>
                                <input type="number" id="price" name="price" class="form-control" disabled readonly>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Quantity</label>
                                <input type="number" id="qty" name="quantity" class="form-control">
                            </div>
                            <input type="submit" id="btn-submit" class="btn btn-md btn-primary" value="Add">
                        </div>

                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                List Belanja
                <div class="col-md-3 mt-3">
                    <label for="" class="form-label">Total</label>
                    <p id="subtotal"></p>
                    <input type="hidden" class="form-control " id="sub" name="subtotal" readonly>
                    <label for="" class="form-label">Bayar</label>
                    <input type="number" class="form-control mb-3 " id="bayar" name="bayar" onfocusout="hitung()">
                    <label for="" class="form-label">Kembalian</label>
                    <p id="kembalian"></p>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="tab">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
            </div>
        </div>

    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- ✅ load jQuery UI ✅ -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
        integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function hitung() {
            var total = $('#bayar').val() - $('#sub').val();
            console.log(total);
            //Convert to rupiah
            const rupiah = (number) => {
                return new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0
                }).format(number);
            }
            document.getElementById('kembalian').innerHTML = rupiah(total);
        }

        //Submit transaction Detail and Insert into table
        $("#btn-submit").click(function(e) {

            e.preventDefault();

            var transaction_code = $("input[name=transaction_code]").val();
            var products_id = $("input[name=products_id]").val();
            var price = $("input[name=price]").val();
            var quantity = $("input[name=quantity]").val();
            var url = "{{ route('add.transaction') }}";

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    transaction_code: transaction_code,
                    products_id: products_id,
                    price: price,
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {

                    } else {
                        alert("Error")
                    }
                },
                error: function(error) {
                    console.log(error)
                }
            });

            //Convert to rupiah
            const rupiah = (number) => {
                return new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0
                }).format(number);
            }

            var tcode = $("input[name=transaction_code]").val();
            $.ajax({
                url: '/admin/cashier/' + tcode,
                success: (function(data) {
                    var json = data,
                        obj = JSON.parse(json);
                    $("#tab > tbody").append("<tr><td>" + obj.no +
                        "</td><td>" + obj.id + "</td><td>" + obj.qty + "</td><td>" + rupiah(obj
                            .price) +
                        "</td><td><button class='btn btn-sm btn-danger' id='btndelete' data-id=  '" +
                        obj.code + "' data-product='" + obj.product_id +
                        "' onclick=''>Hapus</button></td></tr >"


                    );

                    $("#sub").val(obj.sub);
                    document.getElementById("subtotal").innerHTML = rupiah(obj.sub);
                })


            });
            $("#code").val('');
            $("#id").val('');
            $("#name").val('');
            $("#price").val('');
            $("#qty").val('');

        });




        //Auto Fill Form By Code Search
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function() {

            $("#code").autocomplete({
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('autocomplete') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    // Set selection
                    $('#code').val(ui.item.label); // display the selected text
                    $('#name').val(ui.item.value); // save selected id to input
                    $('#price').val(ui.item.price);
                    $('#id').val(ui.item.id);
                    return false;
                }
            });

        });


        $('body').on('click', '#btndelete', function() {
            const code = $(this).data('id');

            $.ajax({
                url: '{{ route('delete.transaction') }}',
                data: {
                    code: code,
                    product_id: $(this).data('product'),
                },
                type: 'DELETE',
                success: function(response) {
                    console.log(response.message);
                    $("#tab > tbody").html('');

                }
            });

            var tcode = $("input[name=transaction_code]").val();
            $.ajax({
                url: '/admin/cashier/' + tcode,
                success: (function(data) {


                    //Convert to rupiah
                    const rupiah = (number) => {
                        return new Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR",
                            minimumFractionDigits: 0
                        }).format(number);
                    }

                    var json = data,
                        obj = JSON.parse(json);
                    if (obj.id === undefined) {
                        $("#tab > tbody").html('');
                        $("#sub").val('');
                        document.getElementById("subtotal").innerHTML = '';
                    } else {

                        $("#tab > tbody").append("<tr><td>" + obj.no +
                            "</td><td>" + obj.id + "</td><td>" + obj.qty +
                            "</td><td>" + rupiah(obj
                                .price) +
                            "</td><td><button class='btn btn-sm btn-danger' id='btndelete' data-id=  '" +
                            obj.code + "' data-product='" + obj.product_id +
                            "' onclick=''>Hapus</button></td></tr >"
                        );
                        $("#sub").val(obj.sub);
                        document.getElementById("subtotal").innerHTML = rupiah(obj
                            .sub);
                    }



                })


            });
        });
    </script>
@endsection
