<!DOCTYPE html>
<html>
<title>OOP 2 SAS compilator</title>
<link href="/img/o2-logo.png" rel="icon">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="/codemirror/lib/codemirror.css" rel="stylesheet">
<script src="/codemirror/lib/codemirror.js"></script>
<script src="/codemirror/placeHolder.js"></script>
<link href="/codemirror/theme/monokai.css?v=<?=time()?>" rel="stylesheet">
<script src="/codemirror/mode/sas/sas.js?v=<?=time()?>"></script>
<link href="/style.css?v=<?=time()?>" rel="stylesheet" >
<script src="/oop2sas.js?v=<?=time()?>"></script>
<script src="/code_mirror_helper.js?v=<?=time()?>"></script>
<body>
<h1>OOP<strong>2</strong>SAS</h1>
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
    mode: 'sas',
    theme: 'monokai',
    compilator: new oop2sas()
})
helper.init_textarea({
    source_id: 'source_code', 
    compiled_id: 'compiled_code',
    clean_btn_id: 'icon_clean_source'
})
<?php
$source_examples = ['calculator', 'timer'];
$source_example = $source_examples[array_rand($source_examples)];
$source_file = dirname(__FILE__).'/example/'.$source_example.'.oop2.sas';
?>
const source = `<?=file_get_contents($source_file)?>`;
helper.set_default_source(source)
</script>
</html>