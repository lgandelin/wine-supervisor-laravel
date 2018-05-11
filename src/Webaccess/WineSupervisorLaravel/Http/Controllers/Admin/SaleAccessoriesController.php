<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Repositories\SaleAccessoryRepository;
use Webaccess\WineSupervisorLaravel\Tools\UploadTool;

class SaleAccessoriesController extends AdminController
{
    public function index(Request $request)
    {
        parent::__construct($request);

        return view('wine-supervisor::pages.admin.sale_accessory.index', [
            'sales' => SaleAccessoryRepository::getAll($request->get('sc'), $request->get('so')),
            'sort_column' => $request->get('sc'),
            'sort_order' => ($request->get('so') == 'asc') ? 'desc' : 'asc',

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function create(Request $request) {

        parent::__construct($request);

        return view('wine-supervisor::pages.admin.sale_accessory.create', [
            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function create_handler(Request $request)
    {
        parent::__construct($request);

        $imageTempFolderName = 'temp-' . time();
        $imageTempFolder = public_path(env('WS_UPLOADS_FOLDER') . 'sales_accessories/' . $imageTempFolderName);
        mkdir($imageTempFolder);

        //Upload main image
        $imageSaleBackground = $request->get('image');

        if ($request->image_file) {
            if ($imageName = UploadTool::uploadImage($request->image_file, $imageTempFolder . '/0/')) {
                $imageSaleBackground = basename($imageName);
            }
        }

        $names = $request->get('accessory_name');
        $texts = $request->get('accessory_text');
        $texts_en = $request->get('accessory_text_en');
        $images = $request->get('accessory_image');
        $accessory_images = $request->get('accessory_accessory_image');
        $links = $request->get('accessory_link');
        $standard_prices = $request->get('accessory_standard_price');
        $club_premium_prices = $request->get('accessory_club_premium_price');

        $accessories = [];
        for ($i = 0; $i < 10; $i++) {
            if (isset($names[$i])) {

                //Upload background image
                $imageAccessoryBackground = isset($images[$i]) ? $images[$i] : '';

                $wineBackgroundName = 'image_accessory_background_' . $i;
                if ($request->$wineBackgroundName) {
                    if ($imageName = UploadTool::uploadImage($request->$wineBackgroundName, $imageTempFolder . '/' . ($i+1) . '/')) {
                        $imageAccessoryBackground = basename($imageName);
                    }
                }

                //Upload accessory image
                $imageAccessoryAccessory = isset($accessory_images[$i]) ? $accessory_images[$i] : '';

                $wineBottleName = 'image_accessory_accessory_' . $i;
                if ($request->$wineBottleName) {
                    if ($imageName = UploadTool::uploadImage($request->$wineBottleName, $imageTempFolder . '/' . ($i+1) . '/')) {
                        $imageAccessoryAccessory = basename($imageName);
                    }
                }

                $accessories[] = [
                    'name' => $names[$i],
                    'text' => isset($texts[$i]) ? $texts[$i] : '',
                    'text_en' => isset($texts_en[$i]) ? $texts_en[$i] : '',
                    'image' => $imageAccessoryBackground,
                    'accessory_images' => $imageAccessoryAccessory,
                    'link' => isset($links[$i]) ? $links[$i] : '',
                    'standard_price' => isset($standard_prices[$i]) ? $standard_prices[$i] : '',
                    'club_premium_price' => isset($club_premium_prices[$i]) ? $club_premium_prices[$i] : '',
                ];
            }
        }

        if ($saleID = SaleAccessoryRepository::create(
            $request->get('is_active'),
            $request->get('title'),
            $request->get('title_en'),
            $imageSaleBackground,
            json_encode($accessories),
            \DateTime::createFromformat('d/m/Y', $request->get('start_date'))->format('Y-m-d'),
            \DateTime::createFromformat('d/m/Y', $request->get('end_date'))->format('Y-m-d'),
            $request->get('comments'),
            $request->get('comments_en'),
            $request->get('text_color'),
            $request->get('link_history')
        )) {
            rename($imageTempFolder, public_path(env('WS_UPLOADS_FOLDER') . 'sales_accessories/' . $saleID));
            $request->session()->flash('confirmation', trans('wine-supervisor::sale.sale_create_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::sale.sale_create_error'));
        }

        return redirect()->route('admin_accessories_sale_list');
    }

    public function update(Request $request, $saleID) {

        parent::__construct($request);

        return view('wine-supervisor::pages.admin.sale_accessory.update', [
            'sale' => SaleAccessoryRepository::getByID($saleID),

            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
    }

    public function update_handler(Request $request)
    {
        parent::__construct($request);

        //Upload main image
        $imageSaleBackground = $request->get('image');

        if ($request->image_file) {
            if ($imageName = UploadTool::uploadImage($request->image_file, public_path(env('WS_UPLOADS_FOLDER') . 'sales_accessories/' .$request->get('sale_id') . '/0/'))) {
                $imageSaleBackground = basename($imageName);
            }
        }

        $names = $request->get('accessory_name');
        $texts = $request->get('accessory_text');
        $texts_en = $request->get('accessory_text_en');
        $images = $request->get('accessory_image');
        $accessory_images = $request->get('accessory_accessory_image');
        $links = $request->get('accessory_link');
        $standard_prices = $request->get('accessory_standard_price');
        $club_premium_prices = $request->get('accessory_club_premium_price');

        $accessories = [];
        for ($i = 0; $i < 10; $i++) {
            if (isset($names[$i])) {

                //Upload background image
                $imageAccessoryBackground = isset($images[$i]) ? $images[$i] : '';

                $wineBackgroundName = 'image_accessory_background_' . $i;
                if ($request->$wineBackgroundName) {
                    if ($imageName = UploadTool::uploadImage($request->$wineBackgroundName, public_path(env('WS_UPLOADS_FOLDER') . 'sales_accessories/' .$request->get('sale_id') . '/' . ($i+1) . '/'))) {
                        $imageAccessoryBackground = basename($imageName);
                    }
                }

                //Upload bottle image
                $imageAccessoryAccessory = isset($accessory_images[$i]) ? $accessory_images[$i] : '';

                $wineAccessoryName = 'image_accessory_accessory_' . $i;
                if ($request->$wineAccessoryName) {
                    if ($imageName = UploadTool::uploadImage($request->$wineAccessoryName, public_path(env('WS_UPLOADS_FOLDER') . 'sales_accessories/' .$request->get('sale_id') . '/' . ($i+1) . '/'))) {
                        $imageAccessoryAccessory = basename($imageName);
                    }
                }

                $accessories[] = [
                    'name' => $names[$i],
                    'text' => isset($texts[$i]) ? $texts[$i] : '',
                    'text_en' => isset($texts_en[$i]) ? $texts_en[$i] : '',
                    'image' => $imageAccessoryBackground,
                    'accessory_image' => $imageAccessoryAccessory,
                    'link' => isset($links[$i]) ? $links[$i] : '',
                    'standard_price' => isset($standard_prices[$i]) ? $standard_prices[$i] : '',
                    'club_premium_price' => isset($club_premium_prices[$i]) ? $club_premium_prices[$i] : '',
                ];
            }
        }

        if (SaleAccessoryRepository::update(
            $request->get('sale_id'),
            $request->get('is_active'),
            $request->get('title'),
            $request->get('title_en'),
            $imageSaleBackground,
            json_encode($accessories),
            \DateTime::createFromformat('d/m/Y', $request->get('start_date'))->format('Y-m-d'),
            \DateTime::createFromformat('d/m/Y', $request->get('end_date'))->format('Y-m-d'),
            $request->get('comments'),
            $request->get('comments_en'),
            $request->get('text_color'),
            $request->get('link_history')
        )) {
            $request->session()->flash('confirmation', trans('wine-supervisor::sale.sale_update_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::sale.sale_update_error'));
        }

        return redirect()->route('admin_accessories_sale_list');
    }

    public function delete_handler(Request $request, $saleID)
    {
        parent::__construct($request);

        if (SaleAccessoryRepository::delete($saleID)) {
            $request->session()->flash('confirmation', trans('wine-supervisor::sale.sale_delete_success'));
        } else {
            $request->session()->flash('error', trans('wine-supervisor::sale.sale_delete_error'));
        }

        return redirect()->route('admin_accessories_sale_list');
    }
}