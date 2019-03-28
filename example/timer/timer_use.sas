%timer(start, test1);
/* do something */
data test;
    set sashelp.cars;
    do i=1 to 99999;
        total = i * i;
    end;
run;

%timer(start, another_thing);
/* do something else */
data test;
    set sashelp.cars;
    do i=1 to 999999;
        total = i * i;
    end;
run;

%timer(print);