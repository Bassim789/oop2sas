class code_mirror_helper{
    constructor(option){
        this.mode = option.mode
        this.theme = option.theme
        this.compilator = option.compilator
    }
    set_default_source(code){
        this.editor_source.setValue(code)
        this.editor_source.focus()
    }
    create_code_mirror(textarea_id){
        const textarea = document.getElementById(textarea_id)
        const code_mirror_instance = CodeMirror.fromTextArea(textarea, {
            mode: this.mode,
            theme: this.theme,
            lineNumbers: true,
            indentUnit: 4,
            indentWithTabs: true,
            viewportMargin: Infinity
        })
        code_mirror_instance.setSize('50%', 'auto') 
        return code_mirror_instance
    }
    init_textarea(elems){
        this.editor_compiled = this.create_code_mirror(elems.compiled_id)
        this.editor_source = this.create_code_mirror(elems.source_id)
        this.editor_source.on('change', () => {
            if(this.editor_source.getValue() !== ''){
                $('#' + elems.clean_btn_id).fadeIn(300)
            } else {
                $('#' + elems.clean_btn_id).fadeOut(300)
            }
            const source = this.editor_source.getValue()
            const compiled = this.compilator.run(source)
            this.editor_compiled.setValue(compiled)            
        })
        $('body').on('click', '#' + elems.clean_btn_id, () => {
            this.editor_source.setValue('')
            this.editor_source.focus()
        })
    }
}