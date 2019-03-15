<?php 
error_reporting(-1);
?>
<!DOCTYPE html>
<html>
<title>OOP 2 SAS compilator</title>
<link href="/img/o2-logo.png" rel="icon">
<meta name="theme-color" content="#272822">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="/codemirror/lib/codemirror.css" rel="stylesheet">
<script src="/codemirror/lib/codemirror.js"></script>
<script src="/codemirror/placeHolder.js"></script>
<script src="/codemirror/code_mirror_mode_simple.js"></script>
<link href="/codemirror/theme/monokai.css?v=<?=time()?>" rel="stylesheet">
<script src="/codemirror/mode/sas/sas.js?v=<?=time()?>"></script>
<script src="/codemirror/mode/oop2sas/oop2sas.js?v=<?=time()?>"></script>
<link href="/style.css?v=<?=time()?>" rel="stylesheet" >
<script src="/oop2sas.js?v=<?=time()?>"></script>
<script src="/code_mirror_helper.js?v=<?=time()?>"></script>
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
<div class="icon_clean_source" id="icon_clean_source_oop"><img src="/img/cross.png?v=2"></div>
<textarea id="oop_code" placeholder="Enter oop sas code..." ></textarea>
<div class="main_body">
    <div class="icon_clean_source" id="icon_clean_source"><img src="/img/cross.png?v=2"></div>
    <textarea id="source_code" class="main_part" placeholder="Enter oop sas class..." ></textarea>
    <textarea id="compiled_code" class="main_part" placeholder="Get compiled sas code"></textarea>
</div>
<footer>
    by <a href="https://simergie.ch" target="_blanck">
        <img class="mini_logo" src="/img/logo_simergie.png"> Simergie</a>
    <br>
    Code on <a href="https://github.com/Bassim789/oop2sas" target="_blanck">
        <img class="mini_logo" src="/img/github-logo.png?v=2"> Github</a>
    <br>
    <?=Date('Y')?> 
</footer>
</body>
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
$('body').on('click', '.button_source', function (){
    const example_name = $(this).attr('example_name')
    helper.set_default_source(examples[example_name])
    $('.button_source').removeClass('selected')
    $(this).addClass('selected')
})
</script>
</html>