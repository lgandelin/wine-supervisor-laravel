<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Repositories\SaleRepository;

class SaleController extends AdminController
{
    public function index(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.admin.sale.index', [
            'sales' => SaleRepository::getAll(),

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

        if (SaleRepository::create(
            $request->get('title'),
            $request->get('description'),
            $request->get('image'),
            $request->get('link'),
            \DateTime::createFromformat('d/m/Y', $request->get('start_date'))->format('Y-m-d'),
            \DateTime::createFromformat('d/m/Y', $request->get('end_date'))->format('Y-m-d')
        )) {
            $request->session()->flash('confirmation', trans('wine-supervisor::sale.sale_create_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::sale.sale_create_error'));
        }

        return redirect()->route('admin_sale_list');
    }

    public function update(Request $request, $saleID) {

        parent::__construct($request);

        return view('wine-supervisor::pages.admin.sale.update', [
            'sale' => SaleRepository::getByID($saleID),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update_handler(Request $request)
    {
        parent::__construct($request);

        if (SaleRepository::update(
            $request->get('sale_id'),
            $request->get('title'),
            $request->get('description'),
            $request->get('image'),
            $request->get('link'),
            \DateTime::createFromformat('d/m/Y', $request->get('start_date'))->format('Y-m-d'),
            \DateTime::createFromformat('d/m/Y', $request->get('end_date'))->format('Y-m-d')
        )) {
            $request->session()->flash('confirmation', trans('wine-supervisor::sale.sale_update_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::sale.sale_update_error'));
        }

        return redirect()->route('admin_sale_list');
    }

    public function delete_handler(Request $request, $saleID)
    {
        parent::__construct($request);

        if (SaleRepository::delete($saleID)) {
            $request->session()->flash('confirmation', trans('wine-supervisor::sale.sale_delete_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::sale.sale_delete_error'));
        }

        return redirect()->route('admin_sale_list');
    }
}