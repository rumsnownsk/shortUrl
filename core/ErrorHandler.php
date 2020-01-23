<?php

namespace core;

use PDOException;

class ErrorHandler
{
    public function __construct()
    {
        if (DEBUG) {
            ini_set('display_errors', 1);
            error_reporting(-1);
        } else {
            error_reporting(0);
        }

        set_error_handler([$this, 'errorHandler']);

        ob_start();
        register_shutdown_function([$this, 'fatalErrorHandler']);
        set_exception_handler([$this, 'exceptionHandler']);
    }


    // Обработка НЕ ФАТАЛЬНЫХ ошибок типа Notice или Warning
    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        $this->logErrors($errstr, $errfile, $errline);

        if (DEBUG || in_array($errno, [E_USER_ERROR, E_RECOVERABLE_ERROR])){
            $this->myDisplayError($errno, $errstr, $errfile, $errline);
        }

        return true;
    }


    // Обработка ошибок типа Fatal Error
    public function fatalErrorHandler()
    {
        $error = error_get_last();  //

        if (!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)) {

            $this->logErrors($error['message'], $error['file'], $error['line']);

            ob_end_clean();

            $this->myDisplayError($error['type'], $error['message'], $error['file'], $error['line']);

        } else {
            ob_end_flush();
        }
    }


    // Обработка ошибок типа Exception
    public function exceptionHandler($e)
    {
        if($e instanceof PDOException){

            $this->logErrors($e->getMessage(), $e->getFile());

//            $this->myDisplayError(
//                $e->getCode() . '.  Error type - PDOException!',
//                $e->getMessage(),
//                $e->getFile(),
//                "Похоже ошибка подключения к Базе Данных. Проверьте настройки в файле /core/db.php"
//            );
            echo json_encode([
                'code' => 500,
                'message' => "Похоже ошибка подключения к Базе Данных. Проверьте настройки в файле /core/db.php"
            ], JSON_UNESCAPED_UNICODE);die;
        };


        $this->logErrors($e->getMessage(), $e->getFile(), $e->getLine());

        $this->myDisplayError('error type - Exception!', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
    }


    protected function myDisplayError($errno, $errstr, $errfile, $errline, $response = 500)
    {
        http_response_code($response);

        if ($response == 404 && !DEBUG){
            require APP.'/views/errors/404.php';
            die;
        }

        if (DEBUG) {
            require APP.'/views/errors/dev.php';
        } else {
            require APP.'/views/errors/prod.php';
        }
        die;
    }


    public function logErrors($message = '', $file = '', $line = '')
    {
        if(!file_exists(ROOT."/temp")){
            mkdir(ROOT."/temp", 0777, true);
            chmod(ROOT."/temp", 0777);

            $fp = fopen(ROOT . "/temp/errors.log", "w");
            fwrite($fp, "!!!is begin!!!\n=======================\n");
            fclose($fp);
            chmod(ROOT . "/temp/errors.log", 0777);
        };
        error_log("[" . date('Y-m-d H:i:s') . "]; Текст: {$message} | Файл: {$file} | Строка: {$line} \n=======================\n",
            3,
            ROOT . "/temp/errors.log");
    }

}

new ErrorHandler();