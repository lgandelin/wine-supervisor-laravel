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
     * @param null $limit
     * @param bool $publication_date_filter
     * @param null $sort_column
     * @param null $sort_order
     * @return mixed
     */
    public static function getAll($limit = null, $publication_date_filter = true, $sort_column = null, $sort_order = null)
    {
        $contents = Content::orderBy($sort_column ? $sort_column : 'publication_date', $sort_order ? $sort_order : 'DESC');

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
     * @param $title_en
     * @param $slug
     * @param $text
     * @param $text_en
     * @param $image
     * @param $publication_date
     * @return bool
     */
    public static function create($title, $title_en, $slug, $text, $text_en, $image, $publication_date)
    {
        $sale = new Content();
        $sale->id = Uuid::uuid4()->toString();
        $sale->title = $title;
        $sale->title_en = $title_en;
        $sale->slug = $slug;
        $sale->text = $text;
        $sale->text_en = $text_en;
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
     * @param $title_en
     * @param $slug
     * @param $text
     * @param $text_en
     * @param $image
     * @param $publication_date
     * @return bool
     */
    public static function update($saleID, $title, $title_en, $slug, $text, $text_en, $image, $publication_date)
    {
        if ($sale = Content::find($saleID)) {
            $sale->title = $title;
            $sale->title_en = $title_en;
            $sale->slug = $slug;
            $sale->text = $text;
            $sale->text_en = $text_en;
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