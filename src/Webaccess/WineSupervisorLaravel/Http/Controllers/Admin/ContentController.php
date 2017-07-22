<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Repositories\ContentRepository;
use Webaccess\WineSupervisorLaravel\Tools\UploadTool;

class ContentController extends AdminController
{
    public function index(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.admin.content.index', [
            'contents' => ContentRepository::getAll(null, false),

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

        $imageTempFolderName = 'temp-' . time();
        $imageTempFolder = public_path(env('WS_UPLOADS_FOLDER') . 'contents/' . $imageTempFolderName);
        @mkdir($imageTempFolder);

        //Upload main image
        $imageNews = $request->get('image');

        if ($request->image_file) {
            if ($imageName = UploadTool::uploadImage($request->image_file, $imageTempFolder)) {
                $imageNews = basename($imageName);
            }
        }

        if ($contentID = ContentRepository::create(
            $request->get('title'),
            $request->get('slug'),
            $request->get('text'),
            $imageNews,
            $request->get('publication_date') ? \DateTime::createFromformat('d/m/Y', $request->get('publication_date'))->format('Y-m-d') : null
        )) {
            rename($imageTempFolder, public_path(env('WS_UPLOADS_FOLDER') . 'contents/' . $contentID));
            $request->session()->flash('confirmation', trans('wine-supervisor::content.content_creation_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::content.content_creation_error'));
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

        //Upload main image
        $imageNews = $request->get('image');

        if ($request->image_file) {
            if ($imageName = UploadTool::uploadImage($request->image_file, public_path(env('WS_UPLOADS_FOLDER') . 'contents/' .$request->get('content_id')))) {
                $imageNews = basename($imageName);
            }
        }

        if (ContentRepository::update(
            $request->get('content_id'),
            $request->get('title'),
            $request->get('slug'),
            $request->get('text'),
            $imageNews,
            $request->get('publication_date') ? \DateTime::createFromformat('d/m/Y', $request->get('publication_date'))->format('Y-m-d') : null
        )) {
            $request->session()->flash('confirmation', trans('wine-supervisor::content.content_update_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::content.content_update_error'));
        }

        return redirect()->route('admin_content_list');
    }

    public function delete_handler(Request $request, $contentID)
    {
        parent::__construct($request);

        if (ContentRepository::delete($contentID)) {
            $request->session()->flash('confirmation', trans('wine-supervisor::content.content_delete_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::content.content_delete_error'));
        }

        return redirect()->route('admin_content_list');
    }
}