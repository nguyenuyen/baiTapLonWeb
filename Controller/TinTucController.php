<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\TheLoai;
use App\TinTuc;
use App\Report;
use Illuminate\Support\Facades\Auth;

class TinTucController extends Controller
{
    //

    public function kiemtra(){
        if(Auth::check()){
            $us=Auth::user();
            view()->share('us',$us);
        }
    }


    public function getDanhSach(){
    	$tintuc=TinTuc::orderBy('id','DESC')->get();
        $this->kiemtra();
    	return view('admin.tintuc.danhsach',['tintuc'=>$tintuc]);

    }

     public function suaDanhSach($id){
     	$theloai=TheLoai::all();
     	$loaitin = LoaiTin::all();
        $tintuc=TinTuc::find($id);
        $this->kiemtra();
        $arr[0] = Report::where([
            ['idTinTuc','=',$id.""],
            ['noidung','=','Bài viết có thông tin không chính xác'],

            ])->count();
        $arr[1] = Report::where([
            ['idTinTuc','=',$id.""],
            ['noidung','=','Bài viết có nội dung trái pháp luật'],

            ])->count();
        $arr[2] = Report::where([
            ['idTinTuc','=',$id.""],
            ['noidung','=','Bài viết có hình ảnh phản cảm'],

            ])->count();
        
     	return view('admin.tintuc.sua',['theloai'=>$theloai,'loaitin'=>$loaitin,'tintuc'=>$tintuc,'arr'=>$arr]);
    	
    }

    public function postsuaDanhSach(Request $re,$id){
        $tintuc=TinTuc::find($id);
    	   $this->validate($re,
            [
               'LoaiTin'=>'required',
               'TieuDe' => 'required|min:3|unique:TinTuc,TieuDe',
               'TomTat'=> 'required',
               'NoiDung'=>'required'
            ],
            [

                'LoaiTin.required' => ' Điền vào tên loại tin',
                'TieuDe.min' => 'Tiêu đề phải có độ dài từ 3 đến 100 ký tự',
                'TieuDe.unique' => ' Tiêu đề tin đã tồn tại',
                'TomTat.required'=>'Bạn chưa nhập tóm tắt ',
                'NoiDung.required'=>' Bạn chưa nhập nội dung',
            ]);
        $tintuc->TieuDe= $re->TieuDe;
        $tintuc->TieuDeKhongDau=changeTitle($re->TieuDe);
        $tintuc->idLoaiTin = $re->LoaiTin;
        $tintuc->TomTat= $re->TomTat;
        $tintuc->NoiDung=$re->NoiDung;

        if($re->hasFile('Hinh')){
             $file = $re->file('Hinh');
            $name=$file->getClientOriginalName();
            $Hinh= str_random(4)."_".$name;         
            $file->move("upload/tintuc",$Hinh);
            unlink("upload/tintuc/".$tintuc->Hinh);
            $tintuc->Hinh = $Hinh;
        }
      
       $tintuc->save();
       return redirect('admin/tintuc/sua/'.$id)->with('thongbao','Bạn đã sửa thành công');
    }


     public function themDanhSach(){
        $theloai= TheLoai::all();
        $loaitin = LoaiTin::all();
        $this->kiemtra();
     	return view('admin/tintuc/them',['theloai'=>$theloai,'loaitin'=>$loaitin]);
    	
    }

    public function postthemDanhSach($id,Request $re){
        $this->kiemtra();
    	$this->validate($re,
    		[
               'LoaiTin'=>'required',
    		   'TieuDe' => 'required|min:3|unique:TinTuc,TieuDe',
    		   'TomTat'=> 'required',
               'NoiDung'=>'required'
            ],
    		[

                'LoaiTin.required' => ' Điền vào tên loại tin',
                'TieuDe.min' => 'Tiêu đề phải có độ dài từ 3 đến 100 ký tự',
                'TieuDe.unique' => ' Tiêu đề tin đã tồn tại',
                'TomTat.required'=>'Bạn chưa nhập tóm tắt ',
                'NoiDung.required'=>' Bạn chưa nhập nội dung',
    		]);

    	$tintuc = new TinTuc;
        $tintuc->TieuDe= $re->TieuDe;
        $tintuc->TieuDeKhongDau=changeTitle($re->TieuDe);
        $tintuc->idLoaiTin = $re->LoaiTin;
        $tintuc->TomTat= $re->TomTat;
        $tintuc->NoiDung=$re->NoiDung;
        $tintuc->SoLuotXem=0;
        $tintuc->NoiBat = $re->NoiBat;
        $tintuc->by = $id."";

        if($re->hasFile('Hinh')){
             $file = $re->file('Hinh');
            $name=$file->getClientOriginalName();
            $Hinh= str_random(4)."_".$name;         
            $file->move("upload/tintuc",$Hinh);
            $tintuc->Hinh = $Hinh;
        }
        else{
            $tintuc->Hinh="";
        }

       $tintuc->save();
       return redirect('admin/tintuc/them')->with('thongbao','Thêm thành công');
    }

    public function getXoaDanhSach($id){
    	$tintuc=TinTuc::find($id);
        $comment = $tintuc->comment();
        $report = $tintuc->report();
        $comment->delete();
        $report->delete();
        $tintuc->delete();
    	return redirect('admin/tintuc/danhsach')->with('thongbao','Bạn đã xóa thành công');
    }


    public function report($id,$idTin,$noidung){
        $re = Report::where([
            ['idUser','=',$id.""],
            ['idTinTuc','=',$idTin.""],
            ['noidung','=',$noidung.""]
            ]);
        $re->delete();
        return redirect('admin/tintuc/sua/'.$idTin)->with('thongbao2','Bạn đã xóa report thành công');
    }

    public function postDanhSach(Request $re){
        $this->kiemtra();
        $tukhoa = $re->tukhoa;
        $tintuc = TinTuc::where('TieuDe','like',"%$tukhoa%")->orwhere('TomTat','like',"%$tukhoa%")->orwhere('NoiDung','like',"%$tukhoa%")->paginate(5);
        return view('admin.tintuc.danhsach',['tintuc'=>$tintuc,'tukhoa'=>$tukhoa]);
    }


}
