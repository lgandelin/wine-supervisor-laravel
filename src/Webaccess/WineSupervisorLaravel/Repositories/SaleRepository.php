<?php

namespace Webaccess\WineSupervisorLaravel\Repositories;

use DateTime;
use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Sale;

class SaleRepository
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
        return Sale::all();
    }

    /**
     * @param $title
     * @param $juryNote
     * @param $juryOpinion
     * @param $description
     * @param $link
     * @param $startDate
     * @param $endDate
     * @return bool
     */
    public static function create($title, $juryNote, $juryOpinion, $description, $link, $startDate, $endDate)
    {
        $sale = new Sale();
        $sale->id = Uuid::uuid4()->toString();
        $sale->title = $title;
        $sale->jury_note = $juryNote;
        $sale->jury_opinion = $juryOpinion;
        $sale->description = $description;
        $sale->link = $link;
        $sale->start_date = $startDate;
        $sale->end_date = $endDate;

        return $sale->save();
    }

    /**
     * @param $saleID
     * @param $title
     * @param $juryNote
     * @param $juryOpinion
     * @param $description
     * @param $link
     * @param $startDate
     * @param $endDate
     * @return bool
     */
    public static function update($saleID, $title, $juryNote, $juryOpinion, $description, $link, $startDate, $endDate)
    {
        if ($sale = Sale::find($saleID)) {
            $sale->title = $title;
            $sale->jury_note = $juryNote;
            $sale->jury_opinion = $juryOpinion;
            $sale->description = $description;
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

    public static function getCurrentSales()
    {
        $now = new DateTime();
        return Sale::where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
