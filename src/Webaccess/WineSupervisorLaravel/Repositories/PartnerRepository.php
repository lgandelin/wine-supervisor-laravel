<?php

namespace Webaccess\WineSupervisorLaravel\Repositories;

use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Partner;

class PartnerRepository extends BaseRepository
{
    /**
     * @param $guestID
     * @return mixed
     */
    public static function getByID($guestID)
    {
        return Partner::find($guestID);
    }

    /**
     * @param null $limit
     * @param bool $display_filter
     * @param null $sort_column
     * @param null $sort_order
     * @return mixed
     */
    public static function getAll($limit = null, $display_filter = true, $sort_column = null, $sort_order = null)
    {
        $partners = Partner::orderBy($sort_column ? $sort_column : 'position', $sort_order ? $sort_order : 'ASC');

        if ($limit) {
            $partners->limit($limit);
        }

        if ($display_filter) {
            $partners->where('is_active', '=', true)
                ->where(function ($query) {
                    $query->where(function ($query2) {
                        $query2->where('display_start_date', '<=', date('Y-m-d'))->orWhere('display_start_date', '=', null);
                    })->where(function ($query2) {
                        $query2->where('display_end_date', '>=', date('Y-m-d'))->orWhere('display_end_date', '=', null);
                    });
                });
        }

        return $partners->get();
    }

    /**
     * @param $name
     * @param $url
     * @param $position
     * @param $image
     * @param $image_width
     * @param $image_height
     * @param $is_active
     * @param $display_start_date
     * @param $display_end_date
     * @return bool
     */
    public static function create($name, $url, $position, $image, $image_width, $image_height, $is_active, $display_start_date, $display_end_date)
    {
        $sale = new Partner();
        $sale->id = Uuid::uuid4()->toString();
        $sale->name = $name;
        $sale->url = $url;
        $sale->position = $position;
        $sale->image = $image;
        $sale->image_width = $image_width;
        $sale->image_height = $image_height;
        $sale->is_active = $is_active;
        $sale->display_start_date = $display_start_date;
        $sale->display_end_date = $display_end_date;

        if ($sale->save()) {
            return $sale->id;
        }

        return false;
    }

    /**
     * @param $saleID
     * @param $name
     * @param $url
     * @param $position
     * @param $image
     * @param $image_width
     * @param $image_height
     * @param $is_active
     * @param $display_start_date
     * @param $display_end_date
     * @return bool
     */
    public static function update($saleID, $name, $url, $position, $image, $image_width, $image_height, $is_active, $display_start_date, $display_end_date)
    {
        if ($sale = Partner::find($saleID)) {
            $sale->name = $name;
            $sale->url = $url;
            $sale->position = $position;
            $sale->image = $image;
            $sale->image_width = $image_width;
            $sale->image_height = $image_height;
            $sale->is_active = $is_active;
            $sale->display_start_date = $display_start_date;
            $sale->display_end_date = $display_end_date;

            return $sale->save();
        }

        return false;
    }

    /**
     * @param $saleID
     * @return bool
     */
    public static function delete($saleID)
    {
        if ($sale = Partner::find($saleID)) {
            return Partner::find($sale->id)->delete();
        }

        return false;
    }
}