<?php 
error_reporting(-1);
?>
<!DOCTYPE html>
<html>
<title>OOP 2 SAS compilator</title>
<link href="/img/o2-logo.png" rel="icon">
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
    <button class="button_source" example_name="basic_example">
        Basic example
    </button>
    <button class="button_source" example_name="example_calculator">
        Example calculator
    </button>
    <button class="button_source" example_name="example_timer">
        Example timer
    </button>
</div>
<div class="main_body">
    <div id="icon_clean_source"><img src="/img/cross.png?v=2"></div>
    <textarea id="source_code" class="main_part" placeholder="Enter oop sas code..." ></textarea>
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
helper.init_textarea({
    source_id: 'source_code', 
    compiled_id: 'compiled_code',
    clean_btn_id: 'icon_clean_source'
})
<?php 
$path = dirname(__FILE__);
$ext = '.oop2.sas';
?>
const examples = {
    basic_example: `<?=file_get_contents($path.'/example/'.'basic_example'.$ext)?>`,
    example_calculator: `<?=file_get_contents($path.'/example/'.'example_calculator'.$ext)?>`,
    example_timer: `<?=file_get_contents($path.'/example/'.'example_timer'.$ext)?>`
}
helper.set_default_source(examples.basic_example)
$('body').on('click', '.button_source', function (){
    const example_name = $(this).attr('example_name')
    helper.set_default_source(examples[example_name])
})
</script>
</html>