%calculator(init_nb_var_set);

%calculator(set, number, 333, obj=1);
%calculator(set, number, 11, obj=2);

%calculator(double_var, number, obj=1);
%calculator(double_var, number, obj=2);

%put result = %calculator(get, number, obj=1);
%put result = &calculator1_number;

%put result2 = %calculator(get, number, obj=2);
%put result2 = &calculator2_number;

%put nb_var_set = %calculator(get, nb_var_set);
%put nb_var_set = &calculator_nb_var_set;