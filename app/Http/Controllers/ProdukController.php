<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Exception;

class ProdukController extends Controller{

    public function create(){
        $data = [
            'kode_produk' => request()->post('kode_produk'),
            'nama_produk' => request()->post('nama_produk'),
            'harga_produk' => request()->post('harga_produk')
        ];

        try{
            $hasil = Produk::create($data);

            return $this->responseHasil(200, true, $hasil);
        }catch(exception $e){
            return $this->responseHasil(500, false, [
                'message'=> $e->getMessage(),
                'data'=> $data
            ]);
        }
        
    }

    public function read(){
        $data = Produk::paginate(20);
        return $this->responseHasil(200, true, $data);
    }

    public function update($id){
        $data = [
            'kode_produk' => request('kode_produk'),
            'nama_produk' => request('nama_produk'),
            'harga_produk' => request('harga_produk')
        ];

        try{
            $produk = Produk::find($id);

            if(empty($produk)){
                return $this->responseHasil(404, false, 'Data tidak ditemukan');
            }

            $hasil = $produk->update($data);

            return $this->responseHasil(200, true, $hasil);
        }catch(exception $e){
            return $this->responseHasil(500, false, [
                'message'=> $e->getMessage(),
                'data'=> $data
            ]);
        }
    }

    public function show($id){
        $a = Produk::find($id);
        return $this->responseHasil(200, true, $a);
    }

    public function delete($id){
        $hasil = Produk::find($id);
        
        if(empty($hasil)){
            return $this->responseHasil(404, false, 'Data tidak ditemukan');
        }

        $h = $hasil->delete();
        
        return $this->responseHasil(200, true, $h);
    }
}