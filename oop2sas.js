class oop2sas{
    constructor(){
        this.clean_source_lines = []
        this.compiled_code = ''
        this.class_name_found = false
        this.first_method_done = false
        this.class_name = false
    }
    set_default(code){ 
        this.editor_source.setValue(code)
        this.editor_source.focus()
    }
    check_class_name(line){ 
        return line.trim(' ').endsWith(':') && !this.class_name_found 
    }
    check_method_name(line){ 
        return line.trim().endsWith(':') && !line.startsWith('      ')
    }
    check_last_line(line_num){ 
        return line_num === this.clean_source_lines.length - 1 && this.first_method_done
    }
    print_class_name(line){
        this.class_name = line.split(':')[0].trim()
        this.class_name_found = true;
        this.compiled_code += '%macro ' + this.class_name
        let args = ''
        for(let i = 0; i < this.nb_max_arg; i++){
            args += ' arg' + (i + 1) + ','
        }   
        this.compiled_code += `(method,${args} obj =);
    %local self; %let self = ${this.class_name};
    %local this; %let this = &self&obj;
`
    }
    print_method_name(line){
        if(this.first_method_done){
            this.compiled_code += `    %return;
    `   } else { 
            this.compiled_code += `    %goto &method;
    %macro bringBackColor; %mend bringBackColor;
    `   }
        if(line.split('(').length > 1){
            let arg_str = line.split('(')[1].split(')')[0]
            let args = arg_str.split(',')
            let method_name = line.split('(')[0]
            this.compiled_code += '%' + method_name.trim() + `:
`           
            for (let i = 0; i < args.length ; i++) {
                let varname = args[i].trim()
                this.compiled_code += `        %local ${varname}; %let ${varname} = &arg${i + 1};
`
            }
        } else{
            this.compiled_code += '%' + line.trim() + `
`       }
        this.first_method_done = true
    }
    print_line(line){
        this.compiled_code += line
        if(this.class_name_found || this.clean_source_lines.length > 1){
            this.compiled_code += `
`
        }
    }
    print_end_class(){
        this.compiled_code += `    %return;
%mend;`
    }
    get_max_arg(line){
        let arg_max_in_line = 0;
        if(line.split('(').length > 1){
            let arg_str = line.split('(')[1].split(')')[0]
            let args = arg_str.split(',')
            arg_max_in_line = args.length
        }
        if(arg_max_in_line > this.nb_max_arg){
            this.nb_max_arg = arg_max_in_line
        }
    }
    run(oop_code){
        this.compiled_code = ''
        this.class_name_found = false
        this.first_method_done = false
        this.class_name = false
        this.clean_source_lines = []
        this.nb_max_arg = 0
        let lines = oop_code.split('\n')
        for(let i = 0; i < lines.length; i++){
            this.clean_source_lines.push(lines[i])
        }
        for(let i = 0; i < this.clean_source_lines.length; i++){
            let line = this.clean_source_lines[i]
            if(this.check_method_name(line)) this.get_max_arg(line)
        }
        for(let i = 0; i < this.clean_source_lines.length; i++){
            let line = this.clean_source_lines[i]
            if(this.check_class_name(line)) this.print_class_name(line)
            else if(this.check_method_name(line)) this.print_method_name(line)
            else this.print_line(line)
            if(this.check_last_line(i)) this.print_end_class()
        }
        return this.compiled_code
    }
    init(elems){
        let textarea = document.getElementById(elems.source_id)
        this.editor_source = CodeMirror.fromTextArea(textarea, {
            mode: 'sas',
            lineNumbers: true,
            indentUnit: 4,
            indentWithTabs: true,
            viewportMargin: Infinity,

        })
        this.editor_source.setSize('50%', 'auto') 
        this.editor_source.on('change', () => {
            if(this.editor_source.getValue() !== ''){
                $('#' + elems.clean_btn_id).fadeIn(300)
            } else {
                $('#' + elems.clean_btn_id).fadeOut(300)
            }
            this.editor_compiled.setValue(this.run(this.editor_source.getValue()))
        })
        let textarea_compiled = document.getElementById(elems.compiled_id)
        this.editor_compiled = CodeMirror.fromTextArea(textarea_compiled, {
            mode: 'sas',
            lineNumbers: true,
            indentUnit: 4,
            indentWithTabs: true,
            viewportMargin: Infinity,

        })
        this.editor_compiled.setSize('50%', 'auto')
        $('body').on('click', '#' + elems.clean_btn_id, () => {
            this.editor_source.setValue('')
            this.editor_source.focus()
        })
    }
}