@extends('admin.layouts.main')
@section('title')
    Products
@endsection
@section('path')
    Admin
@endsection
@section('location')
    Products
@endsection
@section('content')
    <link rel="stylesheet" href="/mazer/dist/assets/extensions/filepond/filepond.css">
    <link rel="stylesheet"
        href="/mazer/dist/assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css">
    <link rel="stylesheet" href="/mazer/dist/assets/extensions/toastify-js/src/toastify.css">
    <link rel="stylesheet" href="/mazer/dist/assets/css/pages/filepond.css">

    @include('sweetalert::alert')
    <section class="row">
        <div class="col-12">
            @if (session()->has('success'))
                <div class="col-md-6">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">

                        </button>
                    </div>
                </div>
            @endif
            @if ($errors->any())
                <div class="col-md-6">

                    @foreach ($errors->all() as $err)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ $err }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">

                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
                Add Products
            </button>

            <div class="card">
                <div class="card-header">
                    Data Products
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th width="10px">No</th>
                                <th>Code</th>
                                <th width="30px">Name</th>
                                <th>Category</th>
                                <th>Stock</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr>

                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->code }}</td>
                                    <td>{{ $d->name }}</td>
                                    <td>{{ $d->categories->name }}</td>
                                    <td>{{ $d->stock }}</td>
                                    <td><img src="{{ asset('/storage/productsImg/' . $d->image) }}"
                                            alt="{{ $d->image }}" width="100px">
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $d->id }}"><i
                                                class="bi bi-pencil-fill"></i></button>
                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $d->id }}"><i
                                                class="bi bi-eye-fill"></i></button>
                                        <a href="/admin/products/{{ $d->code }}" class="btn btn-sm btn-danger"><i
                                                class="bi bi-trash-fill"></i></a>
                                    </td>
                                </tr>

                                <div class="modal fade" id="editModal{{ $d->id }}">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Products</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('edit.products') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" value="{{ $d->id }}" name="id"
                                                        id="">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Code</label>
                                                        <input type="text" name="code" class="form-control"
                                                            value="{{ $d->code }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Name</label>
                                                        <input type="text" name="name" class="form-control"
                                                            value="{{ $d->name }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Categories</label>
                                                        <select class="form-select" name="categories_id"
                                                            aria-label="Default select example">
                                                            <option value="{{ $d->categories_id }}">
                                                                {{ $d->categories->name }}</option>
                                                            @foreach ($cat as $c)
                                                                <option value="{{ $c->id }}">{{ $c->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Price</label>
                                                        <input type="number" name="price" class="form-control"
                                                            value="{{ $d->price }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Stock</label>
                                                        <input type="number" name="stock" class="form-control"
                                                            value="{{ $d->stock }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Description</label>
                                                        <textarea name="description" id="" class="form-control">{{ $d->description }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Image</label>
                                                        <input type="file" class="form-control" name="image">
                                                    </div>



                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

    </section>
    <script src="/mazer/dist/assets/extensions/filepond/filepond.js"></script>
    <script src="/mazer/dist/assets/extensions/toastify-js/src/toastify.js"></script>
    <script src="/mazer/dist/assets/js/pages/filepond.js"></script>
@endsection

<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Categories</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('add.products') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Code</label>
                                <input type="text" name="code" class="form-control"
                                    placeholder="Product Code">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="Products Name">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Categories</label>
                                <select class="form-select" name="categories_id" aria-label="Default select example">
                                    <option value="">Select Categories</option>
                                    @foreach ($cat as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Price</label>
                                <input type="number" name="price" class="form-control"
                                    placeholder="Product Price">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Stock</label>
                                <input type="number" name="stock" class="form-control"
                                    placeholder="Product Stock">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Description</label>
                                <textarea name="description" id="" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Image</label>
                        <input type="file" class="form-control" name="image">
                    </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
