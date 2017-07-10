<?php

namespace Webaccess\WineSupervisorLaravel\Repositories;

use DateTime;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Sale;

class SaleRepository extends BaseRepository
{
    /**
     * @param $saleID
     * @return mixed
     */
    public static function getByID($saleID)
    {
        return Sale::find($saleID);
    }

    /**
     * @return mixed
     */
    public static function getAll()
    {
        return Sale::orderBy('created_at', 'desc')->get();
    }

    /**
     * @param $title
     * @param $description
     * @param $image
     * @param $link
     * @param $startDate
     * @param $endDate
     * @return bool
     */
    public static function create($title, $description, $image, $link, $startDate, $endDate)
    {
        $sale = new Sale();
        $sale->id = Uuid::uuid4()->toString();
        $sale->title = $title;
        $sale->description = $description;
        $sale->image = $image;
        $sale->link = $link;
        $sale->start_date = $startDate;
        $sale->end_date = $endDate;

        return $sale->save();
    }

    /**
     * @param $saleID
     * @param $title
     * @param $description
     * @param $image
     * @param $link
     * @param $startDate
     * @param $endDate
     * @return bool
     */
    public static function update($saleID, $title, $description, $image, $link, $startDate, $endDate)
    {
        if ($sale = Sale::find($saleID)) {
            $sale->title = $title;
            $sale->description = $description;
            $sale->image = $image;
            $sale->link = $link;
            $sale->start_date = $startDate;
            $sale->end_date = $endDate;

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
        if ($sale = Sale::find($saleID)) {
            return Sale::find($sale->id)->delete();
        }

        return false;
    }

    /**
     * @return mixed
     */
    public static function getCurrentSales()
    {
        $now = new DateTime();
        return Sale::where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->orderBy('start_date', 'desc')
            ->get();
    }

    /**
     * @return mixed
     */
    public static function getSalesHistory()
    {
        return Sale::orderBy('start_date', 'desc')->orderBy('end_date', 'desc')->get();
    }
}
