class oop2sas{
    constructor(){
        this.return_0_indend = `
`       
        this.return_1_indend = this.return_0_indend + '    '
    }
    check_class_name(line){ 
        return line.trim(' ').endsWith(':') && !this.class_name_found 
    }
    check_method_name(line){ 
        return line.trim().endsWith(':') && !line.startsWith('      ')
    }
    check_last_line(){ 
        return this.line_number === this.source_lines.length - 1 && this.first_method_done
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
    %local this; %let this = &self&obj;` + this.return_0_indend
    }
    remove_empty_lines(){
        let number_of_empty_line = 0
        while(1){
            let last_line = this.source_lines[this.line_number - (number_of_empty_line + 1)]
            last_line = last_line.replace(/\t/g, '').replace(/ /g, '')
            if(last_line === ''){
                number_of_empty_line++
                const compiled_array = this.compiled_code.split('\n')
                const one_more = number_of_empty_line === 1 ? 1 : 0
                const length = compiled_array.length - (1 + one_more)
                this.compiled_code = compiled_array.slice(0, length).join('\n')    
            } else {
                return number_of_empty_line
            }
        }
    }
    print_method_name_with_args(line){
        let arg_str = line.split('(')[1].split(')')[0]
        let args = arg_str.split(',')
        let method_name = line.split('(')[0]
        this.compiled_code += '%' + method_name.trim() + ':' + this.return_0_indend           
        for (let i = 0; i < args.length ; i++) {
            let varname = args[i].trim()
            this.compiled_code += `        %local ${varname}; %let ${varname} = &arg${i + 1};` 
            this.compiled_code += this.return_0_indend
        }
    }
    print_method_name(line){
        if(this.first_method_done){
            const number_of_empty_line = this.remove_empty_lines()
            if(number_of_empty_line > 0){
                this.compiled_code += this.return_0_indend + '    %return;' + this.return_0_indend
                this.compiled_code += this.return_1_indend.repeat(number_of_empty_line)
            } else {
                this.compiled_code += '    %return;' + this.return_1_indend
            }
        } else { 
            this.compiled_code += '    %goto &method; ' + this.return_1_indend 
            this.compiled_code += '%macro bringBackColor; %mend bringBackColor;' 
            this.compiled_code += this.return_1_indend + this.return_1_indend
        }
        if(line.split('(').length > 1){
            this.print_method_name_with_args(line)
        } else {
            this.compiled_code += '%' + line.trim() + this.return_0_indend
        }
        this.first_method_done = true
    }
    print_line(line){
        this.compiled_code += line
        if(this.class_name_found || this.source_lines.length > 1){
            this.compiled_code += this.return_0_indend
        }
    }
    print_end_class(){
        this.compiled_code += '    %return;' + this.return_0_indend + '%mend;'
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
    run(source_code){
        this.compiled_code = ''
        this.class_name_found = false
        this.first_method_done = false
        this.class_name = false
        this.nb_max_arg = 0
        this.line_number = 0
        this.source_lines = source_code.split('\n')
        for(let i = 0; i < this.source_lines.length; i++){
            this.line_number = i
            let line = this.source_lines[i]
            if(this.check_method_name(line)) this.get_max_arg(line)
        }
        for(let i = 0; i < this.source_lines.length; i++){
            this.line_number = i
            let line = this.source_lines[i]
            if(this.check_class_name(line)) this.print_class_name(line)
            else if(this.check_method_name(line)) this.print_method_name(line)
            else this.print_line(line)
            if(this.check_last_line()) this.print_end_class()
        }
        return this.compiled_code
    }
}