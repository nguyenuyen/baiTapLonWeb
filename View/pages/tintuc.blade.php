  @extends('layout.index')
  <!-- Page Content -->
  @section('content')
  <div class="container">
    <div class="row">

        <!-- Blog Post Content Column -->
        <div class="col-lg-9">

            <!-- Blog Post -->

            <!-- Title -->
            <h1>{{$tintuc->TieuDe}}</h1>
            <strong>by Admin-{{$tintuc->admin->name}}</strong> 

            <!-- Author -->
            <p class="lead">
            </p>

            <!-- Preview Image -->
            <img class="img-responsive" src="upload/tintuc/{{$tintuc->Hinh}}" alt="">

            <!-- Date/Time -->
            <p><span class="glyphicon glyphicon-time"></span> Posted on {{$tintuc->created_at}} </p>
            <p>Số lượt xem:{{$tintuc->SoLuotXem}} </p>
            @if(isset($us))

            @if(session('thongbao1'))
            <div class="alert alert-success">
               {{session('thongbao1')}}
           </div>
           @endif
           <form action="report/{{$tintuc->id}}/{{$us->id}}" method="GET">
            <span>Report bài viết</span>
            <select name="report">
                <option value="Bài viết có thông tin không chính xác">Bài viết có thông tin không chính xác</option>
                <option value="Bài viết có nội dung trái pháp luật">Bài viết có nội dung trái pháp luật</option>
                <option value="Bài viết có hình ảnh phản cảm">Bài viết có hình ảnh phản cảm</option>
            </select>
            <button type="submit" class="btn btn-primary">Gửi</button>
        </form>
        @endif

        <hr>

        <!-- Post Content -->
        <p class="lead">{!!$tintuc->NoiDung!!}</p>

        <hr>

        <!-- Blog Comments -->

        <!-- Comments Form -->

        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.12';
          fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>

      @if(session('thongbao2'))
      <div class="alert alert-success">
       {{session('thongbao2')}}
   </div>
   @endif

   <a href="luotthich/{{$tintuc->id}}"><img src="upload/slide/liked.png" style="float: left;"></a>{{$tintuc->soluotthich}}
   <div class="fb-share-button" style="margin-left: 50px" data-href="http://dantri.com.vn/giao-duc-khuyen-hoc/ban-tuyen-giao-trung-uong-quan-triet-nang-cao-hieu-qua-cong-tac-khuyen-hoc-trong-boi-canh-moi-2018040916093878.htm" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fdantri.com.vn%2Fgiao-duc-khuyen-hoc%2Fban-tuyen-giao-trung-uong-quan-triet-nang-cao-hieu-qua-cong-tac-khuyen-hoc-trong-boi-canh-moi-2018040916093878.htm&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>




   @if(isset($us))
   <div class="well" >

      @if(session('thongbao'))
      <div class="alert alert-success">
       {{session('thongbao')}}
   </div>
   @endif
   <h4>Viết bình luận ...<span class="glyphicon glyphicon-pencil"></span></h4>
   <form action="comment/{{$tintuc->id}}" method="POST"> 
       <input type="hidden" name="_token" value="{{csrf_token()}} "/>
       <div class="form-group">
        <textarea class="form-control" rows="3" name="NoiDung"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Gửi</button>
</form>
</div>

<hr>
@endif

<!-- Posted Comments -->

<!-- Comment -->

@foreach($tintuc->comment as $cm)
<!-- Comment -->
<div class="media">
    <a class="pull-left" href="#">
        <img class="media-object" src="http://placehold.it/64x64" alt="">
    </a>
    <div class="media-body">
        <h4 class="media-heading">{{$cm->user->name}} 
            <small>{{$cm->created_at}} </small>

        </h4>
        {{$cm->NoiDung}}
    </div>
</div>
@endforeach

</div>

<!-- Blog Sidebar Widgets Column -->
<div class="col-md-3">

    <div class="panel panel-default">
        <div class="panel-heading"><b>Tin liên quan</b></div>
        <div class="panel-body">
            @foreach($tinlienquan as $tlq)
            <!-- item -->
            <div class="row" style="margin-top: 10px;">
                <div class="col-md-5">
                    <a href="tintuc/{{$tlq->id}}">
                        <img class="img-responsive" src="upload/tintuc/{{$tlq->Hinh}}" alt="">
                    </a>
                </div>
                <div class="col-md-7">
                    <a href="tintuc/{{$tlq->id}}"><b>{{$tlq->TieuDe}} </b></a>
                </div>
                <p style="padding-left: 5px;">{!!$tlq->TomTat!!} </p>
                <div class="break"></div>
            </div>
            <!-- end item -->
            @endforeach
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading"><b>Tin nổi bật</b></div>
        <div class="panel-body">
            @foreach($tinnoibat as $tnb)
            <!-- item -->
            <div class="row" style="margin-top: 10px;">
                <div class="col-md-5">
                    <a href="tintuc/{{$tnb->id}}">
                        <img class="img-responsive" src="upload/tintuc/{{$tnb->Hinh}} " alt="">
                    </a>
                </div>
                <div class="col-md-7">
                    <a href="tintuc/{{$tnb->id}}"><b>{{$tnb->TieuDe}} </b></a>
                </div>
                <p style="padding-left: 5px">{!!$tnb->TomTat!!} </p>
                <div class="break"></div>
            </div>
            <!-- end item -->
            @endforeach

        </div>
    </div>

</div>

</div>
<!-- /.row -->
</div>
<!-- end Page Content -->
@endsection