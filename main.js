function oop2sas(){
    this.clean_source_lines = [];
    this.compiled_code = ''
    this.class_name_found = false
    this.first_method_done = false
    this.class_name = false
    this.endswith = (str, suffix) => str.indexOf(suffix, str.length - suffix.length) !== -1
    this.check_class_name = (line) => this.endswith(line.trim(' '), ':') && !this.class_name_found
    this.check_method_name = (line) => this.endswith(line.trim(), ':')
    this.check_last_line = (line_num) => line_num === this.clean_source_lines.length - 1
    this.print_class_name = (line) => {
        this.class_name = line.split(':')[0].trim()
        this.class_name_found = true;
        this.compiled_code += '%macro ' + this.class_name
        this.compiled_code += `(id, method, arg1, arg2, arg3, arg4, arg5);
    %local self; %let self =  ${this.class_name};
    %local this; %let this = &self&id;
    %goto &method;
    `
    }
    this.print_method_name = (line) => {
        if(this.first_method_done) this.compiled_code += `    %return;
    `
        this.compiled_code += '%' + line.trim() + `
`
        this.first_method_done = true
    }
    this.print_line = (line) => {
        this.compiled_code += line + `
`
     }
    this.print_end_class = () => {
        this.compiled_code += `    %return;
%mend;`
    }
    this.run_oop2sas = (oop_code) => {
        this.compiled_code = ''
        this.class_name_found = false
        this.first_method_done = false
        this.class_name = false
        this.clean_source_lines = []
        var lines = oop_code.split('\n')
        for(var i = 0; i < lines.length; i++){
            if(lines[i].trim() !== ''){
                this.clean_source_lines.push(lines[i])
            }
        }
        for(var i = 0; i < this.clean_source_lines.length; i++){
            var line = this.clean_source_lines[i]
            if(line.trim() === ''){
                if(this.check_last_line(i)) this.print_end_class()
                continue
            }
            if(this.check_class_name(line)) this.print_class_name(line)
            else if(this.check_method_name(line)) this.print_method_name(line)
            else this.print_line(line)
            if(this.check_last_line(i)) this.print_end_class()
        }
        return this.compiled_code
    }
    this.init = (source_id, compiled_id, action) => {
        var textarea = document.getElementById(source_id)
        this.editor_source = CodeMirror.fromTextArea(textarea, {
            mode: "javascript",
            lineNumbers: true,
            indentUnit: 4,
            indentWithTabs: true,
            viewportMargin: Infinity,

        })
        this.editor_source.setSize('50%', 'auto') 
        this.editor_source.on('change', () => {
            this.editor_compiled.setValue(action(this.editor_source.getValue()))
        })
        var textarea_compiled = document.getElementById(compiled_id)
        this.editor_compiled = CodeMirror.fromTextArea(textarea_compiled, {
            mode: "javascript",
            lineNumbers: true,
            indentUnit: 4,
            indentWithTabs: true,
            viewportMargin: Infinity,

        })
        this.editor_compiled.setSize('50%', 'auto')
    }    
}