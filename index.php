<!DOCTYPE html>
<html>
<title>OOP 2 SAS compilator</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="/codemirror/lib/codemirror.css">
<script src="/codemirror/lib/codemirror.js"></script>
<script src="/codemirror/mode/sas/sas.js"></script>
<script src="/codemirror/placeHolder.js"></script>
<link rel="stylesheet" href="/oop2sas.css?v=<?=time()?>">
<script src="/oop2sas.js?v=<?=time()?>"></script>
<body>
<h1>OOP <strong>2</strong> SAS<br>Compilator</h1>
<textarea id="source_code" class="main_part" style="display: none;"></textarea>
<textarea id="compiled_code" class="main_part" style="display: none;"></textarea>
<footer>
    by <a href="https://simergie.ch" target="_blanck">Simergie</a>
    <br>
    Code on <a href="https://github.com/Bassim789/oop2sas" target="_blanck">Github</a>
    <br>
    <?=Date('Y')?> 
</footer>
</body>
<script>
const o2s = new oop2sas()
o2s.init('source_code', 'compiled_code', (source_code) => o2s.run(source_code))
o2s.set_default(`example:
    method1:
        data test;
            set test;
            level = level + 1;
        run;
    method2:
        proc sql;
            select count(*)
            from sashelp.class;
            create table foo as
            select * from sashelp.class;
        quit;`
)
</script>
</html>