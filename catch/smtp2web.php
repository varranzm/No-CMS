<?php
  $from = $_POST['from'];
  $to = $_POST['to'];
  $plain_text = $_POST['plain'];

  $fp = fopen('logs','a');

  fwrite($fp,"Mail from $from to $to and $plain_text\n");

