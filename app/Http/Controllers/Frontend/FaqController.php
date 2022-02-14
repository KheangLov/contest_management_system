<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    protected $documentRepository;

    // public function __construct()
    // {
        
    // }

    public function index(){
        $faq = Faq::where('parent_id', '=', null)->orderBy('id', 'desc')->get();
        return view('frontend.faq.faq', ['entry' => $faq]);
    }

    public function faqQuestion(){
        $request = request();
        if($request->question_message){
            Faq::create(['description' => $request->question_message]);
        }
        $faq = Faq::where('parent_id', '=', null)->orderBy('id', 'desc')->get();
        return redirect(route('faq',['entry' => $faq]));
    }
    
    public function faqAnswer(){
        $request = request();
        if($request->answer_message){
            Faq::create(['description' => $request->answer_message, 'parent_id' => $request->parent_id]);
        }
        return redirect(backpack_url('faq/'.$request->parent_id.'/show'));
    }
}
