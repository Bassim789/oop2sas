<?php 
error_reporting(-1);
require 'utils.php';
$path = dirname(__FILE__);
$examples = [];
$example_names = ['hello', 'calculator', 'timer'];
foreach ($example_names as $key => $name) {
    $examples[$name] = [
        'oop' => file_get_contents($path.'/example/'.$name.'/'.$name.'_use.sas'),
        'oop_class' => file_get_contents($path.'/example/'.$name.'/'.$name.'.oop2.sas'),
        'oop_doc' => file_get_contents($path.'/example/'.$name.'/'.$name.'_doc.txt')
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>OOP 2 SAS compilator</title>
<meta charset="utf-8">
<meta description="OOP 2 SAS compilator">
<link href="<?=to_img('/img/o2-logo.png')?>" rel="icon">
<meta name="theme-color" content="#272822">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<?php
to_css([
    '/style.css',
    '/codemirror/lib/codemirror.min.css', 
    '/codemirror/theme/monokai.css'
], 'server');
?>
</head>
<body>
<div class="full_body">
    <h1>OOP<strong>2</strong>SAS</h1>
    <h2>Bring OOP style to SAS</h2>
    <div class="buttons_box">
        Examples: 
        <?php 
        $selected = 'selected';
        foreach ($example_names as $key => $name) { ?>
            <button class="button_source <?=$selected?>" example_name="<?=$name?>">
                <?=$name?>
            </button>
        <?php 
            $selected = '';
        } ?>
    </div>
    <div class="main_body_oop">
        <div class="main_part_wrapper">
            <div class="separator"></div><br>
            <div class="icon_clean" id="icon_clean_source_oop"><img src="<?=to_img('/img/cross.png')?>" alt="cross icon"></div>
            <div class="section_title">Module usage</div>
            <textarea id="oop_code" class="main_part" placeholder="Enter oop sas code..." style="display: none;"></textarea>
        </div>
        <div class="main_part_wrapper">
            <div class="separator"></div><br>
            <div class="icon_clean" id="icon_clean_doc"><img src="<?=to_img('/img/cross.png')?>" alt="cross icon"></div>
            <div class="section_title">Module documentation</div>
            <textarea id="oop_doc" class="main_part" placeholder="Enter oop sas doc..." style="display: none;"></textarea>
        </div>
    </div>
    <div class="main_body">
        <div class="main_part_wrapper">
            <div class="separator"></div><br>
            <div class="icon_clean" id="icon_clean_source"><img src="<?=to_img('/img/cross.png')?>" alt="cross icon"></div>
            <div class="section_title">OOP style module</div>
            <textarea id="source_code" class="main_part" placeholder="Enter oop sas class..." style="display: none;"></textarea>
        </div>
        <div class="main_part_wrapper">
            <div class="separator"></div><br>
            <div class="section_title">Compiled SAS module</div>
            <textarea id="compiled_code" class="main_part" placeholder="Get compiled sas code" style="display: none;"></textarea>
        </div>
    </div>
</div>
<footer>
    <div class="separator"></div>
    Code on <a href="https://github.com/Bassim789/oop2sas" target="_blanck">
        <img class="mini_logo" src="<?=to_img('/img/github-logo.png')?>" alt="Github logo"> Github</a>
    <div class="footer_date">
        <?=Date('Y')?>
    </div>
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
helper.init_oop_doc({
    textarea_id: 'oop_doc',
    clean_btn_id: 'icon_clean_doc'
})
helper.init_textarea({
    source_id: 'source_code', 
    compiled_id: 'compiled_code',
    clean_btn_id: 'icon_clean_source'
})

const examples = <?=json_encode($examples, true);?>;
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