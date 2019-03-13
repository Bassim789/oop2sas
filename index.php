<!DOCTYPE html>
<html>
<title>OOP 2 SAS compilator</title>
<link rel="icon" href="/img/o2-logo.png">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="/codemirror/lib/codemirror.css">
<script src="/codemirror/lib/codemirror.js"></script>
<script src="/codemirror/mode/sas/sas.js?v=<?=time()?>"></script>
<script src="/codemirror/placeHolder.js"></script>
<link rel="stylesheet" href="/style.css?v=<?=time()?>">
<script src="/oop2sas.js?v=<?=time()?>"></script>
<script src="/code_mirror_helper.js?v=<?=time()?>"></script>
<body>
<h1>OOP<strong>2</strong>SAS</h1>
<div class="main_body">
    <div id="icon_clean_source"><img src="/img/cross.png"></div>
    <textarea id="source_code" class="main_part" placeholder="Enter oop sas code..." ></textarea>
    <textarea id="compiled_code" class="main_part" placeholder="Get compiled sas code""></textarea>
</div>
<footer>
    by <a href="https://simergie.ch" target="_blanck">
        <img class="mini_logo"src="/img/logo_simergie.png"> Simergie</a>
    <br>
    Code on <a href="https://github.com/Bassim789/oop2sas" target="_blanck">
        <img class="mini_logo"src="/img/github-logo.png"> Github</a>
    <br>
    <?=Date('Y')?> 
</footer>
</body>
<script>
const helper = new code_mirror_helper()
const compilator = new oop2sas()
helper.init_compilator(compilator)
helper.init_textarea({
    source_id: 'source_code', 
    compiled_id: 'compiled_code',
    clean_btn_id: 'icon_clean_source'
})
const source_url = '/example1_calculator.txt?v=<?=time()?>'
$.get(source_url, (source) => helper.set_default_source(source))
</script>
</html>