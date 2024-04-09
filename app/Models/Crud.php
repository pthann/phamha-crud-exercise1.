<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CrudModels extends Model
{
    use HasFactory;
    protected $table = 'users';
    public function getAllUser()
    {
        $users = DB::select('SELECT * FROM users');
        return $users;
    }
    public function postAdd($data)
    {
        $users = DB::select('INSERT INTO users (name,phoneNumber) VALUES (?,?)', $data);
        return $users;
    }
    public function getDetail($id)
    {
        return DB::select('SELECT * FROM users WHERE id= ?', [$id]);
    }
    public function postEdit($data, $id)
    {
        DB::table('users')
        ->where('id', $id)
        ->update([
            'name' => $data['name'],
            'phoneNumber' => $data['phoneNumber']
        ]);

    return redirect()->back()->with('msg', 'Cập nhật thành công');
    }
    public function deleteUser($id)
    {
        return  DB::delete("DELETE FROM users WHERE id=? ", [$id]);
    }
}