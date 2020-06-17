@extends('layouts/fulllayoutmaster')

@section('content')
    <div class="container-fluid">
        <h4 class="c-grey-900 mT-10 mB-30">Kelas M-Learning Tables</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="c-grey-900">Kelas M-Learning Data Table</h4>
                        <button title="Add" data-toggle="modal" data-target="#modalAdd" class="btn btn-primary ml-auto">Add</button>
                    </div>
                    <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Nama Guru</th>
                                <th>Kelas</th>
                                <th>Matapelajaran</th>
                                <th>Jurusan</th>
                                <th>Tahun</th>
                                <th>Create at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nama Guru</th>
                                <th>Kelas</th>
                                <th>Matapelajaran</th>
                                <th>Jurusan</th>
                                <th>Tahun</th>
                                <th>Create at</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal --}}
    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formStore" action="{{ route('mlearning.store') }}">
            <div class="modal-body">
                @csrf
                @if (Auth::user()->role == 'admin')           
                <div class="form-group">
                    <label for="Selectguru">Nama Guru</label>
                    <select name="guru_id" class="form-control" id="Selectguru">
                        @foreach ($data['guru'] as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="form-group">
                    <label for="Selectkelas">Kelas</label>
                    <select name="kelas_id" class="form-control" id="Selectkelas">
                        @foreach ($data['kelas'] as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="Selectmatapelajaran">Matapelajaran</label>
                    <select name="matapelajaran_id" class="form-control" id="Selectmatapelajaran">
                        @foreach ($data['matapelajaran'] as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_matapelajaran }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="Selectjurusan">Jurusan</label>
                    <select name="jurusan" class="form-control" id="Selectjurusan">
                        <option value="" selected>None</option>
                        <option value="ipa">IPA</option>
                        <option value="ips">IPS</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tahun">Tahun Ajaran</label>
                    <input type="number" class="form-control" id="tahun" name="tahun" placeholder="Tahun Ajaran">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
          </div>
        </div>
    </div>
    <div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formUpdate" action="">
            <div class="modal-body">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="Selectguru">Nama Guru</label>
                    <select name="guru_id" class="form-control guru_id" id="Selectguru">
                        @foreach ($data['guru'] as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="Selectkelas">Kelas</label>
                    <select name="kelas_id" class="form-control kelas_id" id="Selectkelas">
                        @foreach ($data['kelas'] as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="Selectmatapelajaran">Matapelajaran</label>
                    <select name="matapelajaran_id" class="form-control matapelajaran_id" id="Selectmatapelajaran">
                        @foreach ($data['matapelajaran'] as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_matapelajaran }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="Selectjurusan">Jurusan</label>
                    <select name="jurusan" class="form-control jurusan" id="Selectjurusan">
                        <option value="" selected>None</option>
                        <option value="ipa">IPA</option>
                        <option value="ips">IPS</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tahun">Tahun Ajaran</label>
                    <input type="number" class="form-control tahun" id="tahun" name="tahun" placeholder="Tahun Ajaran"">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
          </div>
        </div>
    </div>
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                @method('DELETE')
                <div class="modal-body">
                    <a href="" type="hidden" name="id" disabled></a>
                    <p>Are you sure you want to delete this item?</p>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button id="formDelete" type="button" class="btn btn-danger">Save</button>
            </div>
          </div>
        </div>
    </div>
@endsection
@section('javascript')
<script>
   $(document).ready(function(){
        var datatable = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            scrollX: true,
            ajax: {
                url: "{{ route('mlearning.datatable')}}",
                type: 'GET',
                data: function (d) {
                    d.guru = $('#guru').val();
                    d.user = $('#user').val();
                    d.kelas = $('#kelas').val();
                }
            },
            order: [[0, 'asc']],
            columns: [
                { data: 'user.name', name: 'id' },
                { data: 'kelas.nama_kelas', name: 'kelas.nama_kelas' },
                { data: 'matapelajaran.nama_matapelajaran', name: 'matapelajaran.nama_matapelajaran' },
                { data: 'jurusan', name: 'jurusan' },
                { data: 'tahun', name: 'tahun' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false },
            ],
        });

        $('#modalAdd').on('show.bs.modal', function (event) {
        });

        $('#modalAdd').on('show.bs.modal', function (event) {
            // $(this).find('.modal-body').find('input[name="nama_matapelajaran"]').val('');
        });

        $('#modalUpdate').on('show.bs.modal', function (event) {
            var id = $(event.relatedTarget).data('id');
            var guru_id = $(event.relatedTarget).data('guru_id');
            var kelas_id = $(event.relatedTarget).data('kelas_id');
            var matapelajaran_id = $(event.relatedTarget).data('matapelajaran_id');
            var jurusan = $(event.relatedTarget).data('jurusan');
            var tahun = $(event.relatedTarget).data('tahun');

            $(".guru_id").val(guru_id);
            $(".kelas_id").val(kelas_id);
            $(".matapelajaran_id").val(matapelajaran_id);
            $(".jurusan").val(jurusan);
            $(".tahun").val(tahun);
            
            $(this).find('#formUpdate').attr('action', '{{ route("mlearning.index") }}/'+ id);
            // $(this).find('.modal-body').find('input[name="nama_matapelajaran"]').val(nama_matapelajaran);
        });

        $('#modalUpdate').on('hidden.bs.modal', function (event) {
            $(this).find('#formUpdate').attr('action', '');
            $(this).find('.modal-body').find('a[name="id"]').attr('href', '');
        });

        $('#modalDelete').on('show.bs.modal', function (event) {
            var id      = $(event.relatedTarget).data('id');
            $(this).find('.modal-body').find('a[name="id"]').attr('href', '{{ route("mlearning.index") }}/'+ id);
        });

        $('#modalDelete').on('hidden.bs.modal', function (event) {
            $(this).find('.modal-body').find('a[name="id"]').attr('href', '');
        });

        $("#formStore").submit(function(e){
            e.preventDefault();
            var form 	= $(this);
            var btnHtml = form.find("[type='submit']").html();
            var spinner = $('<span role="status" class="spinner-border spinner-border-sm" aria-hidden="true"></span>');
            var url 	= form.attr("action");
            var data 	= new FormData(this);
            $.ajax({
            beforeSend:function() {
                form.find("[type='submit']").prop('disabled', true).text(' Loading. . .').prepend(spinner);
            },
            cache: false,
            processData: false,
            contentType: false,
            type: "POST",
            url : url,
            data : data,
            success: function(response) {
                form.find("[type='submit']").prop('disabled', false).text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm");
                if ( response.status == "success" ){
                    toastr.success(response.message,'Success !');
                    $('#modalAdd').modal('hide');
                    datatable.draw();
                }else{
                    $("[role='alertform']").css('display','block').html('');
                    $.each( response.error, function( key, value ) {
                        $("[role='alertform']").append('<span style="display: block">'+value+'</span>');
                    });
                    datatable.draw();
                    toastr.error(response.message,'Failed !');
                }
            },
            error: function(response){
                form.find("[type='submit']").prop('disabled', false).text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm");
                $('#modalAdd').modal('hide');
                toastr.error("Please complete your form",'Failed !');
                datatable.draw();
            }
            });
        });

        $("#formUpdate").submit(function(e){
            e.preventDefault();
            var form 	  = $(this);
            var btnHtml = form.find("[type='submit']").html();
            var spinner = $('<span role="status" class="spinner-border spinner-border-sm" aria-hidden="true"></span>');
            var url 	  = form.attr("action");
            var data 	  = new FormData(this);
            $.ajax({
            beforeSend:function() {
                form.find("[type='submit']").prop('disabled', true).text(' Loading. . .').prepend(spinner);
            },
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            cache: false,
            processData: false,
            contentType: false,
            type: "POST",
            url : url,
            data : data,
            success: function(response) {
                form.find("[type='submit']").prop('disabled', false).text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm");
                if ( response.status == "success" ){
                    toastr.success(response.message,'Success !');
                    $('#modalUpdate').modal('hide');
                    datatable.draw();
                }else{
                    $("[role='alertform']").css('display','block').html('');
                    $.each( response.error, function( key, value ) {
                        $("[role='alertform']").append('<span style="display: block">'+value+'</span>');
                        $('#modalUpdate').modal('hide');
                        datatable.draw();
                    });
                    toastr.error("Please complete your form",'Failed !');
                }
            },
            error: function(response){
                form.find("[type='submit']").prop('disabled', false).text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm");
                toastr.error("Please complete your form",'Failed !');
                $('#modalUpdate').modal('hide');
                datatable.draw();
            }
            });
        });

        $("#formDelete").click(function(e){
            e.preventDefault();
            var form 	    = $(this);
            var url 	    = $('#modalDelete').find('a[name="id"]').attr('href');
            var btnHtml   = form.html();
            var _token    = "{{ csrf_token() }}";
            var spinner   = $('<span role="status" class="spinner-border spinner-border-sm" aria-hidden="true"></span>');
            $.ajax({
                beforeSend:function() {
                form.text(' Loading. . .').prepend(spinner);
                },
                type: 'DELETE',
                url: url,
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data   : {
                '_token':_token
                },
                success: function (response) {
                    form.text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm").html(btnHtml);
                    if ( response.status == "success" ){
                        toastr.success(response.message,'Success !');
                        $('#modalDelete').modal('hide');
                        datatable.draw();
                    }else{
                        $("[role='alertform']").css('display','block').html('');
                        $.each( response.error, function( key, value ) {
                            $("[role='alertform']").append('<span style="display: block">'+value+'</span>');
                            datatable.draw();
                        });
                        toastr.error("Please complete your form",'Failed !');
                    }
                },
                error: function (response) {
                    toastr.error(response.responseJSON.message ,'Failed !');
                    form.text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm").html(btnHtml);
                    $('#modalDelete').modal('hide');
                    $('#modalDelete').find('a[name="id"]').attr('href', '');
                }
            });
        });
    });
</script>
@endsection