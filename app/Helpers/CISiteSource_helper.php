<?php

if (!function_exists('RunQueryJsCSSPage')) {
    function RunQueryJsCSSPage($aRR, $Type)
    {
        foreach ($aRR as $key => $x) {
            // dd($x);
            $uriWithDot = '.' . $x;

            if (!is_file($uriWithDot) || !file_exists($uriWithDot)) {
                $fp = fopen($uriWithDot, 'w');//w là xóa củ ghi mới, a: ghi tiếp nối file cũ

                if ($Type == 'css' && str_contains($x, '.freecontent_')) {
                    /*Đối với trường hợp Modules freecontent -> thì sẽ khởi tạo bằng file mẫu từ DefaultCode*/
                    $Link = '../private/DefaultCode/css/FreeContent/pri.freecontent.css';
                    $DefaultContent = file_get_contents($Link);
                } else {
                    $DefaultContent = '/*CI4Blog cdt*/';
                    // if ($Type == 'css' && $MainPageClass) {
                    //     $DefaultContent .= '.' . $MainPageClass . '{' . PHP_EOL . PHP_EOL . '}';
                    // }
                }

                fwrite($fp, $DefaultContent);
                fclose($fp);
            }

            if ($Type == 'css') {
                // $GLOBALS['Rocker']['CssTextPage'] .= '<link rel="stylesheet" type="text/css"  href="' . $x . '?v=' . VERSIONS . '"/>';
            } else {
                return '<script defer  type="text/javascript" src="' . $x . '"></script>';
            }
        }
    }
}