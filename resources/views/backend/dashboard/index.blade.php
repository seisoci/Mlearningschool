@extends('layouts/fulllayoutmaster')

@section('content')
    <div class="container-fluid">
        <h4 class="c-grey-900 mT-10 mB-30">Dashboard</h4>
        <div class="row gap-20 masonry pos-r">
            <div class="masonry-sizer col-md-6"></div>
            <div class="masonry-item w-100">
               <div class="row gap-20">
                  <div class="col-md-3">
                     <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                           <h6 class="lh-1">Total Guru</h6>
                        </div>
                        <div class="layer w-100">
                           <div class="peers ai-sb fxw-nw">
                              <div class="peer peer-greed"><span id="sparklinedash"></span></div>
                            <div class="peer"><span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-green-50 c-green-500">{{ $data['count_guru'] }}</span></div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                           <h6 class="lh-1">Total Siswa</h6>
                        </div>
                        <div class="layer w-100">
                           <div class="peers ai-sb fxw-nw">
                              <div class="peer peer-greed"><span id="sparklinedash2"></span></div>
                              <div class="peer"><span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-red-50 c-red-500">{{ $data['count_siswa'] }}</span></div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                           <h6 class="lh-1">Total Kelas M-Learning</h6>
                        </div>
                        <div class="layer w-100">
                           <div class="peers ai-sb fxw-nw">
                              <div class="peer peer-greed"><span id="sparklinedash3"></span></div>
                              <div class="peer"><span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-purple-50 c-purple-500">{{ $data['count_kelas'] }}</span></div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                           <h6 class="lh-1">Total Materi M-Learning</h6>
                        </div>
                        <div class="layer w-100">
                           <div class="peers ai-sb fxw-nw">
                              <div class="peer peer-greed"><span id="sparklinedash4"></span></div>
                              <div class="peer"><span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-blue-50 c-blue-500">{{ $data['count_materi'] }}</span></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')

@endsection