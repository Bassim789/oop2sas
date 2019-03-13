timer:
    %local table_report; %let table_report = report;
    %local table_add; %let table_add = add_to_report;

    new:
        %&self(set, steps, )
    
    set(varname, value):
        %global &this._&varname; 
        %let &this._&varname = &value;
        
    get(varname):
        &&&this._&varname
        
    set_now(varname):
        %global &this._&varname;
        %let &this._&varname = %sysfunc(datetime());
        
    start(step_name):
        %let &this._steps = &&&this._steps &step_name;
        %&self(set_now, start_&step_name)
        %put ********* START &step_name *********;
        
    finish(step_name):
        %&self(set_now, finish_&step_name)
        
    start_total:
        %&self(set_now, total_start)
        
    finish_total:
        %local total;
        %let total = %sysevalf(%sysfunc(datetime()) - &&&this._total_start);
        %&self(set, total_duration, &total)
        
    init_report:
        proc format;
            picture pct
            low-high = '009.99%';
        run;
        data &table_report;
            informat name $255. duration $255. percent $255.;
            name = "temp";
            duration = "temp";
            percent = "temp";
            output;
        run;
        data &table_report;
            modify &table_report;
            remove; 
        run;
        
    add_log(name, duration, percent):
        data &table_add;
            informat name $255. duration $255. percent $255.;
            name = "&name";
            duration = "&duration";
            percent = "&percent";
            output;
        run;
        proc append 
            base = &table_report
            data = &table_add
            force;
        run;
        
    add_duration(step_name):
        %local total start finish duration percent;
        %let total = &&&this._total_duration;
        %let start = &&&this._start_&step_name;
        %let finish = &&&this._finish_&step_name;
        %let duration = %sysevalf(&finish - &start);
        %let percent = %sysfunc(round(&duration / &total * 100, 0.01));
        %&self(add_log, &step_name, 
            %sysfunc(putn(&duration, time13.2)), 
            %sysfunc(putn(&percent, pct.))
        )
        
    add_all_duration:
        %local steps i;
        %let steps = %&self(get, steps);
        %do i=1 %to %sysfunc(countw(&steps));
            %&self(add_duration, %scan(&steps, &i))
        %end;
        
    add_total_duration:
        %&self(add_log, Total, 
            %sysfunc(putn(&&&this._total_duration, time13.2)), 
            %sysfunc(putn(100, pct.))
        )
        
    print_all_duration:
        title Durée des étapes;
        proc print data = &table_report double NOOBS SPLIT = "";
            label name = Etape;
            label duration = Durée;
            label percent = %;
            var name duration percent; 
        run;
        proc datasets nolist;
           delete &table_add &table_report;
        run;
