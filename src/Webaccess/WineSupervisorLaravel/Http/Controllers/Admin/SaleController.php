<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webaccess\WineSupervisorLaravel\Http\Controllers\BaseController;
use Webaccess\WineSupervisorLaravel\Services\SaleManager;

class SaleController extends BaseController
{
    public function index(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.admin.sale.index', [
            'sales' => SaleManager::getAll(),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function create(Request $request) {

        parent::__construct($request);

        return view('wine-supervisor::pages.admin.sale.create', [
            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function create_handler(Request $request)
    {
        parent::__construct($request);

        SaleManager::create(
            $request->get('title'),
            $request->get('jury_note'),
            $request->get('jury_opinion'),
            $request->get('description'),
            $request->get('link'),
            $request->get('start_date'),
            $request->get('end_date')
        );

        $request->session()->flash('confirmation', trans('wine-supervisor::admin.sale_create_success'));

        return redirect()->route('admin_sale_list');
    }

    public function update(Request $request, $saleID) {

        parent::__construct($request);

        return view('wine-supervisor::pages.admin.sale.update', [
            'sale' => SaleManager::getByID($saleID),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update_handler(Request $request)
    {
        parent::__construct($request);

        SaleManager::update(
            $request->get('sale_id'),
            null,
            Auth::guard('administrators')->getUser()->id,
            $request->get('technician_id'),
            $request->get('name'),
            $request->get('subscription_type'),
            $request->get('serial_number'),
            $request->get('address'),
            $request->get('zipcode'),
            $request->get('city')
        );

        $request->session()->flash('confirmation', trans('wine-supervisor::admin.sale_update_success'));

        return redirect()->route('admin_sale_list');
    }
}