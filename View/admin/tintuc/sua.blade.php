 @extends('admin.layout.index')
 @section('content')
 <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Tin tức 
                            <small>{{$tintuc->TieuDe}} </small>
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
                        <form action="admin/tintuc/sua/{{$tintuc->id}}" method="POST" enctype="multipart/form-data">
                         <input type="hidden" name="_token" value="{{csrf_token()}} " />
                            <div class="form-group">
                                <label>Thể loại</label>
                                <select class="form-control" id="TheLoai" >
                                @foreach($theloai as $tl)
                                    <option 
                                    @if($tintuc->loaitin->theloai->id==$tl->id)
                                    {{"selected"}}
                                    @endif
                                    value="{{$tl->id}} ">{{$tl->Ten}}  </option>
                                @endforeach 
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Loại tin </label>
                                <select class="form-control" name="LoaiTin" id="LoaiTin" >
                                @foreach($loaitin as $lt)
                                    <option 
                                    @if($tintuc->loaitin->id==$lt->id)
                                    {{"selected"}}
                                    @endif
                                    value="{{$lt->id}} ">{{$lt->Ten}}  </option>
                                @endforeach 
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tiêu đề </label>
                                <input class="form-control" name="TieuDe" placeholder="Nhập Tiêu đề" value="{{$tintuc->TieuDe}} " />
                            </div>
                            <div class="form-group">
                                <label> Tóm tắt</label>
                                <textarea class="form-control ckeditor" id="demo" rows="3" name="TomTat" >{{$tintuc->TomTat}} </textarea>
                            </div>
                            <div class="form-group">
                                <label>  Nội dung</label>
                                <textarea class="form-control ckeditor" id="demo" rows="5" name="NoiDung">{{$tintuc->NoiDung}} </textarea>
                            </div>
                            <div class="form-group">
                              <label> Hình ảnh</label>
                              <p>
                                  <img width="400px" src="upload/tintuc/{{$tintuc->Hinh}}">

                              </p>
                              <input type="file" name="Hinh" class="form-control">                               
                            </div>
                            <div>
                                <label> Nổi bật</label>
                                <label class="radio-inline">
                                    <input type="radio" name="NoiBat" value="1" 
                                     @if($tintuc->NoiBat==1)
                                        {{"checked"}}
                                    @endif
                                    > Có
                                </label>
                                 <label class="radio-inline">
                                    <input type="radio" name="NoiBat" value="0"
                                    @if($tintuc->NoiBat==0)
                                        {{"checked"}}
                                    @endif
                                    
                                    > Không
                                </label>
                                

                            </div>
                            <button type="submit" class="btn btn-default">Sửa</button>
                            <button type="reset" class="btn btn-default"> Làm mới</button>
                        <form>
                    </div>
                </div>
                <!-- /.row -->



                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Tin tức
                            <small>Bình Luận</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                     @if(session('thongbao'))
                       <div class="alert alert-success">
                             {{session('thongbao')}}
                       </div>
                    @endif
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th> Người dùng</th>
                                <th> Nội dung</th>
                                <th> Ngày đăng </th>
                                <th> Xóa </th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($tintuc->comment as $cm)
                            <tr class="odd gradeX" align="center">
                                <td>{{$cm->id}} </td>
                                <td>{{$cm->user->name}}
                                 </td>
                                <td>{{$cm->NoiDung}} </td>
                                <td>{{$cm->created_at}} </td>
                                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/comment/xoa/{{$cm->id}}/{{$tintuc->id}}"> Xóa </a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!--endrow-->





                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Tin tức
                            <small>Report bài viết</small>
                        </h1>
                    </div>
                      @if(session('thongbao2'))
                       <div class="alert alert-success">
                             {{session('thongbao2')}}
                       </div>
                    @endif
                    <!-- /.col-lg-12 -->
                     @if(isset($arr))
                       <div style="color: red">
                          Có {{$arr[0]}} lượt report  Bài viết có thông tin không chính xác<br>{{$arr[1]}} lượt report Bài viết có nội dung trái pháp luật<br>{{$arr[2]}} lượt report Bài viết có hình ảnh phản cảm
                       </div>
                    @endif
                    <table class="table table-striped table-bordered table-hover" style="margin-top: 40px">
                        <thead>
                            <tr align="center">
                                <th> Người dùng</th>
                                <th> Nội dung</th>
                                <th> Ngày đăng </th>
                                <th> Xóa </th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($tintuc->report as $re)
                            <tr class="odd gradeX" align="center">
                                <td>{{$re->user->name}}</td>
                                <td>{{$re->noidung}} </td>
                                <td>{{$re->created_at}} </td>
                                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/report/{{$re->idUser}}/{{$re->idTinTuc}}/{{$re->noidung}}"> Xóa </a></td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tbody>
                        </tbody>
                    </table>
                   
                </div>

                <!--endrow-->



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