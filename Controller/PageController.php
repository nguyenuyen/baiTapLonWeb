<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\Slide;
use App\LoaiTin;
use App\TinTuc;
use App\User;
use App\Chat;
use App\Report;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
	
    public function __construct(){
    	$theloai=TheLoai::all();
    	$slide=Slide::all();
    	view()->share('theloai',$theloai);
    	view()->share('slide',$slide);
    	
    }
    
    public function kiemtra(){
    	if(Auth::check()){
        	$us=Auth::user();
        	view()->share('us',$us);
        }
    }


	public function trangchu(){
		$this->kiemtra();
		return view('pages.trangchu');
	}

	public function lienhe(){
		$this->kiemtra();
		return view('pages.lienhe');
	}

	public function loaitin($id){
		$this->kiemtra();
		$loaitin=LoaiTin::find($id);
		$tintuc=TinTuc::where('idLoaiTin',$id)->paginate(5);
		return view('pages.loaitin',['loaitin'=>$loaitin,'tintuc'=>$tintuc]);
	}

	public function tintuc($id){
		$this->kiemtra();
		$tintuc= TinTuc::find($id);
		$tintuc->SoLuotXem = $tintuc->SoLuotXem +1;
		$tintuc->save();
		$tinnoibat=TinTuc::where('NoiBat',1)->take(4)->get();
		$tinlienquan=TinTuc::where('idLoaiTin',$tintuc->idLoaiTin)->take(4)->get();
		return view('pages.tintuc',['tintuc'=>$tintuc,'tinnoibat'=>$tinnoibat,'tinlienquan'=>$tinlienquan]);
	}

	public function dangnhap(){
		return view('pages.dangnhap');

	}
	public function postdangnhap(Request $re){
		$this->validate($re,
			[
			   'email' => 'required',
			   'password'=>'required|min:3|max:32',
			],
			[
			 
				'Email.required' =>'Bạn chưa nhập email',
				'Password.required'=>' Bạn chưa nhập lại mật khẩu',
				'Password.min'=>'Mật khẩu phải có từ 3 đến 32 ký tự',
				'Password.max'=>'Mật khẩu phải có từ 3 đến 32 ký tự',
			]);
		if(Auth::attempt(['email'=>$re->email,'password'=>$re->password])){
			 
            return redirect('trangchu');
		}else {
			return redirect('dangnhap')->with('thongbao','Đăng nhập không thành công');
		}
	}

	public function dangxuat(){
		Auth::logout();
		return redirect('trangchu');
	}

	public function nguoidung(){
		$this->kiemtra();
		return view('pages.nguoidung');

	}

	public function postnguoidung(Request $re){
		$user= Auth::user();
		$this->validate($re,
			[
			   'name'=>'required|min:3',
		  
			],
			[
				'name.required'=>'Bạn chưa nhập tên ',
				'name.min'=>'  Tên ít nhất phải có 3 ký tự ',
			
			]);
		if($re->changepass == "on"){
			 $this->validate($re,
			[
			   'password'=>'required|min:3|max:32',
			   'password1'=>'required|same:password',
		  
			],
			[
				'password.required'=>' Bạn chưa nhập lại mật khẩu',
				'password.min'=>'Mật khẩu phải có từ 3 đến 32 ký tự',
				'password.max'=>'Mật khẩu phải có từ 3 đến 32 ký tự',
				'password1.required'=>'Bạn chưa nhập lại mật khẩu',
				'password1.same'=>'Mật khẩu nhập lại chưa khớp',
			]);
			 $user->password= bcrypt($re->password);

		} 
   
		$user->name=$re->name;
		$user->save();
		return redirect('nguoidung')->with('thongbao','Bạn đã sửa thành công');

	}

	public function dangky(){
		return view('pages.dangky');
	}

	public function postdangky(Request $re){
		$this->validate($re,
			[
			   'name'=>'required|min:3',
			   'email' => 'required|email|unique:users,email',
			   'password'=>'required|min:3|max:32',
			   'password1'=>'required|same:password',
			],
			[
				'name.required'=>'Bạn chưa nhập tên ',
				'name.min'=>'  Tên ít nhất phải có 3 ký tự ',
				'email.required' =>'Bạn chưa nhập email',
				'email.email'=>' Email không đúng định dạng',
				'email.unique'=>'Email đã được đăng ký',
				'password.required'=>' Bạn chưa nhập lại mật khẩu',
				'password.min'=>'Mật khẩu phải có từ 3 đến 32 ký tự',
				'password.max'=>'Mật khẩu phải có từ 3 đến 32 ký tự',
				'password1.required'=>'Bạn chưa nhập lại mật khẩu',
				'password1.same'=>'Mật khẩu nhập lại chưa khớp',
			]);
		$user= new User;
		$user->name=$re->name;
		$user->email=$re->email;
		$user->password= bcrypt($re->password);
		$user->quyen=0;
		$user->save();
		return redirect('dangky')->with('thongbao','Bạn đã đăng ký thành công');


	}

	public function timkiem(Request $re){
		$tukhoa = $re->tukhoa;
		$tintuc = TinTuc::where('TieuDe','like',"%$tukhoa%")->orwhere('TomTat','like',"%$tukhoa%")->orwhere('NoiDung','like',"%$tukhoa%")->paginate(5);
		return view('pages.timkiem',['tintuc'=>$tintuc,'tukhoa'=>$tukhoa]);

	}

	public function gioithieu(){
		$this->kiemtra();
		return view('pages.gioithieu');
	}

	public function chat($id,Request $re){
		$this->validate($re,
			[
			   'noidung'=>'required|min:3',
			],
			[
				'noidung.required'=>'Bạn chưa nhập nội dung ',
				'noidung.min'=>'  nội dung ít nhất phải có 3 ký tự ',
			]);
		$chat= new Chat;
		$chat->idUser= $id."";
		$chat->noidung=$re->noidung;
		$chat->type = 0;
		$chat->by = $id."";
		$chat->save();
		return redirect('lienhe');

	}

	public function report($idTinTuc,$idUser,Request $re){
		$report = new Report;
        $report->idTinTuc = $idTinTuc."";
        $report->idUser = $idUser."";
        $report->noidung = $re->report;
        try { 
           $report->save();
           return redirect('tintuc/'.$idTinTuc)->with('thongbao1','Bạn đã report thành công');

        } catch(\Illuminate\Database\QueryException $ex){ 
           return redirect('tintuc/'.$idTinTuc)->with('thongbao1','Bạn đã report trước đó');
        }	

	}

	public function lienket(Request $re){
		$kq = $re->lienket;
		if($kq=="v1")
			return redirect('http://sovhtt.hanoi.gov.vn/');
		if($kq=="v2")
			return redirect('http://www.dulichhanoihalongsapa.com/');
		if($kq=="v3")
			return redirect('https://lindo.vn/');

	}

	public function luotthich($id){
		$tintuc = TinTuc::find($id);
		$thich = $tintuc->soluotthich;
		$tintuc->soluotthich = $thich +1;
		$tintuc->save();
		if ($thich==0)
		   return redirect('tintuc/'.$id)->with('thongbao2','Bạn là người đầu tiên thích bài viết này');
		return redirect('tintuc/'.$id)->with('thongbao2','Bạn và '.$thich.' người khác thích bài viết này.');

	}

	public function traloi($id,$idadmin){
		return view('pages.chat',['id'=>$id,'idadmin'=>$idadmin]);

	}

	public function posttraloi($id,$idadmin,Request $re){
		$chat = new Chat;
		$chat->idUser = $id."";
		$chat->by = $idadmin."";
		$chat->type = 1;
		$chat->noidung = $re->noidung;
		$chat->save();
		return redirect('admin/user/sua/'.$id)->with('thongbao2','Bạn đã trả lời thành công');

	}

	public function getxoachat($id,$iduser){
		$chat = Chat::find($id);
		$chat->delete();
		return redirect('admin/user/sua/'.$iduser)->with('thongbao2','Bạn đã xóa thành công');


	}

	public function slideclick($id){
		$slide = Slide::find($id);
        $slide->SoLuotClick = $slide->SoLuotClick + 1;
        $slide->save();
		return redirect($slide->link."");
	}
}