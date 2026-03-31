<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class AdminReviewController extends Controller
{
   
    public function review(Request $req)
    {
  

        $data = Review::with(['user','product']);
       
       
        $data = $data->paginate(5)->withQueryString();

        return view('admin.review', compact('data'));
    }

   
    public function review_del($id)
    {
        Review::where('review_id',$id)->delete();
        return redirect()->back()->with('success','Review deleted successfully!');
    }

    
}