<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //
    public function getXoa($id,$idTinTuc){
    	$comment= Comment::find($id);
        $comment->delete();

        return redirect('admin/tintuc/sua/'.$idTinTuc)->with('thongbao',' Xóa comment thành công');
    }

    public function postcomment(Request $re,$id){
    	$cm=new Comment;
    	$cm->idUser=Auth::user()->id;
    	$cm->idTinTuc= $id;
    	$cm->NoiDung= $re->NoiDung;
    	$cm->save();
    	return redirect("tintuc/$id")->with('thongbao','Bạn đã đăng bình luận thành công');
    }

}
