<?php
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function localUploadImage($file, $folder, $file_prefix, $max_width = false)
{
    $allowed_ext = ["png", "jpg", "gif", 'jpeg'];
    $folder_name = "uploads/images/$folder/" . date("Ym/d", time());
    $upload_path = public_path() . '/' . $folder_name;
    $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
    $filename = $file_prefix . '_' . time() . '_' . str_random(10) . '.' . $extension;
    if (!in_array($extension, $allowed_ext)) {
        return false;
    }
    $file->move($upload_path, $filename);
    if ($max_width && $extension != 'gif') {
        imageReduceSize($upload_path . '/' . $filename, $max_width);
    }

    return [
        'path' =>  "$folder_name/$filename"
    ];
}

function imageReduceSize($file_path, $max_width)
{
    // 先实例化，传参是文件的磁盘物理路径
    $image = \Image::make($file_path);

    // 进行大小调整的操作
    $image->resize($max_width, null, function ($constraint) {
        // 设定宽度是 $max_width，高度等比例双方缩放
        $constraint->aspectRatio();
        // 防止裁图时图片尺寸变大
        $constraint->upsize();
    });
    // 对图片修改后进行保存
    $image->save();
}
