@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Product List
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary float-right">
                    Create
                </a>
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Category</th>

                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->name }}</td>
                                <td>
                                    <span class="badge badge-success">{{ $product->category->name }}</span>
                                </td>

                                <td>{{ $product->price }}vnđ</td>
                                <td>{{ $product->quantity }}</td>
                                <td>
                                    @if (count($product->gallery) > 0)
                                        <a href="{{ $product->getMedia('gallery')->first()->getUrl() }}" target="_blank">
                                            <img src="{{ $product->getMedia('gallery')->first()->getUrl() }}" width="45px"
                                                height="45px" alt="">
                                        </a>
                                    @else
                                        <span class="badge badge-warning">No image</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-warning">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-info">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        <form onclick="return confirm('Are you sure ?');"
                                            action="{{ route('admin.products.destroy', $product->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger"><i
                                                    class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Trống !</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection



@push('style-alt')
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
@endpush

@push('script-alt')
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script>
        $("#data-table").DataTable();
    </script>
@endpush
