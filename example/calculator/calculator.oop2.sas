/* a small example */
calculator:
    %local pi; %let pi = 3.14;

    init_nb_var_set:
        %global &self._nb_var_set; %let &self._nb_var_set = 0;

    set(varname, value):
        %let &self._nb_var_set = %eval(&&&self._nb_var_set + 1);
        %global &this._&varname; %let &this._&varname = &value;

    get(varname):
        &&&this._&varname

    double(value):
        %eval(2 * &value)

    double_var(varname):
        %let &this._&varname = %&self(double, &&&this._&varname);
        
    save_data(mydata):
        data &mydata;
            set &mydata;
            nb_var_set = &&&self._nb_var_set;
        run;