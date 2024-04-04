<?php
defined('BASEPATH') OR exit('No direct script access allowed');
set_status_header(404);
throwError(REQUEST_NOT_FOUND);
exit();
