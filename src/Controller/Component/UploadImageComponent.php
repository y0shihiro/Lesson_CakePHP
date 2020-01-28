<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Filesystem\File;
use RuntimeException;

class UploadImageComponent extends Component
{
    /**
     * Undocumented function
     *
     * @param [type] $file アップロードしたファイル情報
     * @param [type] $dir ファイルを保存するフォルダ
     * @param [type] $limitFileSize 保存出来るファイルサイズの最大値
     * @return mixed
     */
    public function fileUpload($file = null, $dir = null, $limitFileSize = 1024 * 1024)
    {
        try {
            // ファイルを保存するフォルダ $dirの値のチェック
            if ($dir) {
                if (!file_exists($dir)) {
                    throw new RuntimeException('指定のディレクトリがありません。');
                }
            } else {
                throw new RuntimeException('ディレクトリの指定がありません。');
            }

            // 未定義、複数ファイル、破損攻撃のいずれかの場合は無効処理
            if (!isset($file['error']) || is_array($file['error'])) {
                throw new RuntimeException('Invalid parameters.');
            }

            // エラーのチェック
            switch ($file['error']) {
                case 0:
                    break;
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException('No file sent.');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('Exceeded filesize limit.');
                default:
                    throw new RuntimeException('Unknown errors.');
            }

            // ファイル情報取得
            $fileInfo = new File($file["tmp_name"]);

            // ファイルサイズのチェック
            if ($fileInfo->size() > $limitFileSize) {
                throw new RuntimeException('Exceeded filesize limit.');
            }

            // ファイルタイプのチェックし、拡張子を取得
            if (false === $ext = array_search(
                $fileInfo->mime(),
                ['jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif', ],
                true
            )) {
                throw new RuntimeException('Invalid file format.');
            }

            // ファイル名の生成
            // sha1_file()でハッシュ化
            $uploadFile = sha1_file($file["tmp_name"]) . "." . $ext;

            // ファイルの移動
            if (!move_uploaded_file($file["tmp_name"], $dir . "/" . $uploadFile)) {
                throw new RuntimeException('Failed to move uploaded file.');
            }

            // 処理を抜けたら正常終了
            // echo 'File is uploaded successfully.';
        } catch (RuntimeException $e) {
            throw $e;
        }

        return $uploadFile;
    }
}
