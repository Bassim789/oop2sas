<?php
function to_css($files, $mode){
    $path = dirname(__FILE__);
    foreach ($files as $file) {
        if($mode == 'server'){
            echo '<style>'.file_get_contents($path.$file).'</style>';
        } else {
            echo '<link href="'.$file.'?v='.time().'" rel="stylesheet">';
        }
    }
}
function to_js($files, $mode){
    $path = dirname(__FILE__);
    foreach ($files as $file) {
        if($mode == 'server'){
            echo '<script>'.file_get_contents($path.$file).'</script>';
        } else {
            echo '<script src="'.$file.'?v='.time().'"></script>';
        }
    }
}
function to_img($file){
    $path = dirname(__FILE__).$file;
    $imageData = base64_encode(file_get_contents($path));
    echo 'data: '.mime_content_type($path).';base64,'.$imageData;
}