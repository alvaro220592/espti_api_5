<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    private $product;

    public function __construct(Product $product)
    {   
        $this->product = $product;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($this->product->count() > 0){
            return response()->json($this->product->paginate());
        }
        return response()->json(['Mensagem' => 'Nenhum produto cadastrado']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = validator($request->all(), $this->product->rules());

        if($validate->fails()){
            return response()->json($validate->messages());
        }

        if (! $this->product->create($request->all()))
            return response()->json(['Erro' => 'Erro ao cadastrar'], 500);
        
        return response()->json([
            'Mensagem' => 'Cadastro realizado com sucesso',
            'Dados' => $request->all()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(! $this->product = Product::find($id))
            return response()->json(['Mensagem' => 'Produto não encontrado']);
        return response()->json(['Produtos' => $this->product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = $this->product->find($id);

        // verificando se existe o produto com o id informado
        if(! $product)
            return response()->json(['Mensagem' => 'Produto não encontrado']);

        $validacao = validator($request->all(), $product->rules($id));

        if($validacao->fails())
            return response()->json(['Erro' => $validacao->messages()]);

        if(! $product->update($request->all()))
            return response()->json(['Erro' => 'Erro ao alterar'], 500);
        return response()->json([
            'Mensagem' => 'Dados alterados com sucesso',
            'Produto' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! $produto = $this->product->find($id))
            return response()->json(['Mensagem' => 'Produto não encontrado']);

        if (! $produto->delete())
            return response()->json(['Erro' => 'Erro ao excluir']);
        return response()->json([
            'Mensagem' => 'Produto excluído com sucesso',
            'Produto' => $produto
        ]);
    }

    public function search(Request $request){
        $data = $request->all();

        $validacao = validator($data, $this->product->ruleSearch());
        if ($validacao->fails())
            return response()->json(['Erro' => $validacao->messages()]);
        
        return response()->json(['Resultado' => $this->product->search($data)]);
    }
}
