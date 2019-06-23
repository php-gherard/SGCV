<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\NotaPedido;
use App\Customer;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Session\Session;
use App\DetalleNotaPedido;

class NotaPedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function actualizarTotales(){
         //Actualizar total e igv
        $total=0;
        $totaligv=0;
        foreach(\Session::get('detalleNota') as $item) {
           
            $total=$total+($item['product_cantidad']*$item['product_price']);       
        }
        $totaligv=$total*0.18;
        \Session::put('total',$total);
        \Session::put('igv',$totaligv);

     }
    public function index(Request $request)
    {
       
       /* $inputs=Input::all();
        $dni = $inputs['dni'];
        */

       
        if(!\Session::has('detalleNota')) {
            \Session::put('detalleNota',array());


        }
        $total=0;
        $totaligv=0;
        foreach(\Session::get('detalleNota') as $item) {
           
            $total=$total+($item['product_cantidad']*$item['product_price']);       
        }
        $totaligv=$total*0.18;

        if(!\Session::has('detalleTransporte')) {
            \Session::put('detalleTransporte',array());
        }
        if ($request->session()->has('transporte')) {
            $transporte = 1; 
            
        }else{
            $transporte =0;
           
        }
        $detalleNota = \Session::get('detalleNota'); 
    
        if ($request->session()->has('nrodoccli')) {
            $nrodoccliente = $request->session()->get('nrodoccli');
            $nameCustomer = $request->session()->get('nameCustomer');          
        }else{
            $nrodoccliente = ' ';
            $nameCustomer = ' ';
        }  
        return view('regnotped')->with(compact('nrodoccliente','nameCustomer','detalleNota','transporte','total','totaligv'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data1=[];
        $data1 = $request->except('_token');

        $total=0;
        $totaligv=0;
        if (!$request->session()->has('nrodoccli')) {
            \Session::flash('error','No ha seleccionado el cliente');
            
        }
        else{
            // Datos de cabecera de nota de pedido
            \Session::flash('success','Registro Correcto');
            $this->user =  \Auth::user();
            $user_id=$this->user->id;
            $fecha_emision = new \DateTime();

            $nrodoc= \Session::get('nrodoccli');
            $igv= \Session::get('igv');
            if ($request->session()->has('transporte')) {
                $transporte = 30.00; 
                
            }else{
                $transporte =0.00;
               
            }
            $customer_id =  DB::table('customers')
                                ->select('customers.id')
                                ->where('nrodoc','=',"$nrodoc")
                                ->first();

            $data=array_add($data1, 'fecha_emision', $fecha_emision->format('Y-m-d H:i:s'));
            $data=array_add($data, 'user_id', $this->user->id);
            $data=array_add($data, 'customer_id', $customer_id->id);
            $data=array_add($data, 'estadoNotaPedido', 1);
            $data=array_add($data, 'igv', \Session::get('igv'));
            $data=array_add($data, 'total', \Session::get('total'));
            $data=array_add($data, 'transporte', $transporte);
            //Comando que ejecuta el insert en tabla nota_pedidos
           $notapedido= NotaPedido::create($data);

            // Datos de detalle de nota de pedido
           
            $data=[];
            foreach(\Session::get('detalleNota') as $item) {
                
                $subtotal=$item['product_cantidad']*$item['product_price'];     
               
                $data['producto_id']=$item['product_id'];
                $data['nota_pedido_id']=$notapedido->id; 
                $data['cantidad']=$item['product_cantidad'];
                $data['subtotal']=$subtotal;
                DetalleNotaPedido::create($data);
            }
            $totaligv=$total*0.18;

            //Comando que ejecuta el insert en tabla nota_pedidos

            

        }
       
    
        return redirect('/registrarNotaPedido');
      // return redirect('/registrarNotaPedido');
        
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function buscar()
    {
        $notapedidos =  DB::table('nota_pedidos')
        ->join('customers', 'customers.id', '=', 'nota_pedidos.customer_id')
        ->join('users', 'users.id', '=', 'nota_pedidos.user_id')
        ->select('customers.nameCustomer', 'nota_pedidos.id','users.name','nota_pedidos.estadoNotaPedido','nota_pedidos.total')
        ->get();
        return view('connotped')->with(compact('notapedidos'));
    }



    public function show(Request $request)
    {
        $nota_pedido_id = $request ->get('nota_pedido_id') ;
        $nota_pedido_name = $request ->get('nota_pedido_name') ;
        $cliente = $request ->get('cliente') ;
        $vendedor = $request ->get('vendedor') ;
        $estado = $request ->get('estado') ;
              
        $notapedidos =  DB::table('nota_pedidos')
        ->join('customers', 'customers.id', '=', 'nota_pedidos.customer_id')
        ->join('users', 'users.id', '=', 'nota_pedidos.user_id')
        ->select('customers.nameCustomer', 'nota_pedidos.id','users.name','nota_pedidos.estadoNotaPedido','nota_pedidos.total')
        ->where('nota_pedidos.id','LIKE',"%$nota_pedido_id%")
        ->where('customers.nameCustomer','LIKE',"%$cliente%")
        ->where('users.name','LIKE',"%$vendedor%")
        ->where('nota_pedidos.estadoNotaPedido','LIKE',"%$estado%")
        ->get();
        
       return view('connotped')->with(compact('notapedidos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function seleccionarNotaPedido(Request $request){
        $id = $request ->get('nota_pedido_id') ;
        $name= $request -> get('nameCustomer');
        $request->session()->put('nota_pedidos_id',$id);
        $request->session()->put('nota_pedidos_name',$name);
        
        return redirect('registrarComprobantePago');
       
     
    }
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
