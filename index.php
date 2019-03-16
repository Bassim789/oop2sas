<?php 
error_reporting(-1);
require 'utils.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>OOP 2 SAS compilator</title>
<link href="<?=to_img('/img/o2-logo.png')?>" rel="icon">
<meta name="theme-color" content="#272822">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<?php
to_css([
    '/style.min.css',
    '/codemirror/lib/codemirror.min.css', 
    '/codemirror/theme/monokai.css'
], 'server');
?>
</head>
<body>
<h1>OOP<strong>2</strong>SAS</h1>
<div class="buttons_box">
    <button class="button_source selected" example_name="hello">
        Hello word
    </button>
    <button class="button_source" example_name="example_calculator">
        Calculator
    </button>
    <button class="button_source" example_name="example_timer">
        Timer
    </button>
</div>
<div class="icon_clean_source" id="icon_clean_source_oop"><img src="<?=to_img('/img/cross.png')?>"></div>
<textarea id="oop_code" placeholder="Enter oop sas code..." style="display: none;"></textarea>
<div class="main_body">
    <div class="icon_clean_source" id="icon_clean_source"><img src="<?=to_img('/img/cross.png')?>"></div>
    <div class="main_part_wrapper">
        <div class="separator"></div><br>
        <textarea id="source_code" class="main_part" placeholder="Enter oop sas class..." style="display: none;"></textarea>
    </div>
    <div class="main_part_wrapper">
        <div class="separator"></div><br>
        <textarea id="compiled_code" class="main_part" placeholder="Get compiled sas code" style="display: none;"></textarea>
    </div>
</div>
<footer>
    <div class="separator"></div>
    by <a href="https://simergie.ch" target="_blanck">
        <img class="mini_logo" src="<?=to_img('/img/logo_simergie.png')?>"> Simergie</a>
    <br>
    Code on <a href="https://github.com/Bassim789/oop2sas" target="_blanck">
        <img class="mini_logo" src="<?=to_img('/img/github-logo.png')?>"> Github</a>
    <br>
    <?=Date('Y')?> 
</footer>
</body>
<?php
to_js([
    '/codemirror/lib/codemirror.min.js', 
    '/codemirror/placeHolder.js', 
    '/codemirror/code_mirror_mode_simple.js',
    '/codemirror/mode/oop2sas/oop2sas.js',
    '/oop2sas.js',
    '/code_mirror_helper.js',
    '/check_es6_support.js'
], 'server');
?>
<script>
const helper = new code_mirror_helper({
    mode: 'oop2sas',
    theme: 'monokai',
    compilator: new oop2sas()
})
helper.init_oop_code({
    textarea_id: 'oop_code',
    clean_btn_id: 'icon_clean_source_oop'
})
helper.init_textarea({
    source_id: 'source_code', 
    compiled_id: 'compiled_code',
    clean_btn_id: 'icon_clean_source'
})
<?php 
$path = dirname(__FILE__);
$ext_oop = '_run.sas';
$ext_class = '.oop2.sas';
?>
const examples = {
    hello: {
        oop: `<?=file_get_contents($path.'/example/'.'hello'.$ext_oop)?>`,
        oop_class: `<?=file_get_contents($path.'/example/'.'hello'.$ext_class)?>`
    },
    example_calculator: {
        oop: `<?=file_get_contents($path.'/example/'.'calculator'.$ext_oop)?>`,
        oop_class: `<?=file_get_contents($path.'/example/'.'calculator'.$ext_class)?>`
    },
    example_timer: {
        oop: `<?=file_get_contents($path.'/example/'.'timer'.$ext_oop)?>`,
        oop_class: `<?=file_get_contents($path.'/example/'.'timer'.$ext_class)?>`
    }
}
helper.set_default_source(examples.hello)

const button_source = document.querySelectorAll('.button_source')
Array.from(button_source).forEach(button => {
    button.addEventListener('click', event => {
        const elem = event.target
        Array.from(button_source).forEach(el => el.classList.remove('selected'))
        elem.classList.add('selected')
        const example_name = elem.getAttribute('example_name')
        helper.set_default_source(examples[example_name])
    })
})
</script>
</html>