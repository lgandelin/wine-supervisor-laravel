<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Repositories\PartnerRepository;
use Webaccess\WineSupervisorLaravel\Tools\UploadTool;

class PartnerController extends AdminController
{
    public function index(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.admin.partner.index', [
            'partners' => PartnerRepository::getAll(null, false, $request->get('sc'), $request->get('so')),
            'sort_column' => $request->get('sc'),
            'sort_order' => ($request->get('so') == 'asc') ? 'desc' : 'asc',

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function create(Request $request) {

        parent::__construct($request);

        return view('wine-supervisor::pages.admin.partner.create', [
            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function create_handler(Request $request)
    {
        parent::__construct($request);

        $imageTempFolderName = 'temp-' . time();
        $imageTempFolder = public_path(env('WS_UPLOADS_FOLDER') . 'partners/' . $imageTempFolderName);
        @mkdir($imageTempFolder);

        //Upload main image
        $imagePartner = $request->get('image');

        if ($request->image_file) {
            if ($imageName = UploadTool::uploadImage($request->image_file, $imageTempFolder)) {
                $imagePartner = basename($imageName);
            }
        }

        if ($partnerID = PartnerRepository::create(
            $request->get('name'),
            $request->get('url'),
            $request->get('position'),
            $imagePartner,
            $request->get('image_width'),
            $request->get('image_height'),
            $request->get('is_active'),
            $request->get('display_start_date') ? \DateTime::createFromformat('d/m/Y', $request->get('display_start_date'))->format('Y-m-d') : null,
            $request->get('display_end_date') ? \DateTime::createFromformat('d/m/Y', $request->get('display_end_date'))->format('Y-m-d') : null
        )) {
            rename($imageTempFolder, public_path(env('WS_UPLOADS_FOLDER') . 'partners/' . $partnerID));
            $request->session()->flash('confirmation', trans('wine-supervisor::partner.partner_creation_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::partner.partner_creation_error'));
        }

        return redirect()->route('admin_partner_list');
    }

    public function update(Request $request, $partnerID)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.admin.partner.update', [
            'partner' => PartnerRepository::getByID($partnerID),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update_handler(Request $request)
    {
        parent::__construct($request);

        //Upload main image
        $imagePartner = $request->get('image');

        if ($request->image_file) {
            if ($imageName = UploadTool::uploadImage($request->image_file, public_path(env('WS_UPLOADS_FOLDER') . 'partners/' .$request->get('partner_id')))) {
                $imagePartner = basename($imageName);
            }
        }

        if (PartnerRepository::update(
            $request->get('partner_id'),
            $request->get('name'),
            $request->get('url'),
            $request->get('position'),
            $imagePartner,
            $request->get('image_width'),
            $request->get('image_height'),
            $request->get('is_active'),
            $request->get('display_start_date') ? \DateTime::createFromformat('d/m/Y', $request->get('display_start_date'))->format('Y-m-d') : null,
            $request->get('display_end_date') ? \DateTime::createFromformat('d/m/Y', $request->get('display_end_date'))->format('Y-m-d') : null
        )) {
            $request->session()->flash('confirmation', trans('wine-supervisor::partner.partner_update_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::partner.partner_update_error'));
        }

        return redirect()->route('admin_partner_list');
    }

    public function delete_handler(Request $request, $partnerID)
    {
        parent::__construct($request);

        if (PartnerRepository::delete($partnerID)) {
            $request->session()->flash('confirmation', trans('wine-supervisor::partner.partner_delete_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::partner.partner_delete_error'));
        }

        return redirect()->route('admin_partner_list');
    }
}