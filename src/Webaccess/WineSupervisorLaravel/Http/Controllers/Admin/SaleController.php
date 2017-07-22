<?php

namespace Webaccess\WineSupervisorLaravel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webaccess\WineSupervisorLaravel\Repositories\SaleRepository;
use Webaccess\WineSupervisorLaravel\Tools\UploadTool;

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

        $imageTempFolderName = 'temp-' . time();
        $imageTempFolder = public_path(env('WS_UPLOADS_FOLDER') . 'sales/' . $imageTempFolderName);
        mkdir($imageTempFolder);

        //Upload main image
        $imageSaleBackground = $request->get('image');

        if ($request->image_file) {
            if ($imageName = UploadTool::uploadImage($request->image_file, $imageTempFolder . '/0/')) {
                $imageSaleBackground = basename($imageName);
            }
        }

        $names = $request->get('wine_name');
        $varieties = $request->get('wine_variety');
        $texts = $request->get('wine_text');
        $images = $request->get('wine_image');
        $bottle_images = $request->get('wine_bottle_image');
        $links = $request->get('wine_link');
        $standard_prices = $request->get('wine_standard_price');
        $club_premium_prices = $request->get('wine_club_premium_price');

        $wines = [];
        for ($i = 0; $i < 10; $i++) {
            if (isset($names[$i])) {

                //Upload background image
                $imageWineBackground = isset($images[$i]) ? $images[$i] : '';

                $wineBackgroundName = 'image_wine_background_' . $i;
                if ($request->$wineBackgroundName) {
                    if ($imageName = UploadTool::uploadImage($request->$wineBackgroundName, $imageTempFolder . '/' . ($i+1) . '/')) {
                        $imageWineBackground = basename($imageName);
                    }
                }

                //Upload bottle image
                $imageWineBottle = isset($bottle_images[$i]) ? $bottle_images[$i] : '';

                $wineBottleName = 'image_wine_bottle_' . $i;
                if ($request->$wineBottleName) {
                    if ($imageName = UploadTool::uploadImage($request->$wineBottleName, $imageTempFolder . '/' . ($i+1) . '/')) {
                        $imageWineBottle = basename($imageName);
                    }
                }

                $wines[] = [
                    'name' => $names[$i],
                    'variety' => isset($varieties[$i]) ? $varieties[$i] : '',
                    'text' => isset($texts[$i]) ? $texts[$i] : '',
                    'image' => $imageWineBackground,
                    'bottle_image' => $imageWineBottle,
                    'link' => isset($links[$i]) ? $links[$i] : '',
                    'standard_price' => isset($standard_prices[$i]) ? $standard_prices[$i] : '',
                    'club_premium_price' => isset($club_premium_prices[$i]) ? $club_premium_prices[$i] : '',
                ];
            }
        }

        if ($saleID = SaleRepository::create(
            $request->get('title'),
            $request->get('description'),
            $imageSaleBackground,
            json_encode($wines),
            \DateTime::createFromformat('d/m/Y', $request->get('start_date'))->format('Y-m-d'),
            \DateTime::createFromformat('d/m/Y', $request->get('end_date'))->format('Y-m-d')
        )) {
            rename($imageTempFolder, public_path(env('WS_UPLOADS_FOLDER') . 'sales/' . $saleID));
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

        //Upload main image
        $imageSaleBackground = $request->get('image');

        if ($request->image_file) {
            if ($imageName = UploadTool::uploadImage($request->image_file, public_path(env('WS_UPLOADS_FOLDER') . 'sales/' .$request->get('sale_id') . '/0/'))) {
                $imageSaleBackground = basename($imageName);
            }
        }

        $names = $request->get('wine_name');
        $varieties = $request->get('wine_variety');
        $texts = $request->get('wine_text');
        $images = $request->get('wine_image');
        $bottle_images = $request->get('wine_bottle_image');
        $links = $request->get('wine_link');
        $standard_prices = $request->get('wine_standard_price');
        $club_premium_prices = $request->get('wine_club_premium_price');

        $wines = [];
        for ($i = 0; $i < 10; $i++) {
            if (isset($names[$i])) {

                //Upload background image
                $imageWineBackground = isset($images[$i]) ? $images[$i] : '';

                $wineBackgroundName = 'image_wine_background_' . $i;
                if ($request->$wineBackgroundName) {
                    if ($imageName = UploadTool::uploadImage($request->$wineBackgroundName, public_path(env('WS_UPLOADS_FOLDER') . 'sales/' .$request->get('sale_id') . '/' . ($i+1) . '/'))) {
                        $imageWineBackground = basename($imageName);
                    }
                }

                //Upload bottle image
                $imageWineBottle = isset($bottle_images[$i]) ? $bottle_images[$i] : '';

                $wineBottleName = 'image_wine_bottle_' . $i;
                if ($request->$wineBottleName) {
                    if ($imageName = UploadTool::uploadImage($request->$wineBottleName, public_path(env('WS_UPLOADS_FOLDER') . 'sales/' .$request->get('sale_id') . '/' . ($i+1) . '/'))) {
                        $imageWineBottle = basename($imageName);
                    }
                }

                $wines[] = [
                    'name' => $names[$i],
                    'variety' => isset($varieties[$i]) ? $varieties[$i] : '',
                    'text' => isset($texts[$i]) ? $texts[$i] : '',
                    'image' => $imageWineBackground,
                    'bottle_image' => $imageWineBottle,
                    'link' => isset($links[$i]) ? $links[$i] : '',
                    'standard_price' => isset($standard_prices[$i]) ? $standard_prices[$i] : '',
                    'club_premium_price' => isset($club_premium_prices[$i]) ? $club_premium_prices[$i] : '',
                ];
            }
        }

        if (SaleRepository::update(
            $request->get('sale_id'),
            $request->get('title'),
            $request->get('description'),
            $imageSaleBackground,
            json_encode($wines),
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