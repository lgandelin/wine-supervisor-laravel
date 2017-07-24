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
        $sale = self::getAdditionalInfo($sale);

        return $sale;
    }

    /**
     * @return mixed
     */
    public static function getAll()
    {
        $sales = Sale::orderBy('start_date', 'desc')->orderBy('end_date', 'desc')->get();
        foreach ($sales as $sale) {
            $sale = self::getAdditionalInfo($sale);
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
     * @param $comments
     * @return bool
     */
    public static function create($title, $description, $image, $wines, $startDate, $endDate, $comments)
    {
        $sale = new Sale();
        $sale->id = Uuid::uuid4()->toString();
        $sale->title = $title;
        $sale->description = $description;
        $sale->image = $image;
        $sale->wines = $wines;
        $sale->start_date = $startDate;
        $sale->end_date = $endDate;
        $sale->comments = $comments;

        if ($sale->save()) {
            return $sale->id;
        }

        return false;
    }

    /**
     * @param $saleID
     * @param $title
     * @param $description
     * @param $image
     * @param $wines
     * @param $startDate
     * @param $endDate
     * @param $comments
     * @return bool
     */
    public static function update($saleID, $title, $description, $image, $wines, $startDate, $endDate, $comments)
    {
        if ($sale = Sale::find($saleID)) {
            $sale->title = $title;
            $sale->description = $description;
            $sale->image = $image;
            $sale->wines = $wines;
            $sale->start_date = $startDate;
            $sale->end_date = $endDate;
            $sale->comments = $comments;

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
        $now = new DateTime();

        $sales = Sale::where('end_date', '<', $now)->orderBy('start_date', 'desc')->orderBy('end_date', 'desc')->get();

        foreach ($sales as $sale) {
            $sale = self::getAdditionalInfo($sale);
        }

        return $sales;
    }

    public static function getCurrentSales()
    {
        $now = new DateTime();

        $sales = Sale::where('start_date', '<=', $now)
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
        $sale->wines = json_decode($sale->wines);
        if (new DateTime() >= DateTime::createFromFormat('Y-m-d', $sale->start_date) && new DateTime() <= DateTime::createFromFormat('Y-m-d', $sale->end_date)) {
            $sale->is_active = true;
        }

        return $sale;
    }
}
