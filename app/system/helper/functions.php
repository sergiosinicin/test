<?php


use App\System\Library\Image;

function dd()
{
    echo '<pre>';
    array_map(function ($x) {
        var_dump($x);
    }, func_get_args());
    print_r(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS), true);
    echo '</>';
    die;
}

/**
 * @param  array  $propertyData
 * @return array
 */
function saveImageByUrl(array $propertyData)
{
    $subFolder = str_replace(' ', '_', $propertyData['town']);
    $dir = getImageDir($subFolder);

    $fileName = md5($propertyData['image_full']).'.jpg';
    if (!file_exists($dir.$fileName)) {
        $file = file_get_contents($propertyData['image_full']);
        file_put_contents($dir.$fileName, $file);
    }

    if (!file_exists($dir.md5($propertyData['image_full']).'x100x100.jpg')) {
        $result = resizeImage($dir, md5($propertyData['image_full']), 'jpg');
    }

    if (empty($result['error'])) {
        $propertyData['image_thumbnail'] = '/images/'.$subFolder.'/'.md5($propertyData['image_full']).'x100x100.jpg';
        $propertyData['image_full'] = '/images/'.$subFolder.'/'.$fileName;
    }

    return $propertyData;
}

/**
 * @param $dir
 * @param $fileName
 * @param  string  $ext
 * @return array|bool
 */
function resizeImage($dir, $fileName, $ext = 'jpg')
{
    try {
        $image = new Image($dir.$fileName.'.'.$ext);
        $image->resize(100, 100, 'h');
        $image->save($dir.$fileName.'x100x100.'.$ext);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    return true;
}

/**
 * @param  array  $propertyData
 * @return array|string
 */
function saveUploadedImage(array $propertyData)
{
    if (isset($_FILES["image_full"]) && $_FILES["image_full"]["error"] == 0) {
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["image_full"]["name"];
        $filetype = $_FILES["image_full"]["type"];
        $filesize = $_FILES["image_full"]["size"];

        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) {
            return "Error: Please select a valid file format.";
        }

        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if ($filesize > $maxsize) {
            return "Error: File size is larger than the allowed limit.";
        }
        $subFolder = str_replace(' ', '_', $propertyData['town']);
        $dir = getImageDir($subFolder);
        // Verify MYME type of the file
        if (in_array($filetype, $allowed)) {
            // Check whether file exists before uploading it
            if (file_exists($dir.md5($filename).'.'.$ext)) {
                return $filename." is already exists.";
            } else {

                move_uploaded_file($_FILES["image_full"]["tmp_name"], $dir.md5($filename).'.'.$ext);
                resizeImage($dir, md5($filename), $ext);

                $propertyData['image_thumbnail'] = '/images/'.$subFolder.'/'.md5($filename).'x100x100.'.$ext;
                $propertyData['image_full'] = '/images/'.$subFolder.'/'.md5($filename).'.'.$ext;


            }
        } else {
            return "Error: There was a problem uploading your file. Please try again.";
        }
    }

    return $propertyData;
}

/**
 * @param  string  $subFolder
 * @return string
 */
function getImageDir($subFolder = '')
{
    $subFolder = 'images/'.str_replace(' ', '_', trim($subFolder, '/')).'/';
    $dir = DIR_PUBLIC.$subFolder;
    if (!file_exists($dir)) {
        mkdir($dir, 0755, true);
    }

    return rtrim($dir, '/').'/';
}

function generateUUID()
{
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}
