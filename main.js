function oop2sas(oop_code){
    var clean_lines = [];
    var sas_code = ''
    var class_name_found = false
    var first_method_done = false

    function endswith(str, suffix) {
        return str.indexOf(suffix, str.length - suffix.length) !== -1
    }
    function check_class_name(line){
        return endswith(line.trim(' '), ':') && !class_name_found
    }
    function check_method_name(line){
        return endswith(line.trim(), ':')
    }
    function check_last_line(line_num){
        return line_num === clean_lines.length - 1
    }
    function print_class_name(line){
        class_name_found = true;
        class_name = line.split(':')[0].trim()
        sas_code += '%macro ' + class_name
        sas_code += `(id, method, arg1, arg2, arg3, arg4, arg5);
    %local self; %let self =  ${class_name};
    %local this; %let this = &self&id;
    %goto &method;
    `
    }
    function print_method_name(line){
        if(first_method_done) sas_code += `    %return;
    `
        sas_code += '%' + line.trim() + `
`
        first_method_done = true
    }
    function print_line(line){
        sas_code += line + `
`
     }
     function print_end_class(){
        sas_code += `    %return;
%mend;`
    }
    function run(oop_code){
        clean_lines = []
        var lines = oop_code.split('\n')
        for(var i = 0; i < lines.length; i++){
            if(lines[i].trim() !== ''){
                clean_lines.push(lines[i])
            }
        }
        for(var i = 0; i < clean_lines.length; i++){
            var line = clean_lines[i]
            if(line.trim() === ''){
                if(check_last_line(i)) print_end_class()
                continue
            }
            if(check_class_name(line)) print_class_name(line)
            else if(check_method_name(line)) print_method_name(line)
            else print_line(line)
            if(check_last_line(i)) print_end_class()
        }
    }
    run(oop_code)
    return sas_code
}
$(function(){
    var textarea = document.getElementById('oop_code')
    editor = CodeMirror.fromTextArea(textarea, {
        mode: "javascript",
        lineNumbers: true,
        indentUnit: 4,
        indentWithTabs: true,
        viewportMargin: Infinity,

    })
    editor.setSize('50%', 'auto') 
    editor.on('change', function() {
        editor_sas.setValue(oop2sas(editor.getValue()))
    })
    var textarea_sas = document.getElementById('sas_code')
    editor_sas = CodeMirror.fromTextArea(textarea_sas, {
        mode: "javascript",
        lineNumbers: true,
        indentUnit: 4,
        indentWithTabs: true,
        viewportMargin: Infinity,

    })
    editor_sas.setSize('50%', 'auto') 
})