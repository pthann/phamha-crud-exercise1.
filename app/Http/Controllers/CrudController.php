<?php

namespace App\Http\Controllers;

use App\Models\CrudModels;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class CrudController extends Controller
{
    protected $users;
    public function __construct()
    {
        $this->users = new CrudModels();      
    }

    public function showUsers(){
        $users = CrudModels::all();
        return view('crud',compact('users'));
    }
    public function add(){
        $title = 'Thêm học sinh';
        return view('add',compact('title'));
    }
    public function postAdd(Request $request){
        $request->validate([
            'name' => 'required|min:5',
            'phoneNumber' => 'required|numeric'
        ],[
            'name.required' => 'Bạn phải nhập thông tin vào ô',
            'name.min' => 'Bạn phải nhập trên :min',
            'phoneNumber.required' => 'Bạn phải nhập thông tin vào ô',
            'phoneNumber.numeric' => 'Bạn phải nhập số không được nhập chữ'
        ]);
        $data = [
            $request->name,
            $request->phoneNumber
        ];
        $this->users->postAdd($data);
        return redirect()->route('show')->with('msg','Thêm người dùng thành công');
    }
    public function edit(Request $request,$id = 0){
        $title = 'Chỉnh sửa thông tin ';
        if(!empty($id)){
            $userDetails = $this->users->getDetail($id);
            if(!empty($userDetails)){
                $request->session()->put('id',$id);
                $userDetail = $userDetails[0];
            }
            else {
                return redirect()->route('show')->with('msg','Người dùng không tồn tại');
            }
        }
        return view('edit',compact('userDetail','title'));
    }
    public function postEdit(Request $request){
        $id = session('id');
        if(empty($id)){
            return back()->with('msg','ID không tồn tại');
        }
    
        $request->validate([
            'name' => 'required|min:5',
            'phoneNumber' => 'required|numeric'
        ],[
            'name.required' => 'Bạn phải nhập thông tin vào ô',
            'name.min' => 'Bạn phải nhập trên :min ký tự',
            'phoneNumber.required' => 'Bạn phải nhập thông tin vào ô',
            'phoneNumber.numeric' => 'Bạn phải nhập số không được nhập chữ'
        ]);
    
        $data = [
            'name' => $request->name,
            'phoneNumber' => $request->phoneNumber
        ];
    
        $this->users->postEdit($data, $id);
    
        return redirect()->route('show')->with('msg', 'Cập nhật thành công');
    }
    public function deleteUser($id)
    {
        $delete = $this->users->deleteUser($id);
        
        if ($delete) {
            return redirect()->route('show')->with('msg','Xóa người dùng thành công');
        } else {
            return redirect()->route('show')->with('msg','Không tìm thấy người dùng để xóa');
        }
    }
    
}