class Oop2sas:
    def __init__(self):
        self.lines = []
        self.class_name_found = False
        self.first_method_done = False
        self.code_sas = ''

    def get_from_file(self, filename):
        with open(filename) as file:
            self.lines = file.read().splitlines()
    def write_sas(self):
        file = open(self.class_name + '.sas.js', 'w')
        file.write(self.code_sas)
    def get_from_raw_text(self, text):
        self.lines = text.strip().splitlines()
    def output_text(self):
        print(self.code_sas)
    def check_class_name(self, line):
        return line.strip().endswith(':') and not self.class_name_found
    def check_method_name(self, line):
        return line.strip().endswith(':')
    def check_last_line(self, line_num):
        return line_num == len(self.lines) - 1

    def print_class_name(self, line):
        self.class_name_found = True;
        self.class_name = line.split(':')[0].strip()
        self.code_sas += '%macro ' + self.class_name
        self.code_sas += """(id, method, arg1, arg2, arg3, arg4, arg5);
    %local self; %let self = """ + self.class_name + """;
    %local this; %let this = &self&id;
    %goto &method;
    """
    def print_method_name(self, line):
        if self.first_method_done:
            self.code_sas += """    %return;
    """
        self.code_sas += '%' + line.strip() + """
"""
        self.first_method_done = True
    def print_line(self, line):
        self.code_sas += line + """
"""
    def print_end_class(self):
        self.code_sas += """    %return;
%mend;"""

    def run(self):
        clean_lines = []
        for line in self.lines:
            if line.strip() != '':
                clean_lines.append(line)
        for i, line in enumerate(clean_lines):
            if line.strip() == '':
                if self.check_last_line(i):
                    self.print_end_class()
                continue
            if self.check_class_name(line):
                self.print_class_name(line)
            elif self.check_method_name(line):
                self.print_method_name(line)
            else:
                self.print_line(line)
            if self.check_last_line(i):
                self.print_end_class()

o = Oop2sas()
#o.get_from_file('calculator.oop2sas.js')
o.get_from_raw_text("""
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
    test:
        data &arg1;
            set &arg2;
        run;
""")
o.run()
#o.write_sas()
o.output_text()
