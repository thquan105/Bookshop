@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content pt-4">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Danh sách slide</h3>
                <a href="{{ route('admin.slides.create')}}" class="btn btn-success shadow-sm float-right"> <i class="fa fa-plus"></i> Thêm mới </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Thứ tự</th>
                        <th>Tiêu đề</th>
                        <th>Hình ảnh</th>
                        <th>Đổi thứ tự</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse ($slides as $slide)
                            <tr>    
                                <td>{{ $slide->position }}</td>
                                <td>{{ $slide->title }}</td>
                                <td><img width="200" src="{{ Storage::url($slide->path) }}" /></td>
                                <td>
                                    @if ($slide->prevSlide())
                                        <a href="{{ url('admin/slides/'. $slide->id .'/up') }}">lên</a>
                                    @else
                                        lên
                                    @endif
                                        | 
                                    @if ($slide->nextSlide())
                                        <a href="{{ url('admin/slides/'. $slide->id .'/down') }}">xuống</a>
                                    @else
                                        xuống
                                    @endif
                                </td>
                                <td>
                                @if ($slide->status == "active")
                                    <p>Hiển thị</p>
                                @else
                                    <p>Ẩn</p>
                                @endif
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.slides.edit', $slide) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form onclick="return confirm('Xác nhận?')" action="{{ route('admin.slides.destroy', $slide) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">Trống</td>
                            </tr>
                        @endforelse
                    </tbody>
                    </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('style-alt')
  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
@endpush

@push('script-alt') 
    <script
        src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
        crossorigin="anonymous"
    >
    </script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script>
    $("#data-table").DataTable();
    </script>
@endpush