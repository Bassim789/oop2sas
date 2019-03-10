<!DOCTYPE html>
<html>
<title>OOP 2 SAS compilator</title>
<link rel="icon" href="/img/o2-logo.png">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="/codemirror/lib/codemirror.css">
<script src="/codemirror/lib/codemirror.js"></script>
<script src="/codemirror/mode/sas/sas.js"></script>
<script src="/codemirror/placeHolder.js"></script>
<link rel="stylesheet" href="/oop2sas.css?v=<?=time()?>">
<script src="/oop2sas.js?v=<?=time()?>"></script>
<body>
<h1>OOP <strong>2</strong> SAS</h1>
<div id="icon_clean_source"><img src="/img/cross.png"></div>
<textarea id="source_code" class="main_part" placeholder="Enter oop sas code..." ></textarea>
<textarea id="compiled_code" class="main_part" placeholder="Get compiled sas code""></textarea>
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
const o2s = new oop2sas()
o2s.init({
    source_id: 'source_code', 
    compiled_id: 'compiled_code',
    clean_btn_id: 'icon_clean_source'
})
o2s.set_default(`/* a small example */
calculator:
    init_nb_var_set:
        %global &self._nb_var_set; %let &self._nb_var_set = 0;
    set:
        %let &self._nb_var_set = %eval(&&&self._nb_var_set + 1);
        %global &this._&arg1; %let &this._&arg1 = &arg2;
    get:
        &&&this._&arg1
    double:
        %eval(2 * &arg1)
    double_var:
        %let &this._&arg1 = %&self(&id, double, &&&this._&arg1);
    save:
        data &arg1;
            set &arg1;
            nb_var_set = &&&self._nb_var_set
        run;`
)
</script>
</html>