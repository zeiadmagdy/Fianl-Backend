<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    | Set some default values. It is possible to add all defines that can be set
    | in dompdf_config.inc.php. You can also override the entire config file.
    |
    */
    'show_warnings' => false,   // Throw an Exception on warnings from dompdf

    'public_path' => null,  // Override the public path if needed

    /*
     * Dejavu Sans font is missing glyphs for converted entities, turn it off if you need to show € and £.
     */
    'convert_entities' => true,

    'options' => [
        /**
         * The location of the DOMPDF font directory
         *
         * The location of the directory where DOMPDF will store fonts and font metrics
         * Note: This directory must exist and be writable by the webserver process.
         * *Please note the trailing slash.*
         */
        'font_dir' => public_path('fonts'), // Path to your fonts directory in the public folder

        /**
         * The location of the DOMPDF font cache directory
         *
         * This directory contains the cached font metrics for the fonts used by DOMPDF.
         * This directory can be the same as DOMPDF_FONT_DIR
         *
         * Note: This directory must exist and be writable by the webserver process.
         */
        'font_cache' => storage_path('fonts'), // Cache directory for fonts

        /**
         * The location of a temporary directory.
         *
         * The directory specified must be writeable by the webserver process.
         * The temporary directory is required to download remote images and when
         * using the PDFLib back end.
         */
        'temp_dir' => sys_get_temp_dir(),

        /**
         * dompdf's "chroot": Prevents dompdf from accessing system files or other
         * files on the webserver.  All local files opened by dompdf must be in a
         * subdirectory of this directory.  DO NOT set it to '/' since this could
         * allow an attacker to use dompdf to read any files on the server.  This
         * should be an absolute path.
         */
        'chroot' => realpath(base_path()),

        /**
         * Protocol whitelist
         *
         * Protocols and PHP wrappers allowed in URIs, and the validation rules
         * that determine if a resource may be loaded. Full support is not guaranteed
         * for the protocols/wrappers specified by this array.
         */
        'allowed_protocols' => [
            'file://' => ['rules' => []],
            'http://' => ['rules' => []],
            'https://' => ['rules' => []],
        ],

        /**
         * Operational artifact (log files, temporary files) path validation
         */
        'artifactPathValidation' => null,

        /**
         * @var string
         */
        'log_output_file' => null,

        /**
         * Whether to enable font subsetting or not.
         */
        'enable_font_subsetting' => false,

        /**
         * The PDF rendering backend to use
         *
         * Valid settings are 'PDFLib', 'CPDF' (the bundled R&OS PDF class), 'GD' and
         * 'auto'. 'auto' will look for PDFLib and use it if found, or if not it will
         * fall back on CPDF. 'GD' renders PDFs to graphic files.
         */
        'pdf_backend' => 'CPDF',

        /**
         * html target media view which should be rendered into pdf.
         */
        'default_media_type' => 'screen',

        /**
         * The default paper size.
         */
        'default_paper_size' => 'a4',

        /**
         * The default paper orientation.
         */
        'default_paper_orientation' => 'portrait',

        /**
         * The default font family
         *
         * Used if no suitable fonts can be found. This must exist in the font folder.
         */
        'default_font' => 'serif',

        /**
         * Image DPI setting
         */
        'dpi' => 96,

        /**
         * Enable embedded PHP
         */
        'enable_php' => false,

        /**
         * Enable inline JavaScript
         */
        'enable_javascript' => true,

        /**
         * Enable remote file access
         */
        'enable_remote' => true,

        /**
         * List of allowed remote hosts
         */
        'allowed_remote_hosts' => null,

        /**
         * A ratio applied to the fonts height to be more like browsers' line height
         */
        'font_height_ratio' => 1.1,

        /**
         * Use the HTML5 Lib parser
         */
        'enable_html5_parser' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Fonts
    |--------------------------------------------------------------------------
    |
    | Define your custom fonts here.
    |
    */
    'font' => [
        'cairo' => [  // 'cairo' is the font name you will use in the Blade file
            'normal' => public_path('fonts/Cairo-Regular.ttf'), // Path to regular font
            'bold' => public_path('fonts/Cairo-Bold.ttf'),      // Path to bold font
        ],
    ],
];
