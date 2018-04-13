    @extends('layout.index')
    @section('content')
    <div class="container">

    	@include('layout.slide')

      <div class="space20"></div>


      <div class="row main-left">
        @include('layout.menu')

        <div class="col-md-9">
         <div class="panel panel-default">            
          <div class="panel-heading" style="background-color:#337AB7; color:white;" >
           <h2 style="margin-top:0px; margin-bottom:0px;">Liên hệ</h2>
         </div>

         <div class="panel-body">
           <!-- item -->
           <h3><span class="glyphicon glyphicon-align-left"></span> Thông tin liên hệ</h3>
           
           <div class="break"></div>
           <h4><span class= "glyphicon glyphicon-home "></span> Địa chỉ : </h4>
           <p>47 Phạm Văn Đồng, Mai Dịch, Từ Liêm, Hà Nội</p>

           <h4><span class="glyphicon glyphicon-envelope"></span> Email : </h4>
           <p>truyenthongbaochivn@gmail.com</p>

           <h4><span class="glyphicon glyphicon-phone-alt"></span> Hotline : </h4>
           <p>0904 964 437</p>



           <br><br>
           <h3><span class="glyphicon glyphicon-globe"></span> Bản đồ</h3>
           <div class="break"></div><br>
           <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.6024633364445!2d105.77777625085709!3d21.04858669240749!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313454cd66faec67%3A0xa56f0d9c696a7ac!2zNDcgUGjhuqFtIFbEg24gxJDhu5NuZywgTWFpIEThu4tjaCwgVOG7qyBMacOqbSwgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1523209131037" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
           <br><br><br>
           <h3><img src="upload/slide/connect.png">Liên Kết Website</h3>
           <br>
           <form action="lienket" method="GET">
            <select name="lienket">
             <option>--Liên kết website--</option>
             <option value="v1">Sở văn hóa-thể thao-du lịch</option>
             <option value="v2">Danh lam,thắng cảnh Việt Nam</option>
             <option value="v3">Thiết kế web chuyên nghiệp</option>
           </select>
           <button type="submit" style="margin-left: 100px;margin-top: 5px">Đi tới</button>
         </form>
         <br><br><br>

         @if(isset($us))
         
         <h3><img src="upload/slide/chat.png"> Chat Với Nhân Viên</h3>
         <div class="break"></div>
         <div>
           <form action="chat/{{$us->id}}" method="GET" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{csrf_token()}} " />
            <div class="form-group">
              
             <div style="width: 300px;border: 1px solid #dedfdc;padding: 5px">         
               @foreach($us->chat as $ch)
               
               @if($ch->type==0)
               <div style="margin-right: 80px">{{$ch->noidung}}</div><br>
               @else
               <div style="color: blue;margin-left: 80px">{{$ch->noidung}}</div><br>
               @endif
               
               @endforeach
             </div>
             <textarea cols="35" rows="3" name="noidung"></textarea>
           </div>
           <button type="submit" class="btn btn-default">Gửi</button>
         </form>

       </div>
       
       @endif

     </div>
   </div>
 </div>
</div>
<!-- /.row -->
</div>
@endsection