## [0.x.x] 2021-01-21


* Избавились от  подписки класса  `ItForFree\SimpleMVC\ExceptionHandler` (в его конструкторе вызовом функции [set_exception_handler](https://www.php.net/manual/ru/function.set-exception-handler.php)) на обработку всех ошибок, 
потому что  сигнатура его же метода `ExceptionHandle::handleException(\Exception $exception)`
не подразумевает обработку ошибок класса `Error` (к которым относятся напр. фатальные ошибки).

