$fname=$_GET['fname'];
$fsize=filesize('secret_data/'.$fname);

Header("HTTP/1.1 200 OK");
Header("Connection: close");
Header("Content-Type: application/octet-stream");
Header("Accept-Ranges: bytes");
Header("Content-Disposition: Attachment; filename=".$fname);
Header("Content-Length: ".$fsize);

// Открыть файл для чтения и отдавать его частями
$f=fopen('secret_data/'.$fname,'r');
while (!feof($f)) {
  // Если соединение оборвано, то остановить скрипт
  if (connection_aborted()) {
    fclose($f);
    break;
  }
  echo fread($f,10000);
  // Пазуа в 1 секунду. Скорость отдачи 10000 байт/сек
  sleep(1);
}
fclose($f);