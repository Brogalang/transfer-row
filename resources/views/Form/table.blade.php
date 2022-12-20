@extends('template.template')

@section('content')
<div class="section-header">
    <h1>Unit Kerja</h1>
    <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
    <div class="breadcrumb-item">Unit Kerja</a></div>
    </div>
</div>

<div class="section-body">
<!--Start main-->
    <div class="col-sm-2">
        <a href="{{ route('formtable.create') }}" class="btn btn-info">Tambah Data</a><br>
    </div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped" id="table-1">
        <thead>                                 
            <tr>
            <th class="text-left">No</th>
            <th>Code</th>
            <th>Name</th>
            <th>Kategori</th>
            <th>Brand</th>
            <th>Detail</th>
            <th>Image</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>        
        @foreach($item as $val)
        <tr>
            <td style="text-align:left">{{ ++$i }}</td>
            <td>{{$val->Code}}</td>
            <td>{{$val->Name}}</td>
            <td>{{$val->name_kategori}}</td>
            <td>{{$val->Brand}}</td>
            <td>
                @foreach($itemUnit as $key => $unit)
                @if($val->id==$unit->id_Project)
                    <table>
                        <tr>
                            <td>
                                {{$unit->name}}
                            </td>
                            <td>
                                =
                            </td>
                            <td>
                                {{$unit->Qty}}
                            </td>
                        </tr>
                    </table>
                @endif
                @endforeach
            </td>
            <td>
                <img src="{{ url('public/Image/'.$val->image) }}" style="height: 100px; width: 150px;">
            </td>
            
            <td>
                <form action="{{ route('formtable.destroy',$val->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                        <a class="btn btn-info" href="{{ route('formtable.edit',$val->id) }}" ><i class="fa fa-edit" title="Edit Data"></i></a>
                        <button type="submit" class="btn btn-danger")"><i class="fa fa-trash" title="Delete Data"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
        </table>
    </div>
    </div>
    {{--<div class="card-footer text-right">
    <nav class="d-inline-block">
        {{$divisi->links()}}
    </nav>
    </div>--}}
</div>
<!--End main-->
</div>

@endsection

{{--@push('javascript')
<!-- <script>
    function deletediv(idDiv) {
        alertify.confirm('Warning', 'Are you sure ??', 
        function(){ 
            alertify.success('Ok') 
            $.ajax({
                data: 'idDiv='+idDiv,
                url: "{{ route('deletediv') }}",
                type: "GET",
                datatype : "json",
                success: function(response) {
                    window.location.href = "divisi";
                },
                error: function(response) {
                }
            });
        }, function(){ 
            alertify.error('Cancel')
        })
    }
</script> -->
@endpush--}}