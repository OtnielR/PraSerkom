<?php

class FileUtils
{
    private static array $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
    private static int $megabyte = 1024 * 1024;

    public static function storeImage(string $file): array
    {
        if (isset($_FILES[$file]) && $_FILES[$file]["error"] == UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES[$file]["tmp_name"];
            $fileName = $_FILES[$file]["name"];
            $fileSize = $_FILES[$file]["size"];
            $fileExtension = strtolower(explode(".", $fileName)[1]);

            if (!in_array($fileExtension, self::$allowedImageExtensions)) {
                return ["status" => false, "message" => "File type is not allowed"];
            }

            if ($fileSize > 2 * self::$megabyte) {
                return ["status" => false, "message" => "File size is exceeding 2MB"];
            }

            $uploadDirectory = __BASEPATH__ . "/public/uploads/";
            $newFileName = uniqid("img_", true) . "." . $fileExtension;
            $relativePathFile = "/public/uploads/" . $newFileName;

            if (is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }

            $destination = $uploadDirectory . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destination)) {
                return ["status" => "success", "message" => "File moved successfully", "path" => $relativePathFile];
            }

            return ["status" => false, "message" => "Error moving file"];
        }

        return ["status" => false, "message" => "File Null"];
    }
}

