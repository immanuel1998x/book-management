<?php

use App\Category;
use Illuminate\Support\Facades\File;

function dateTimeToString($dateTime) {
    $explodeDateTime = explode(' ', $dateTime);
    $date = $explodeDateTime[0];
    $time = $explodeDateTime[1];

    $stringDateTime = date('F d Y', strtotime($date)) . ' ' . date('h:i A', strtotime($time));

    return $stringDateTime;
}

function timeElapsedString($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' Ago' : 'Just Now';
}

function timeElapsedStringShortage($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'mo',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'min',
        's' => 'sec',
    );
    
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return implode(', ', $string);
}

function getCategoryName($categoryId) {
    $category = Category::find($categoryId);
    if ($category !== null) {
        return $category->name;
    } else {
        return 0;
    }
}

function uploadImage($request, $imageFile) {
    if ($imageFile !== 'default.jpeg') {
        $basename = pathinfo($imageFile, PATHINFO_FILENAME);
        $extension = pathinfo($imageFile, PATHINFO_EXTENSION);
    
        $imageName = time() . '_' . $basename . '.' . $extension;
        $uploadSuccess = $request->image->move(public_path('images/uploads'), $imageName);

        if ($uploadSuccess) {
            return $imageName;
        }
    }

    return $imageFile;
}

function removeImage($imageName) {
    if ($imageName !== 'default.jpeg') {
        $filename = public_path() . "/images/uploads/" . $imageName;
        if (file_exists($filename)) {
            unlink($filename);
        }
    }
}

function setDefaultImage() {
    $filename = public_path() . "/images/uploads/default.jpeg";
    if (!file_exists($filename)) {
        $defaultImage = resource_path() . "/images/default.jpeg";
        if (file_exists($defaultImage)) {
            $destination = public_path() . "/images/uploads/default.jpeg";
            File::copy($defaultImage, $destination);
        }
    }
}