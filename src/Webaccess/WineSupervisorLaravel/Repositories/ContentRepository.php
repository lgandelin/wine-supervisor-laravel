<?php

namespace Webaccess\WineSupervisorLaravel\Repositories;

use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\Content;

class ContentRepository extends BaseRepository
{
    /**
     * @param $guestID
     * @return mixed
     */
    public static function getByID($guestID)
    {
        return Content::find($guestID);
    }

    /**
     * @return mixed
     */
    public static function getAll()
    {
        return Content::all();
    }

    /**
     * @param $title
     * @param $slug
     * @param $text
     * @return bool
     */
    public static function create($title, $slug, $text)
    {
        $sale = new Content();
        $sale->id = Uuid::uuid4()->toString();
        $sale->title = $title;
        $sale->slug = $slug;
        $sale->text = $text;

        return $sale->save();
    }

    /**
     * @param $saleID
     * @param $title
     * @param $slug
     * @param $text
     * @return bool
     */
    public static function update($saleID, $title, $slug, $text)
    {
        if ($sale = Content::find($saleID)) {
            $sale->title = $title;
            $sale->slug = $slug;
            $sale->text = $text;

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
        if ($sale = Content::find($saleID)) {
            return Content::find($sale->id)->delete();
        }

        return false;
    }
}