<?php

namespace Webaccess\WineSupervisorLaravel\Repositories;

use Ramsey\Uuid\Uuid;
use Webaccess\WineSupervisorLaravel\Models\PageContent;

class PageContentRepository extends BaseRepository
{
    /**
     * @param $guestID
     * @return mixed
     */
    public static function getByID($pageContentID)
    {
        return PageContent::find($pageContentID);
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
        $contents = PageContent::orderBy($sort_column ? $sort_column : 'created_at', $sort_order ? $sort_order : 'DESC');

        if ($limit) {
            $contents->limit($limit);
        }

        if ($publication_date_filter) {
            $contents->where('publication_date', '<=', date('Y-m-d'));
        }

        return $contents->get();
    }

    /**
     * @param $pageContentID
     * @param $title
     * @param $text
     * @param $text_en
     * @return bool
     */
    public static function update($pageContentID, $title, $text, $text_en, $image)
    {
        if ($pageContent = PageContent::find($pageContentID)) {
            $pageContent->title = $title;
            $pageContent->text = $text;
            $pageContent->text_en = $text_en;
            $pageContent->image = $image;

            return $pageContent->save();
        }

        return false;
    }
}