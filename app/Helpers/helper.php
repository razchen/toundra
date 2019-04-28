<?php

function uploadImage($file, $name, $thumb_width, $thumb_height, $tmp_path, $thumb_path, $crop = false, $crop_path = false,$maintain_ratio = false,$force_ending = false) {
    $ret = array();

    $ending = $file->getClientOriginalExtension();

    $allowedtypes = array(
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
    );

    if (!in_array($ending,array_keys($allowedtypes))) {
        $ret['error'] = 'Only .jpg/jpeg or .png files are supported.';
        return $ret;
    }

    if ($file->getSize() > 5000000) {
        $ret['error'] = 'A maximum size of 5MB for an picture is allowed.';
        return $ret;
    }

    if (!$file->isValid())
    {
        $ret['error'] = 'File is not valid.';
        return $ret;
    }

    $filename = $name . '.' . $ending;
    $temp_target_path = $tmp_path . $filename;

    $file->move(public_path().$tmp_path, $filename);

    if ($ending == 'jpg' || $ending == 'jpeg') {
        $img = imagecreatefromjpeg(public_path().$temp_target_path);
    } elseif ($ending == 'png') {
        $img = imagecreatefrompng(public_path().$temp_target_path);
    }

    if ($force_ending) {
        $filename = $name . '.' . $force_ending;
    }

    $width = imagesx($img);
    $height = imagesy($img);

    if ($maintain_ratio) {
        $ratio = $width/$height;

        if( $ratio < 1) {
            $thumb_width = $thumb_width;
            $thumb_height = $thumb_width/$ratio;
        }
        else {
            $thumb_width = $thumb_width*$ratio;
            $thumb_height = $thumb_height;
        }
    }

    if ($crop) {
        if ($width > $height) {
            /* Horizontal */
            $new_width = $width;
            $new_height = $width / 16 * 9;

            if ($new_height > $height) {
                /* Height is too short */
                $new_width = $width / 9 * 16;;
                $new_height = $height;
            }
        } else {
            /* Vertical */
            $new_width = $width;
            $new_height = $width / 2 * 3;

            if ($new_height > $height) {
                /* Height is too short */
                $new_width = $width / 3 * 2;
                $new_height = $height;
            }
        }

        $x = round(abs($width - $new_width) / 2);
        $y = round(abs($height - $new_height) /2);

        $new_frame = imagecreatetruecolor($new_width, $new_height);

        imagecolortransparent($new_frame, imagecolorallocatealpha($new_frame, 0, 0, 0, 127));
        imagealphablending($new_frame, false);
        imagesavealpha($new_frame, true);

        imagecopyresampled($new_frame, $img, 0, 0, $x, $y, $new_width, $new_height, $new_width, $new_height);

        if ($ending == 'jpg' || $ending == 'jpeg') {
            imagejpeg($new_frame, public_path().$crop_path.$filename, 100);
        } elseif ($ending == 'png') {
            imagepng($new_frame, public_path().$crop_path.$filename);
        }

        $ret['crop_path'] = $crop_path.$filename;
    }

    $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
    /* Transparency */
    imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
    imagealphablending($thumb, false);
    imagesavealpha($thumb, true);
    imagecopyresampled($thumb, $img, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);

    if ($ending == 'jpg' || $ending == 'jpeg') {
        imagejpeg($thumb, public_path().$thumb_path.$filename, 100);
    } elseif ($ending == 'png') {
        imagepng($thumb, public_path().$thumb_path.$filename);
    }

    $ret['file'] = $filename;
    $ret['path'] = $thumb_path.$filename;

    return $ret;
}

function resizeImage($filename,$new_filename,$img_path,$new_img_path,$new_width,$new_height,$maintain_ratio = false) {
    if (strstr($filename,'jpg') || strstr($filename,'jpeg')) {
        $img = imagecreatefromjpeg(public_path().$img_path.$filename);
    } elseif (strstr($filename,'png')) {
        $img = imagecreatefrompng(public_path().$img_path.$filename);
    }

    $width = imagesx($img);
    $height = imagesy($img);

    if ($maintain_ratio) {
        $ratio = $width/$height;

        if( $ratio < 1) {
            $new_width = $new_width;
            $new_height = $new_width/$ratio;
        }
        else {
            $new_width = $new_width*$ratio;
            $new_height = $new_height;
        }
    }

    $new_img = imagecreatetruecolor($new_width, $new_height);
    /* Transparency */
    imagecolortransparent($new_img, imagecolorallocatealpha($new_img, 0, 0, 0, 127));
    imagealphablending($new_img, false);
    imagesavealpha($new_img, true);
    imagecopyresampled($new_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    if (strstr($filename,'jpg') || strstr($filename,'jpeg')) {
        imagejpeg($new_img, public_path().$new_img_path.$new_filename, 100);
    } elseif (strstr($filename,'png')) {
        imagepng($new_img, public_path().$new_img_path.$new_filename);
    }

    $ret['file'] = $new_filename;
    $ret['path'] = $new_img_path.$new_filename;

    return $ret;
}

function upload3DFile($file, $name, $path) {
    $ret = array();

    $ending = $file->getClientOriginalExtension();

    $allowedtypes = array(
        'stl' => 'application/sla',
    );

    $filename = $name . '.' . $ending;

    $file->move(public_path().$path, $filename);
    $ret['file'] = $filename;
    return $ret;
}

function validate3DFile($file) {
    if ($file) {
        $ending = $file->getClientOriginalExtension();

        $allowedtypes = array(
            'stl' => 'application/sla',
        );

        if (!in_array($ending,array_keys($allowedtypes))) {
            return redirect()->back()->withInput()->withErrors(['Only .stl files are supported.']);
        } elseif ($file->getSize() > 20000000) {
            return redirect()->back()->withInput()->withErrors(['A maximum size of 20MB is allowed.']);
        } elseif (!$file->isValid()) {
            return redirect()->back()->withInput()->withErrors(['File is not valid.']);
        }
    }
}

function add3DFile($three_d_id) {
    if ($three_d_id && request()->hasFile('3dfile')) {
        DB::table('three_d_files')->where('three_d_id',$three_d_id)->delete(); 
        $ret = upload3DFile(request()->file('3dfile'), generateRandomString(), '/stls'); 
        if ($three_d_id) {
            DB::table('three_d_files')->insert([
                'three_d_id' => $three_d_id,
                'filename' => $ret['file']
            ]);    
        }
    }
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function generateRandomAlphaString($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyz';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function getIpAddress()
{
    $ip_address = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ip_address = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ip_address = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ip_address = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ip_address = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ip_address = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ip_address = getenv('REMOTE_ADDR');
    else
        $ip_address = '';

    if ($ip_address == '179.5.103.124' || $ip_address == '127.0.0.1' || $ip_address == '179.51.1.84' || $ip_address == '213.57.58.215')
        $ip_address = '23.245.255.255';
        //$ip_address = '5.178.111.255';


    return $ip_address;
}