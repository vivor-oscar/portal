<?php
// Loader wrapper: includes either the simple or fancy partial based on $LOADER_STYLE
// Default styles: 'simple' or 'fancy'. You can set $LOADER_STYLE before including this file.
if (empty($LOADER_STYLE)) $LOADER_STYLE = 'simple';
if ($LOADER_STYLE === 'fancy' && file_exists(__DIR__ . '/loader-fancy.php')) {
  include __DIR__ . '/loader-fancy.php';
} elseif (file_exists(__DIR__ . '/loader-simple.php')) {
  include __DIR__ . '/loader-simple.php';
}
