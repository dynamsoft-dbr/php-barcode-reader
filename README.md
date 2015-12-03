# PHP Barcode Reader
The sample demonstrates how to make a Web Barcode Reader app with PHP, Nginx and Dynamsoft Barcode Reader SDK on Windows.

Prerequisites
-------------
* [Nginx][1]
* [PHP][2]
* [Dynamsoft Barcode Reader SDK][3]

How to Build PHP Custom Extension with Dynamsoft Barcode Reader SDK
-------------------------------------------------------------------
Please read [Making PHP Barcode Extension with Dynamsoft Barcode SDK][4] to learn how to build **php_dbr.dll**.

How to Configure PHP Environment
---------------------------------
1. Copy **php_dbr.dll** to **%php%\ext**.
2. Copy **DynamsoftBarcodeReaderx86.dll** to PHP root directory **%php%\**.
3. Open **%php%\php.ini** and add following line:

    ```
    extension=php_dbr.dll
    ```
    Change max file size if you want to upload big image files:

    ```
    upload_max_filesize=20M
    ```

How to Configure Nginx for PHP
-------------------------------------------------------
1. Open **%nginx%\conf\nginx.conf** and add PHP configuration:

    ```
    location ~ \.php$ {
        root           html;
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME <Your Web App Folder>/$fastcgi_script_name;
        include        fastcgi_params;
    }
    ```
    When uploading big files, you may see the error **nginx 413 Request Entity Too Large**. To fix it, change file size in configuration file:

    ```
    client_max_body_size 50M;
    ```

How to Run the PHP Barcode App
------------------------------
1. Run **php-cgi**:

    ```
    %php%\php-cgi.exe -b 127.0.0.1:9000 -c %php%\php.ini
    ```
2. Run **Nginx**:

    ```
    %nginx%\nginx.exe
    ```
3. Visit ``localhost:8080/index.php``
    ![load barcode image](http://www.codepool.biz/wp-content/uploads/2015/11/php_dbr_upload.png)

    ![read barcode](http://www.codepool.biz/wp-content/uploads/2015/11/php_dbr_result.png)

Reference
---------
* http://rfvallina.com/blog/2015/08/22/preview-tiff-and-pdf-files-using-html5-file-api/

Blog
------
[How to Create a Web Barcode Reader App with PHP and Nginx][5]

[1]:http://nginx.org/en/download.html
[2]:http://php.net/downloads.php
[3]:http://www.dynamsoft.com/Downloads/Dynamic-Barcode-Reader-Download.aspx
[4]:http://www.codepool.biz/php-windows-barcode-reader-extension.html
[5]:http://www.codepool.biz/php-nginx-web-barcode-reader.html
