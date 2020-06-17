@extends('layouts/fulllayoutmaster')

@section('content')
<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Kelas M-Learning  / {{ $data['kelas']->user->name }} / {{ $data['kelas']->matapelajaran->nama_matapelajaran }}</h4>
    <div class="row bgc-white bd bdrs-3 p-20 mB-20">
        <div class="col-md-12">
            <div class="d-flex justify-content-between mb-3">
                <h4 class="c-grey-900">Siswa yang mengikuti materi</h4>
                <button title="Add" data-toggle="modal" data-target="#modalAdd" class="btn btn-primary ml-auto">Add</button>
            </div>
        </div>
        @foreach ($data['siswa'] as $item)
            <div class="col-md-2">
                <div class="card m-5" style="width: 14rem;">
                    <img class="card-img-top" width="200" height="200" src="{{ $item->user->image != NULL ? asset("storage/images/original/". $item->user->image)  : asset('images/noimage.svg') }}" alt="Card image cap">
                    <div class="card-body">
                        <h6 class="card-title">{{ $item->user->name }}</h6>
                    {{-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> --}}
                    <a href="#" class="btn btn-outline-danger d-block" title="Delete" data-toggle="modal" data-target="#modalDelete" data-id="{{ $item->id }}"><i class="c-deep-blue-500 ti-trash"></i> Delete</a>
                    </div>
                </div>
            </div>  
        @endforeach
        <div class="col-md-12 mt-3 d-flex justify-content-center">
            {{ $data['siswa']->links() }}
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
        <form id="formStore" action="{{ route('mlearningsiswa.store') }}">
        <div class="modal-body">
            @csrf
            @if ($data['user_siswa']->count() > 0)                
            <div class="form-group">
                <input type="hidden" name="kelas_mlearning_id" value="{{ $data['kelas_mlearning_id'] }}">
                <label for="SelectSiswa">Nama Siswa</label>
                <select name="siswa_id" class="form-control" id="SelectSiswa">
                    @foreach ($data['user_siswa'] as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            @else
            <p>Siswa sudah terdaftar semua</p>
            @endif
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          @if ($data['user_siswa']->count() > 0)                
          <button type="submit" class="btn btn-primary">Submit</button>
          @endif
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
        $('#modalAdd').on('show.bs.modal', function (event) {
        });

        $('#modalAdd').on('show.bs.modal', function (event) {
        });

        $('#modalDelete').on('show.bs.modal', function (event) {
            var id      = $(event.relatedTarget).data('id');
            $(this).find('.modal-body').find('a[name="id"]').attr('href', '{{ route("mlearningsiswa.index") }}/'+ id);
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
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }else{
                    $("[role='alertform']").css('display','block').html('');
                    $.each( response.error, function( key, value ) {
                        $("[role='alertform']").append('<span style="display: block">'+value+'</span>');
                    });
                    toastr.error(response.message,'Failed !');
                }
            },
            error: function(response){
                form.find("[type='submit']").prop('disabled', false).text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm");
                $('#modalAdd').modal('hide');
                toastr.error("Please complete your form",'Failed !');
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
                    toastr.success(response.message,'Success !');
                    form.text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm").html(btnHtml);
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                    $('#modalDelete').modal('hide');
                },
                error: function (response) {
                    toastr.error(response.responseJSON.message ,'Failed !');
                    form.text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm").html(btnHtml);
                    $('#modalDelete').find('a[name="id"]').attr('href', '');
                }
            });
        });
    });
</script>
@endsection