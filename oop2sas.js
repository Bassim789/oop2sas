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
        this.compiled_code += `(id, method, arg1, arg2, arg3, arg4, arg5);
    %macro _; %mend _;
    %local self; %let self =  ${this.class_name};
    %local this; %let this = &self&id;
    %goto &method;
    `
    }
    print_method_name(line){
        if(this.first_method_done) this.compiled_code += `    %return;
    `
        this.compiled_code += '%' + line.trim() + `
`
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
    run(oop_code){
        this.compiled_code = ''
        this.class_name_found = false
        this.first_method_done = false
        this.class_name = false
        this.clean_source_lines = []
        var lines = oop_code.split('\n')
        for(var i = 0; i < lines.length; i++){
            this.clean_source_lines.push(lines[i])
        }
        for(var i = 0; i < this.clean_source_lines.length; i++){
            var line = this.clean_source_lines[i]
            if(this.check_class_name(line)) this.print_class_name(line)
            else if(this.check_method_name(line)) this.print_method_name(line)
            else this.print_line(line)
            if(this.check_last_line(i)) this.print_end_class()
        }
        return this.compiled_code
    }
    init(elems){
        var textarea = document.getElementById(elems.source_id)
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
        var textarea_compiled = document.getElementById(elems.compiled_id)
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