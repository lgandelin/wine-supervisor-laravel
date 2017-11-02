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
    public static function getAll($sort_column = null, $sort_order = null)
    {
        return Sale::orderBy($sort_column ? $sort_column : 'start_date', $sort_order ? $sort_order : 'DESC')->get();
    }

    /**
     * @param $title
     * @param $title_en
     * @param $description
     * @param $image
     * @param $wines
     * @param $startDate
     * @param $endDate
     * @param $comments
     * @param $comments_en
     * @return bool
     */
    public static function create($title, $title_en, $description, $image, $wines, $startDate, $endDate, $comments, $comments_en)
    {
        $sale = new Sale();
        $sale->id = Uuid::uuid4()->toString();
        $sale->title = $title;
        $sale->title_en = $title_en;
        $sale->description = $description;
        $sale->image = $image;
        $sale->wines = $wines;
        $sale->start_date = $startDate;
        $sale->end_date = $endDate;
        $sale->comments = $comments;
        $sale->comments_en = $comments_en;

        if ($sale->save()) {
            return $sale->id;
        }

        return false;
    }

    /**
     * @param $saleID
     * @param $title
     * @param $title_en
     * @param $description
     * @param $image
     * @param $wines
     * @param $startDate
     * @param $endDate
     * @param $comments
     * @param $comments_en
     * @return bool
     */
    public static function update($saleID, $title, $title_en, $description, $image, $wines, $startDate, $endDate, $comments, $comments_en)
    {
        if ($sale = Sale::find($saleID)) {
            $sale->title = $title;
            $sale->title_en = $title_en;
            $sale->description = $description;
            $sale->image = $image;
            $sale->wines = $wines;
            $sale->start_date = $startDate;
            $sale->end_date = $endDate;
            $sale->comments = $comments;
            $sale->comments_en = $comments_en;

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
        $now = (new DateTime())->setTime(0, 0, 0);

        $sales = Sale::where('end_date', '<', $now)->orderBy('start_date', 'desc')->orderBy('end_date', 'desc')->get();

        foreach ($sales as $sale) {
            $sale = self::getAdditionalInfo($sale);
        }

        return $sales;
    }

    public static function getCurrentSales()
    {
        $now = (new DateTime())->setTime(0, 0, 0);

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

    public static function getSalePreview($saleID)
    {
        if ($sale = Sale::find($saleID)) {
            return [self::getAdditionalInfo($sale)];
        }

        return [];
    }
}
