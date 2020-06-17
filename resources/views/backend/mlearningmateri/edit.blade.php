@extends('layouts/fulllayoutmaster')

@section('content')
    <div class="row gap-20 masonry pos-r">
        <div class="masonry-sizer col-md-6"></div>
        <form id="formUpdate" action="{{ route('mlearningmateri.updatemateri', $id) }}">
            @csrf
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @method('PUT')
        <div class="masonry-item col-md-6">
            <div class="bgc-white p-20 bd">
                <h6 class="c-grey-900">Edit Materi</h6>
                <div class="mT-30">
                    <input type="hidden" name="kelas_mlearning_id" value="{{ $data['kelas_mlearning_id'] }}">
                    <div class="form-group">
                        <label for="InputName">Judul</label> 
                        <input name="judul" type="text" class="form-control" id="InputName" placeholder="Enter Judul" value="{{ $data['judul'] }}" />
                    </div>
                    <div class="form-group">
                        <label for="InputEmail">Isi Materi</label> 
                        <textarea rows="10" name="deskripsi" type="email" class="form-control" id="InputEmail1" placeholder="Enter isi materi">{{ $data['deskripsi'] }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
        <div class="masonry-item col-md-6">
            <div class="bgc-white p-20 bd">
                <h6 class="c-grey-900">Image Materi</h6>
                <img src="{{ $data->image != NULL ? asset("storage/images/original/$data->image")  : asset('images/noimage.svg') }}" class=" mb-3 avatar" height="200" width="200">
                <div class="custom-file mb-3">
                    <input type="file" class="custom-file-input file" id="customFile" name="image">
                    <label class="custom-file-label" for="customFile"  accept=".jpg, .jpeg, .png" style="max-width: 50%">Choose image</label>
                </div>
                <img src="{{ $data->image_2 != NULL ? asset("storage/images/original/$data->image_2")  : asset('images/noimage.svg') }}" class=" mb-3 avatar2" height="200" width="200">
                <div class="custom-file mb-3">
                    <input type="file" class="custom-file-input file2" id="customFile" name="image2">
                    <label class="custom-file-label" for="customFile"  accept=".jpg, .jpeg, .png" style="max-width: 50%">Choose image</label>
                </div>
                <img src="{{ $data->image_3 != NULL ? asset("storage/images/original/$data->image_3")  : asset('images/noimage.svg') }}" class=" mb-3 avatar3" height="200" width="200">
                <div class="custom-file mb-3">
                    <input type="file" class="custom-file-input file3" id="customFile" name="image3">
                    <label class="custom-file-label" for="customFile"  accept=".jpg, .jpeg, .png" style="max-width: 50%">Choose image</label>
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection
@section('javascript')
<script>
   $(document).ready(function(){
        function readURL(input, selector) {
            if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.'+selector).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
            }
        }

        $(".file").change(function() {
            readURL(this, 'avatar');
        });
        $(".file2").change(function() {
            readURL(this, 'avatar2');
        });
        $(".file3").change(function() {
            readURL(this, 'avatar3');
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
                setTimeout(function() {
                    window.location.href = "{{route('mlearningmateri.index')}}/materi/ {{$data['kelas_mlearning_id']}}"
                }, 3000);
                }else{
                $("[role='alertform']").css('display','block').html('');
                $.each( response.error, function( key, value ) {
                    $("[role='alertform']").append('<span style="display: block">'+value+'</span>');
                });
                toastr.error("Please complete your form",'Failed !');
                }
            },error: function(response){
                form.find("[type='submit']").prop('disabled', false).text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm");
                toastr.error("Please complete your form",'Failed !');
            }
            });
        });

    });
</script>
@endsection