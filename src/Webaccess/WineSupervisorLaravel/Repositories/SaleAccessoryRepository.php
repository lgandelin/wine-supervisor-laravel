<?php

namespace Webaccess\WineSupervisorLaravel\Repositories;

use DateTime;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\SaleAccessory;

class SaleAccessoryRepository extends BaseRepository
{
    /**
     * @param $saleID
     * @return mixed
     */
    public static function getByID($saleID)
    {
        $sale = SaleAccessory::find($saleID);
        $sale = self::getAdditionalInfo($sale);

        return $sale;
    }

    /**
     * @return mixed
     */
    public static function getAll($sort_column = null, $sort_order = null)
    {
        return SaleAccessory::orderBy($sort_column ? $sort_column : 'start_date', $sort_order ? $sort_order : 'DESC')->get();
    }

    /**
     * @param $is_active
     * @param $title
     * @param $title_en
     * @param $image
     * @param $accessories
     * @param $startDate
     * @param $endDate
     * @param $comments
     * @param $comments_en
     * @param $text_color
     * @param $link_history
     * @return bool
     */
    public static function create($is_active, $title, $title_en, $image, $accessories, $startDate, $endDate, $comments, $comments_en, $text_color, $link_history)
    {
        $sale = new SaleAccessory();
        $sale->id = Uuid::uuid4()->toString();
        $sale->is_active = $is_active;
        $sale->title = $title;
        $sale->title_en = $title_en;
        $sale->image = $image;
        $sale->accessories = $accessories;
        $sale->start_date = $startDate;
        $sale->end_date = $endDate;
        $sale->comments = $comments;
        $sale->comments_en = $comments_en;
        $sale->text_color = $text_color;
        $sale->link_history = $link_history;

        if ($sale->save()) {
            return $sale->id;
        }

        return false;
    }

    /**
     * @param $saleID
     * @param $title
     * @param $title_en
     * @param $image
     * @param $accessories
     * @param $startDate
     * @param $endDate
     * @param $comments
     * @param $comments_en
     * @param $text_color
     * @param $link_history
     * @return bool
     */
    public static function update($saleID, $is_active, $title, $title_en, $image, $accessories, $startDate, $endDate, $comments, $comments_en, $text_color, $link_history)
    {
        if ($sale = SaleAccessory::find($saleID)) {
            $sale->is_active = $is_active;
            $sale->title = $title;
            $sale->title_en = $title_en;
            $sale->image = $image;
            $sale->accessories = $accessories;
            $sale->start_date = $startDate;
            $sale->end_date = $endDate;
            $sale->comments = $comments;
            $sale->comments_en = $comments_en;
            $sale->text_color = $text_color;
            $sale->link_history = $link_history;

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
        if ($sale = SaleAccessory::find($saleID)) {
            return SaleAccessory::find($sale->id)->delete();
        }

        return false;
    }

    /**
     * @return mixed
     */
    public static function getSalesHistory()
    {
        $now = (new DateTime())->setTime(0, 0, 0);

        $sales = SaleAccessory::where('end_date', '<', $now)
            ->where('is_active', '=', true)
            ->orderBy('end_date', 'asc')->get();

        foreach ($sales as $sale) {
            $sale = self::getAdditionalInfo($sale);
        }

        return $sales;
    }

    public static function getCurrentSales()
    {
        $now = (new DateTime())->setTime(0, 0, 0);

        $sales = SaleAccessory::where('start_date', '<=', $now)
            ->where('is_active', '=', true)
            ->where('end_date', '>=', $now)
            ->orderBy('start_date', 'desc')
            ->get();

        foreach ($sales as $sale) {
            $sale = self::getAdditionalInfo($sale);
        }

        return $sales;
    }

    private static function getAdditionalInfo($sale)
    {
        if ($sale) {
            if (isset($sale->accessories)) $sale->accessories = json_decode($sale->accessories);
        }

        return $sale;
    }

    public static function getUpcomingSales()
    {
        $now = (new DateTime())->setTime(0, 0, 0);

        $sales = SaleAccessory::where('start_date', '>', $now)
            ->where('is_active', '=', true)
            ->orderBy('start_date', 'asc')
            ->get();

        foreach ($sales as $sale) {
            $sale = self::getAdditionalInfo($sale);
        }

        return $sales;
    }
}
