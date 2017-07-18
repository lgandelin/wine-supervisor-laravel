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
        $sale = Sale::find($saleID);
        $sale->wines = json_decode($sale->wines);

        return $sale;
    }

    /**
     * @return mixed
     */
    public static function getAll()
    {
        $sales = Sale::orderBy('start_date', 'desc')->orderBy('end_date', 'desc')->get();
        foreach ($sales as $sale) {
            $sale->wines = json_decode($sale->wines);
        }

        return $sales;
    }

    /**
     * @param $title
     * @param $description
     * @param $image
     * @param $wines
     * @param $startDate
     * @param $endDate
     * @return bool
     */
    public static function create($title, $description, $image, $wines, $startDate, $endDate)
    {
        $sale = new Sale();
        $sale->id = Uuid::uuid4()->toString();
        $sale->title = $title;
        $sale->description = $description;
        $sale->image = $image;
        $sale->wines = $wines;
        $sale->start_date = $startDate;
        $sale->end_date = $endDate;

        return $sale->save();
    }

    /**
     * @param $saleID
     * @param $title
     * @param $description
     * @param $image
     * @param $wines
     * @param $startDate
     * @param $endDate
     * @return bool
     */
    public static function update($saleID, $title, $description, $image, $wines, $startDate, $endDate)
    {
        if ($sale = Sale::find($saleID)) {
            $sale->title = $title;
            $sale->description = $description;
            $sale->image = $image;
            $sale->wines = $wines;
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
    public static function getSalesHistory()
    {
        return Sale::orderBy('start_date', 'desc')->orderBy('end_date', 'desc')->get();
    }

    public static function getCurrentSales()
    {
        $now = new DateTime();

        $sales = Sale::where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->orderBy('start_date', 'desc')
            ->get();
        foreach ($sales as $sale) {
            $sale->wines = json_decode($sale->wines);
        }

        return $sales;
    }
}
