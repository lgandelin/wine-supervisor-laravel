<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Services\SaleManager;

class SaleController extends AdminController
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

        if (SaleManager::create(
            $request->get('title'),
            $request->get('jury_note'),
            $request->get('jury_opinion'),
            $request->get('description'),
            $request->get('link'),
            \DateTime::createFromformat('d/m/Y', $request->get('start_date'))->format('Y-m-d'),
            \DateTime::createFromformat('d/m/Y', $request->get('end_date'))->format('Y-m-d')
        )) {
            $request->session()->flash('confirmation', trans('wine-supervisor::admin.sale_create_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::admin.sale_create_error'));
        }

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

        if (SaleManager::update(
            $request->get('sale_id'),
            $request->get('title'),
            $request->get('jury_note'),
            $request->get('jury_opinion'),
            $request->get('description'),
            $request->get('link'),
            \DateTime::createFromformat('d/m/Y', $request->get('start_date'))->format('Y-m-d'),
            \DateTime::createFromformat('d/m/Y', $request->get('end_date'))->format('Y-m-d')
        )) {
            $request->session()->flash('confirmation', trans('wine-supervisor::admin.sale_update_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::admin.sale_update_error'));
        }

        return redirect()->route('admin_sale_list');
    }

    public function delete_handler(Request $request, $saleID)
    {
        parent::__construct($request);

        if (SaleManager::delete($saleID)) {
            $request->session()->flash('confirmation', trans('wine-supervisor::admin.sale_delete_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::admin.sale_delete_error'));
        }

        return redirect()->route('admin_sale_list');
    }
}