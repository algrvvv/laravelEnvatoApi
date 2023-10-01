<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Filters\V1\CustomerFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CustomerResource;
use App\Http\Resources\V1\CustomerCollection;
use App\Http\Requests\V1\StoreCustomerRequest;
use App\Http\Requests\V1\UpdateCustomerRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new CustomerFilter();
        $filterItems = $filter->transform($request); // [['id', '=', '3']] - example

        $includeInvoices = $request->query('includeInvoices');

        $customer = Customer::where($filterItems);

        if($includeInvoices){
            $customer = $customer->with('invoices'); // with -> получение зависимостей, котоыре должны быть прописаны в модели
            // hasMany / belongTo и тд
        }

        return new CustomerCollection($customer->paginate()->appends($request->query()));


        // фильтрация по имени, к примеру
        // if(request('name')){
        //     return new CustomerCollection(Customer::where('name', 'LIKE', '%' . request('name') . '%')->get());
        // }
        // return new CustomerCollection(Customer::all());
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
     * @param  \App\Http\Requests\V1\StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        return new CustomerResource(Customer::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        // сделать вывод фактур для каждого типочка
        // return request('include'); //// ?include=true ////вывод - true 
        // return $request->query('include'); //// ?include=false ///// вывод - false
        // request('include') == $request->query('include');

        $includeInvoices = request('includeInvoices');

        if ($includeInvoices){
            return new CustomerResource($customer->loadMissing('invoices'));
        }

        return new CustomerResource($customer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerRequest  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());
        // он почему то не решился возвращать строчку ниже, мне удобнее с ней :D
        return new CustomerResource($customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
