 

 @extends('admin.layout.index')
 @section('content')
 <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Tin tức 
                            <small>Thêm</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-7" style="padding-bottom:120px">
                     @if(count($errors)>0)
                    <div class="alert alert-danger">
                      @foreach($errors->all() as $err)
                           {{$err}}<br>
                      @endforeach
                      </div>
                     @endif

                    @if(session('thongbao'))
                       <div class="alert alert-success">
                             {{session('thongbao')}}
                       </div>
                    @endif
                        <form action="admin/tintuc/them/{{$us->id}}" method="POST" enctype="multipart/form-data">
                         <input type="hidden" name="_token" value="{{csrf_token()}} " />
                            <div class="form-group">
                                <label>Thể loại</label>
                                <select class="form-control" id="TheLoai" >
                                @foreach($theloai as $tl)
                                    <option value="{{$tl->id}} ">{{$tl->Ten}}  </option>
                                @endforeach 
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Loại tin </label>
                                <select class="form-control" name="LoaiTin" id="LoaiTin" >
                                @foreach($loaitin as $lt)
                                    <option value="{{$lt->id}} ">{{$lt->Ten}}  </option>
                                @endforeach 
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tiêu đề </label>
                                <input class="form-control" name="TieuDe" placeholder="Nhập Tiêu đề" />
                            </div>
                            <div class="form-group">
                                <label> Tóm tắt</label>
                                <textarea class="form-control ckeditor" id="demo" rows="3" name="TomTat"></textarea>
                            </div>
                            <div class="form-group">
                                <label>  Nội dung</label>
                                <textarea class="form-control ckeditor" id="demo" rows="5" name="NoiDung"></textarea>
                            </div>
                            <div class="form-group">
                              <label> Hình ảnh</label>
                              <input type="file" name="Hinh" class="form-control">                               
                            </div>
                            <div>
                                <label> Nổi bật</label>
                                <label class="radio-inline">
                                    <input type="radio" name="NoiBat" value="1" checked=""> Có
                                </label>
                                 <label class="radio-inline">
                                    <input type="radio" name="NoiBat" value="0"> Không
                                </label>
                                

                            </div>
                            <button type="submit" class="btn btn-default">Thêm</button>
                            <button type="reset" class="btn btn-default"> Làm mới</button>
                        <form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
 </div>
 @endsection

@section('script')
  <script type="text/javascript" src="a.js"></script>
       <script>
    $(document).ready(function() {
       $("#TheLoai").change(function(){
         var idTheLoai = $(this).val();
         $.get("ajax/loaitin/"+idTheLoai,function(data){
            $("#LoaiTin").html(data);
         });
         });

       });
    </script>
    @endsection