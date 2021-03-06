<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description'];

    public function rules($id = ''){
        return [
            'name' => "required|min:3|max:100|unique:products,name,{$id},id",
            'description' => 'required|min:10|max:1000'
        ];
    }

    public function ruleSearch(){
        return [
            'busca' => 'required'
        ];
    }

    public function search($data){

        return $this->where('name', 'like', "%{$data['busca']}%")
                    ->orWhere('description', 'like', "%{$data['busca']}%")
                    ->paginate(10);
    }
}
