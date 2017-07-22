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
    public static function getAll($limit = null, $publication_date_filter = true)
    {
        $contents = Content::orderBy('publication_date', 'desc');

        if ($limit) {
            $contents->limit($limit);
        }

        if ($publication_date_filter) {
            $contents->where('publication_date', '<=', date('Y-m-d'));
        }

        return $contents->get();
    }

    /**
     * @param $title
     * @param $slug
     * @param $text
     * @param $image
     * @param $publication_date
     * @return bool
     */
    public static function create($title, $slug, $text, $image, $publication_date)
    {
        $sale = new Content();
        $sale->id = Uuid::uuid4()->toString();
        $sale->title = $title;
        $sale->slug = $slug;
        $sale->text = $text;
        $sale->image = $image;
        $sale->publication_date = $publication_date;

        if ($sale->save()) {
            return $sale->id;
        }

        return false;
    }

    /**
     * @param $saleID
     * @param $title
     * @param $slug
     * @param $text
     * @return bool
     */
    public static function update($saleID, $title, $slug, $text, $image, $publication_date)
    {
        if ($sale = Content::find($saleID)) {
            $sale->title = $title;
            $sale->slug = $slug;
            $sale->text = $text;
            $sale->image = $image;
            $sale->publication_date = $publication_date;

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