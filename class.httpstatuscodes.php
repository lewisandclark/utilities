<?php 

class HTTPStatusCodes {

  private function return_status ( $status, $body ) {
    if ( !headers_sent() ) {
      header("HTTP/1.1 {$status}");
      switch ( (int) array_shift(explode(' ', $status)) ) {
        case 301:
        case 302:
        case 307:
          header("Location: {$body}");
          break;
      }
    } else {
      echo "{$status}\n\n";
    }
    if ( !empty($body) ) echo $body;
    exit();
  }

  /* 200s */
  public function ok ( $body = '' ) {
    HTTPStatusCodes::return_status('200 OK', $body);
  }

  public function created ( $body = '' ) {
    HTTPStatusCodes::return_status('201 Created', $body);
  }

  public function accepted ( $body = '' ) {
    HTTPStatusCodes::return_status('202 Accepted', $body);
  }

  public function no_content ( $body = '' ) {
    HTTPStatusCodes::return_status('204 No Content', '');
  }

  /* 300s */
  public function redirect ( $body = '' ) {
    HTTPStatusCodes::return_status('301 Moved Permanently', $body);
  }

  public function found ( $body = '' ) {
    HTTPStatusCodes::return_status('302 Found', $body);
  }

  public function not_modified ( $body = '' ) {
    HTTPStatusCodes::return_status('304 Not Modified', '');
  }

  public function temporary_redirect ( $body = '' ) {
    HTTPStatusCodes::return_status('307 Temporary Redirect', $body);
  }

  /* 400s */
  public function bad_request ( $body = '' ) {
    HTTPStatusCodes::return_status('400 Bad Request', $body);
  }

  public function unauthorized ( $body = '' ) {
    HTTPStatusCodes::return_status('401 Unauthorized', $body);
  }

  public function forbidden ( $body = '' ) {
    HTTPStatusCodes::return_status('403 Forbidden', $body);
  }

  public function not_found ( $body = '' ) {
    HTTPStatusCodes::return_status('404 Not Found', $body);
  }

  /* 500s */

  public function server_error ( $body = '' ) {
    HTTPStatusCodes::return_status('500 Internal Server Error', $body);
  }

  public function service_unavailable ( $body = '' ) {
    HTTPStatusCodes::return_status('503 Service Unavailable', $body);
  }

}

?>