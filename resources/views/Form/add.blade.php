@extends('template.template')

@section('content')
<div class="section-header">
    <h1>Divisi</h1>
    <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active"><a href="{{route('home')}}">Dashboard</a></div>
    <div class="breadcrumb-item"><a href="{{route('formtable.index')}}">Divisi</a></div>
    <div class="breadcrumb-item">Add</div>
    </div>
</div>

<div class="section-body">
<div class="card">
    <form class="needs-validation" action="{{ route('formtable.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-header">
        <h4>Tambah Divisi</h4>
    </div>
    <div class="card-body">
        <div class="form-group">
        <label>Upload Image</label>
        <input type="file" class="form-control" name="image" >
        </div>
        <div class="form-group">
            <label>Add Item</label><br>
            {{--<button id="LeftMove" class="btn btn-primary" style="float:left;">&laquo; left</button>--}}
            <a class="btn btn-success" id="addBtn">add</a>
        <table class="table table-striped" id="table2">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody id="body2" name="body2">
               
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
                        <td>{{$i++}}</td>
                        <td>{{$val->name}} <input type="text" id="name[{{$j}}]" name="name[{{$j}}]" value="{{$val->name}}" hidden></td>
                        <th><input type="checkbox" id="check" name="checkbox"></th>
                        <th hidden><input type="text" id="idput[{{$j}}]" name="idput[{{$j}}]" class="form-control"></th>
                        <th hidden>{{$j++}}</th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="send();">Save</button>
        <button type="button" class="btn btn-primary" onclick="validasi();">Show Data</button>
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
        var datatable = arrayColumn(table, 0);
        var arrayLength = datatable.length;

        for (var i = 0; i < xcheckbox.length; i++) {
          if (xcheckbox[i].checked) {
            for (var j = 0; j < arrayLength; j++) {
              if (table1.rows[i + 1].cells[0].innerHTML === datatable[j]) {
                alert("data is already");
                   return false;
              }
            }
            var newRow = table2.insertRow(table2.length);
            var Cell1 = newRow.insertCell(0);
            var Cell2 = newRow.insertCell(1);
            var Cell3 = newRow.insertCell(2);
            var inputcol="<input type='text' id='inp' name='inp'>";
            Cell1.innerHTML = table1.rows[i + 1].cells[0].innerHTML;
            Cell2.innerHTML = table1.rows[i + 1].cells[1].innerHTML;
            Cell3.innerHTML = table1.rows[i + 1].cells[3].innerHTML;
          }
        }
      }
</script>
@endpush