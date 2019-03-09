<!DOCTYPE html>
<html>
<title>OOP 2 SAS compilator</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="/main.css?t=<?=time()?>">
<link rel="stylesheet" href="/codemirror/lib/codemirror.css">
<link rel="stylesheet" href="/codemirror/theme/lia.css">
<body>
<a href="https://github.com/Bassim789/oop2sas" target="_blanck" id="github_btn">
    <img src="/github-logo.jpg">
</a>
<textarea id="source_code" class="main_part"
    placeholder="Enter OOP SAS code..." style="display: none;"></textarea>
<textarea id="compiled_code" class="main_part" style="display: none;"></textarea>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="/codemirror/lib/codemirror.js"></script>
<script src="/codemirror/mode/python/python.js"></script>
<script src="/codemirror/mode/javascript/javascript.js"></script>
<script src="/codemirror/mode/lia/lia.js"></script>
<script src="/codemirror/placeHolder.js"></script>
<script src="/main.js?t=<?=time()?>"></script>
<script>
var o2s = new oop2sas()
o2s.init('source_code', 'compiled_code', (source_code) => o2s.run_oop2sas(source_code))
</script>
</html>