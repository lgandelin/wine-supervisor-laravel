<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Repositories\ContentRepository;

class ContentController extends AdminController
{
    public function index(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.admin.content.index', [
            'contents' => ContentRepository::getAll(),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function create(Request $request) {

        parent::__construct($request);

        return view('wine-supervisor::pages.admin.content.create', [
            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function create_handler(Request $request)
    {
        parent::__construct($request);

        if (ContentRepository::create(
            $request->get('title'),
            $request->get('slug'),
            $request->get('text')
        )) {
            $request->session()->flash('confirmation', trans('wine-supervisor::admin.content_create_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::admin.content_create_error'));
        }

        return redirect()->route('admin_content_list');
    }

    public function update(Request $request, $contentID)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.admin.content.update', [
            'content' => ContentRepository::getByID($contentID),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update_handler(Request $request)
    {
        parent::__construct($request);

        if (ContentRepository::update(
            $request->get('content_id'),
            $request->get('title'),
            $request->get('slug'),
            $request->get('text')
        )) {
            $request->session()->flash('confirmation', trans('wine-supervisor::admin.content_update_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::admin.content_update_error'));
        }

        return redirect()->route('admin_content_list');
    }

    public function delete_handler(Request $request, $contentID)
    {
        parent::__construct($request);

        if (ContentRepository::delete($contentID)) {
            $request->session()->flash('confirmation', trans('wine-supervisor::admin.content_delete_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::admin.content_delete_error'));
        }

        return redirect()->route('admin_content_list');
    }
}