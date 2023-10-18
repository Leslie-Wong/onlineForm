<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class ValidImageUrl {

    public static function isValidImageUrl($url) {
        $returnA = ["status" => false, "type" => ""];
        $url_headers = get_headers(trim($url), 1);
        if (isset($url_headers['Content-Type'])) {

            $type = strtolower($url_headers['Content-Type']);

            $valid_image_type = array();
            $valid_image_type['image/png'] = 'png';
            $valid_image_type['image/jpg'] = 'jpg';
            $valid_image_type['image/jpeg'] = 'jpeg';
            $valid_image_type['image/jpe'] = 'jpeg';
            $valid_image_type['image/gif'] = 'gif';
            $valid_image_type['image/tif'] = 'tiff';
            $valid_image_type['image/tiff'] = 'tiff';
            $valid_image_type['image/svg'] = 'svg';
            //$valid_image_type['image/ico'] = '';
            //$valid_image_type['image/icon'] = '';
            $valid_image_type['image/x-icon'] = 'ico';

            if (isset($valid_image_type[$type])) {
                $returnA["status"] = true;
                $returnA["type"] = $valid_image_type[$type];
            }
        }
        return $returnA;
    }

    public static function isValidImageUrl_old($url) {
        $returnA = ["status" => false, "type" => ""];
        $info = getimagesize(trim($url));
        if ($info) {

            $type = strtolower($info['mime']);

            $valid_image_type = array();
            $valid_image_type['image/png'] = 'png';
            $valid_image_type['image/jpg'] = 'jpg';
            $valid_image_type['image/jpeg'] = 'jpeg';
            $valid_image_type['image/jpe'] = 'jpeg';
            $valid_image_type['image/gif'] = 'gif';
            $valid_image_type['image/tif'] = 'tiff';
            $valid_image_type['image/tiff'] = 'tiff';
            $valid_image_type['image/svg'] = 'svg';
            //$valid_image_type['image/ico'] = '';
            //$valid_image_type['image/icon'] = '';
            $valid_image_type['image/x-icon'] = 'ico';

            if (isset($valid_image_type[$type])) {
                $returnA["status"] = true;
                $returnA["type"] = $valid_image_type[$type];
            }
        }
        return $returnA;
    }

    public static function isValidImageUrl2($url) {
        $returnA = ["status" => false, "type" => ""];
        $url_headers = get_headers(trim($url), 1);
        if (isset($url_headers['Content-Type'])) {

            $type = strtolower($url_headers['Content-Type']);

            $valid_image_type = array();
            $valid_image_type['image/png'] = 'png';
            $valid_image_type['image/jpg'] = 'jpg';
            $valid_image_type['image/jpeg'] = 'jpeg';
            $valid_image_type['image/jpe'] = 'jpeg';
            $valid_image_type['image/gif'] = 'gif';
            $valid_image_type['image/tif'] = 'tiff';
            $valid_image_type['image/tiff'] = 'tiff';
            $valid_image_type['image/svg'] = 'svg';
            //$valid_image_type['image/ico'] = '';
            //$valid_image_type['image/icon'] = '';
            $valid_image_type['image/x-icon'] = 'ico';

            if (isset($valid_image_type[$type])) {
                $returnA["status"] = true;
                $returnA["type"] = $valid_image_type[$type];
            }
        }
        return $returnA;
    }

}
