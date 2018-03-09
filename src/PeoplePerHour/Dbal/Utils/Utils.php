<?php

function has_string_keys(array $array) {
  return count(array_filter(array_keys($array), 'is_string')) > 0;
}
