@extends('template.template')

@section('content')
<div class="section-header">
    <h1>Data</h1>
    <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active"><a href="{{route('home')}}">Dashboard</a></div>
    <div class="breadcrumb-item"><a href="{{route('formtable.index')}}">Data</a></div>
    <div class="breadcrumb-item">Edit</div>
    </div>
</div>

<div class="section-body">
<div class="card">
    <form class="needs-validation" action="{{ route('formtable.update',$item->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-header">
        <h4>Tambah Data</h4>
    </div>
    <div class="card-body">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-2">
                    <label>Code</label>
                    <input type="text" class="form-control" name="code" id="code" value="{{$item->Code}}">
                </div>
                <div class="col-sm-2">
                    <label>Name</label>
                    <input type="text" class="form-control" name="nameinpt" id="nameinpt" value="{{$item->Name}}">
                </div>
                <div class="col-sm-2">
                    <label>Kategori</label>
                    <select name="kategori" id="kategori"  class="form-control select2">
                        <option value="">Pilih Data</option>
                        @foreach($kategori as $val)
                            @if($val->id==$item->id_category)
                                <option value="{{$val->id}}" selected>{{$val->name_kategori}}</option>
                            @else
                                <option value="{{$val->id}}">{{$val->name_kategori}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4">
                    <label>Image</label>
                    <img src="{{ url('public/Image/'.$item->xPicture) }}" style="height: 100px; width: 150px;">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label>Brand</label>
                    <input type="text" class="form-control" name="brand" id="brand" value="{{$item->Brand}}">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Upload Image</label>
            <input type="file" class="form-control" name="image" id="image">
        </div>
        <a class="btn btn-success" id="addBtn">add</a>
        <div class="form-group">
            <table class="table table-striped" id="table2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Qty</th>
                        <th>Action</th>
                    </tr>	
                </thead>
                <tbody id="bodytable2">
                    @foreach($itemUnit as $key => $val)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$val->name}}<input type="text" id="name[]" name="name[]" value="{{$val->name}}" class="form-control" hidden></td>
                            <th><input type="text" id="idput[]" name="idput[]" value="{{$val->Qty}}" class="form-control"></th>
                            <th><a class="btn btn-danger" onclick="deleteDetail({{$i}})"><i class="fa fa-times"></i></a></th>
                            <th hidden>{{$i++}}</th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-right">
        <a class="btn btn-secondary" href="{{ route('formtable.index') }}">Back</a>
        <button class="btn btn-primary">Submit</button>
    </div>
    </form>
</div>
</div>

@endsection

@push('modal_place')
<div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <table class="table table-striped" id="table1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>aksi</th>
                </tr>	
            </thead>
            <tbody>
                @foreach($list as $key => $val)
                    <tr>
                        <td>{{$j++}} <input type="text" id="name[]" name="name[]" value="{{$val->name}}" hidden></td>
                        <td>{{$val->name}}</td>
                        <th><input type="checkbox" id="check" name="checkbox"></th>
                        <th hidden><input type="text" id="idput[]" name="idput[]" class="form-control"></th>
                        <th hidden><a class="btn btn-danger" onclick="deleteDetail({{$i}})"><i class="fa fa-times"></i></a></th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="send();">Save</button>
        {{--<button type="button" class="btn btn-primary" onclick="validasi();">Show Data</button>--}}
        </div>
    </div>
    </div>
</div>
@endpush
@push('javascript')

<script>
    $('#addBtn').click(function(e) {
        $('#exampleModal').modal({backdrop: 'static', keyboard: false});
        $('#exampleModal').modal('show');
    });

    function send() {
        var table1 = document.getElementById("table1");
        var table2 = document.getElementById("table2");
        var xcheckbox = document.getElementsByName("checkbox");
        const arrayColumn = (arr, n) => arr.map((x) => x[n]);
        const table = Array.from(table2.querySelectorAll("tr"), (tr) =>
          Array.from(tr.querySelectorAll("td"), (td) => td.textContent)
        );
        // var datatable = arrayColumn(table, 0);
        var datatable = arrayColumn(table, 1);
        var arrayLength = datatable.length;
        // alert(datatable);
        // return;
        for (var i = 0; i < xcheckbox.length; i++) {
          if (xcheckbox[i].checked) {
            for (var j = 0; j < arrayLength; j++) {
                // alert(table1.rows[i + 1].cells[1].innerHTML);
                // return;
              if (table1.rows[i + 1].cells[1].innerHTML === datatable[j]) {
                alert("data is already");
                   return false;
              }
            }
            var newRow = table2.insertRow(table2.length);
            var Cell1 = newRow.insertCell(0);
            var Cell2 = newRow.insertCell(1);
            var Cell3 = newRow.insertCell(2);
            var Cell4 = newRow.insertCell(3);
            var inputcol="<input type='text' id='inp' name='inp'>";
            Cell1.innerHTML = table1.rows[i + 1].cells[0].innerHTML;
            Cell2.innerHTML = table1.rows[i + 1].cells[1].innerHTML;
            Cell3.innerHTML = table1.rows[i + 1].cells[3].innerHTML;
            Cell4.innerHTML = table1.rows[i + 1].cells[4].innerHTML;
          }
        }
      }
    function deleteDetail(id){
        var table2 = document.getElementById("table2");
        var body2 = document.getElementById("bodytable2");
        const table = Array.from(table2.querySelectorAll("tr"), (tr) =>
          Array.from(tr.querySelectorAll("td"), (td) => td.textContent)
        );
        // body2.deleteRow(-1);
        // var row = document.getElementById(id);
        // table[id].remove();
        // var del=body2.rows[id];
        // alert(id);
        // alert(body2.rows.length);
        // alert(id);
        if (body2.rows.length<=1) {
            body2.deleteRow(0);
        }else{
            body2.deleteRow(id-1);
        }
        // del.deleteRow(del.rows.length);

    }
</script>
@endpush