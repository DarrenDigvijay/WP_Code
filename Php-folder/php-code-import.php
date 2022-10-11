<?php

namespace SPI\Plugins\Importer\Scripts;

use Box\Spout\Reader;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use SPI\Plugins\Importer\Helper;
use SPI\Plugins\Importer\Map;
use WP_CLI;

class ImportPosts
{
    const ATTACHMENT_META_KEY = '_news_media_old_url';

    /**
     * Map sheet's columns with wp's desired keys
     *
     * ## OPTIONS
     *
     * [--yes]
     * : Don't ask for confirmation.
     *
     * [--update-existing]
     * : Don't skip but update existing posts [checks using slug(post_title)].
     *
     * [--add-existing-title-as-new]
     * : Insert new post even if it already exists acc. to slug(post_title) passed.
     *
     * <file-path>
     * : Full file path with extension .xlsx
     *
     * ---
     * ## EXAMPLES
     *     wp spi-mapping /path/to/file/filename.xlsx
     * ---
     *
     * @see http://opensource.box.com/spout/guides/read-data-from-specific-sheet/
     * @when after_wp_load
     *
     * @param $args
     * @param $assoc_args
     */
    public function __invoke($args, $assoc_args)
    {
        WP_CLI::confirm(WP_CLI::colorize('%_Are you sure you want to execute?%n'), $assoc_args);

        list($filePath) = $args;

        if (!is_readable($filePath)) {
            WP_CLI::error('Supplied file not found : ' . $filePath);
            return;
        }

        // Allow Spout to guess the reader type based on the file extension (.csv, .ods, .xlsx - lower/uppercase)
        try {
            $reader = ReaderEntityFactory::createReaderFromFile($filePath);
            $reader->open($filePath);
        } catch (\Exception $e) {
            WP_CLI::error('Supported File extensions are : .csv, .ods and .xlsx');
            return;
        }

        $updateExistingPosts = isset($assoc_args['update-existing']);
        $addExistingTitleAsNew = isset($assoc_args['add-existing-title-as-new']);

        foreach ($reader->getSheetIterator() as $sheet) {
            if ($sheet->getName() === Map::SheetName_Post) {
                WP_CLI::line(" Reading '" . $sheet->getName() . "' rows... ");

                $this->loopPostRows($sheet, $updateExistingPosts, $addExistingTitleAsNew);

                WP_CLI::line(" Completed reading '" . $sheet->getName() . "' Sheet rows. ");
                break; // no need to read more sheets
            }
        }

        $reader->close();

        WP_CLI::success(date("y-m-d h:i:s") . ' Operations ran!');
    }

    /**
     * @param $sheet Reader\IteratorInterface | Reader\XLSX\Sheet | Reader\ODS\Sheet | Reader\CSV\Sheet To iterate over sheets
     * @param bool $updateExistingPosts
     * @param bool $addExistingTitleAsNew
     */
    protected function loopPostRows($sheet, $updateExistingPosts = false, $addExistingTitleAsNew = false)
    {
        $inserted = 0;
        $defaults = Map::getDefaults();

        foreach ($sheet->getRowIterator() as $index => $row) {


            if ($index === 1) {
                continue;
            }

            if ($index % 50 === 0) {
                WP_CLI::line(WP_CLI::colorize('%b' . date("y-m-d h:i:s") . ' Processed upto rows: ' . $index));
            }

            $rowData = Helper::getCleanArray($row->toArray());
            $map = Map::getMappings($rowData);

            $postData = $this->preparePostData($defaults, $map);

            $postID = wp_insert_post($postData['post_args'], true);

            if (!is_wp_error($postID)) {
                $inserted++;

                if (count($postData['tax_input'])) {
                    foreach ($postData['tax_input'] as $tax => $terms) {
                        wp_set_object_terms($postID, $terms, $tax);
                    }
                }

                if (count($postData['acf_fields'])) {
                    foreach ($postData['acf_fields'] as $name => $value) {
                        update_field(Map::acfNameKeyPair()[$name], $value, $postID);
                    }
                }

                $attachmentID = $this->downloadAndStoreMedia($postData['attachment']);

                if (!empty($attachmentID)) {
                    echo "Post ID is here ".$postID."\n";
                    set_post_thumbnail($postID, $attachmentID);
                }

            }

        }

        WP_CLI::success(date("y-m-d h:i:s") . ' Post rows looped successfully!' . ' Posts inserted = ' . $inserted);
    }

    protected function preparePostData($defaults, $map)
    {
        $postData = [
            'post_args' => [
                'meta_input' => [],
            ],
            'attachment' => '',
            'tax_input' => [],
            'acf_fields' => [],
        ];

        if (!empty($map['attachment'])) {
            $postData['attachment'] = $map['attachment'];
        }

        if (!empty($defaults['wp'])) {
            $postData['post_args'] = array_merge($postData['post_args'], $defaults['wp']);
        }

        if (!empty($map['wp'])) {
            $postData['post_args'] = array_merge($postData['post_args'], $map['wp']);
        }

        if (!empty($defaults['taxonomy'])) {
            $postData['tax_input'] = array_merge($postData['tax_input'], $defaults['taxonomy']);
        }

        if (!empty($map['taxonomy'])) {
            $postData['tax_input'] = array_merge($postData['tax_input'], $map['taxonomy']);
        }

        if (!empty($defaults['meta'])) {
            $postData['post_args']['meta_input'] = array_merge($postData['post_args']['meta_input'], $defaults['meta']);
        }

        if (!empty($map['meta'])) {
            $postData['post_args']['meta_input'] = array_merge($postData['post_args']['meta_input'], $map['meta']);
        }

        if (!empty($defaults['acf'])) {
            $postData['acf_fields'] = array_merge($postData['acf_fields'], $defaults['acf']);
        }

        if (!empty($map['acf'])) {
            $postData['acf_fields'] = array_merge($postData['acf_fields'], $map['acf']);
        }

        return $postData;
    }

    protected function downloadAndStoreMedia($fileUrl)
    {
        if (empty($fileUrl)) {
            WP_CLI::line(WP_CLI::colorize('%yWARN: skip empty image url - ' . $fileUrl));
            return false;
        }

        $fileName = basename($fileUrl).'.jpg';
        $path = plugin_dir_path(SPI_BASE_FILE) . 'resources/course-attachments/' . str_replace('square','Square',$fileName);

        if (!file_exists($path)) {
            WP_CLI::line(WP_CLI::colorize('%yWARN: file not found - ' . $path));
            return false;
        }

        // read as binary file
        $handle = fopen($path, "rb");
        $contents = fread($handle, filesize($path));
        fclose($handle);

        $uploadedMedia = wp_upload_bits($fileName, null, $contents);

        if (!empty($uploadedMedia['error'])) {
            WP_CLI::line(WP_CLI::colorize('%rError uploading file to WP - ' . $uploadedMedia['error']));
            return false;
        }

        WP_CLI::line(WP_CLI::colorize('%gSuccess:File was stored at path -' . str_replace('square','Square',$uploadedMedia['file'])));

        // Adding image/pdf to media library
        $attachmentID = wp_insert_attachment(
            [
                'post_mime_type' => wp_check_filetype($fileName, null)['type'],
                'post_title' => sanitize_title($fileName),
                'post_content' => '',
                'post_status' => 'inherit',
            ],
            $uploadedMedia['file'], 0, true);

        if (is_wp_error($attachmentID)) {
            WP_CLI::line(WP_CLI::colorize('%rError inserting attachment for url: ' . $fileUrl));
            return false;
        }

        // Generate the thumbnails and other meta for image files
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attachData = wp_generate_attachment_metadata($attachmentID, $uploadedMedia['file']);
        wp_update_attachment_metadata($attachmentID, $attachData);

        return $attachmentID;
    }

}