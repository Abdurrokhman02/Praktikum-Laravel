<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        return "Ini halaman daftar post (index)";
    }

    public function create(){
        return "Form tambah post (CREATE)";
    }

    public function store(Request $request){
        return "Proses simpan post baru (STORE)";
    }

    public function show(string $id){
        return "Tampilkan detail post dengan ID: $id (SHOW)";
    }

    public function edit($id) {
        return "Form edit post dengan ID: " . $id;
    }

    public function update(Request $request, $id) {
        return "Update post dengan ID: " . $id;
    }

    public function destroy($id) {
        return "Hapus post dengan ID: " . $id;
    }
}
