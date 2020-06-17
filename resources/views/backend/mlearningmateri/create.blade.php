@extends('layouts/fulllayoutmaster')

@section('content')
    <div class="row gap-20 masonry pos-r">
        <div class="masonry-sizer col-md-6"></div>
        <form id="formStore" action="{{ route('mlearningmateri.store') }}">
        @csrf
        <div class="masonry-item col-md-6">
            <div class="bgc-white p-20 bd">
                <h6 class="c-grey-900">Create Materi</h6>
                <div class="mT-30">
                    <input type="hidden" name="kelas_mlearning_id" value="{{ $id }}">
                    <div class="form-group">
                        <label for="InputName">Judul</label> 
                        <input name="judul" type="text" class="form-control" id="InputName" placeholder="Enter Judul" />
                    </div>
                    <div class="form-group">
                        <label for="InputEmail">Isi Materi</label> 
                        <textarea rows="10" name="deskripsi" type="email" class="form-control" id="InputEmail1" placeholder="Enter isi materi"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
        <div class="masonry-item col-md-6">
            <div class="bgc-white p-20 bd">
                <h6 class="c-grey-900">Image Materi</h6>
                <img src="{{ asset('images/noimage.svg') }}" class="mb-3 avatar" height="300" width="200">
                <div class="custom-file mb-3">
                    <input type="file" class="custom-file-input file" id="customFile" name="image">
                    <label class="custom-file-label" for="customFile"  accept=".jpg, .jpeg, .png" style="max-width: 50%">Choose image</label>
                </div>
                <img src="{{ asset('images/noimage.svg') }}" class="mb-3 avatar2" height="300" width="200" >
                <div class="custom-file mb-3">
                    <input type="file" class="custom-file-input file2" id="customFile" name="image2">
                    <label class="custom-file-label" for="customFile"  accept=".jpg, .jpeg, .png" style="max-width: 50%">Choose image</label>
                </div>
                <img src="{{ asset('images/noimage.svg') }}" class="mb-3 avatar3" height="300" width="200">
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
                setTimeout(function() {
                    window.location.href = "{{route('mlearningmateri.index')}}/materi/ {{$id}}"
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