<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Repositories\PageContentRepository;
use Webaccess\WineSupervisorLaravel\Tools\UploadTool;

class PageContentController extends AdminController
{
    public function index(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.admin.page_content.index', [
            'contents' => PageContentRepository::getAll(null, false, $request->get('sc'), $request->get('so')),
            'sort_column' => $request->get('sc'),
            'sort_order' => ($request->get('so') == 'asc') ? 'desc' : 'asc',

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update(Request $request, $contentID)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.admin.page_content.update', [
            'content' => PageContentRepository::getByID($contentID),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update_handler(Request $request)
    {
        parent::__construct($request);

        //Upload main image
        $imageContent = $request->get('image');
        $imageFolder = public_path(env('WS_UPLOADS_FOLDER') . 'contents/' . $request->get('page_content_id'));

        if (!is_dir($imageFolder)) {
            mkdir($imageFolder);
        }

        if ($request->image_file) {
            if ($imageName = UploadTool::uploadImage($request->image_file, $imageFolder)) {
                $imageContent = basename($imageName);
            }
        }

        if (PageContentRepository::update(
            $request->get('page_content_id'),
            $request->get('title'),
            $request->get('text'),
            $request->get('text_en'),
            $imageContent
        )) {
            $request->session()->flash('confirmation', trans('wine-supervisor::page_content.page_content_update_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::page_content.page_content_update_error'));
        }

        return redirect()->route('admin_page_content_list');
    }
}