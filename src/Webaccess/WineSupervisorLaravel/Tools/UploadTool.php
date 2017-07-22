<?php

namespace Webaccess\WineSupervisorLaravel\Tools;

class UploadTool {

	public static function uploadImage($imageFile, $folder) {
	    $imageName = time() . '.' . $imageFile->getClientOriginalExtension();

        if (!is_dir($folder)) {
            @mkdir($folder);
        }

        if ($imageFile->move($folder, $imageName)) {
            return $imageName;
        }

        return false;
	}
}