 @extends('admin.layout.index')
 @section('content')
 <div id="page-wrapper">
  <?php 
     function doimau($str,$tukhoa){
       return str_replace($tukhoa, "<span style='color:red;'>$tukhoa</span>",$str);
     }
     ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Tin tức
                            <small>Danh sách</small>
                        </h1>
                            <form action="admin/tintuc/danhsach" method="POST">
                                <input type="text" class="form-control" placeholder="Search..." style="width: 200px;float: left;" name="tukhoa">
                                <span class="input-group-btn" style="">
                                    <button class="btn btn-default" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span><br><br>
                            </form>
                            <!-- /input-group -->
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
                                <th> Tiêu đề  </th>
                                <th>Tóm tắt</th>
                                <th>Thể loại </th>
                                <th> Loại tin</th>
                                <th>Số lượt xem </th>
                                <th> Nổi bật </th>
                                <th> Xóa </th>
                                <th>Sửa</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($tintuc as $tt)
                            <tr class="odd gradeX" align="center">
                                <td>{{$tt->id}} </td>
                                <td><p>{{$tt->TieuDe}}</p>
                                <img width="100px" height="100px"  src="upload/tintuc/{{$tt->Hinh}}">
                                 </td>
                                <td>
                                    @if(isset($tukhoa))
                                           {!! doimau($tt->TomTat,$tukhoa) !!} 
                                    @else
                                         {!! $tt->TomTat !!}
                                    @endif
                                </td>
                                <td>{{$tt->loaitin->theloai->Ten}} </td>
                                <td>{{$tt->loaitin->Ten}}</td>
                                <td>{{$tt->SoLuotXem}}</td>
                                <td>
                                   @if($tt->NoiBat==0)
                                   {{'Không'}}
                                   @elseif($tt->NoiBat==1)
                                   {{'Có'}}
                                   @endif
                                    
                                </td>
                                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/tintuc/xoa/{{$tt->id}} "> Xóa </a></td>
                                <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/tintuc/sua/{{$tt->id}} ">Sửa</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
 </div>
 @endsection

 @section('script')


 @endsection